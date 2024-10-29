<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class PageController extends Controller
{
    //

    public function index()
    {
        $categories = \App\Models\Category::all();
        $newProducts = \App\Models\Product::latest()->take(4)->get();
        return view('pages.welcome', compact('categories', 'newProducts'));
    }

    public function products(Request $request)
    {
        $category = $request->query('category');

        if ($category) {
            $products = Product::where('category_id', $category)->get();
        } else {
            $products = Product::all();
        }
        //mengambil data product yang memiliki rating diatas 4
        $topProducts = Product::withCount('ratings') // Count number of ratings per product
            ->withAvg('ratings', 'rating')            // Calculate the average rating per product
            ->orderBy('ratings_count', 'desc')        // Sort by the number of ratings
            ->orderBy('ratings_avg_rating', 'desc')   // Then sort by average rating
            ->take(4)                                // Limit to top 10 products
            ->get();
        return view('pages.products.index', [
            'categories' => \App\Models\Category::all(),
            'products' => $products,
            'topProducts' => $topProducts
        ]);
    }

    public function product($id)
    {
        $categories = \App\Models\Category::all();
        $product = Product::find($id);
        // Mengambil produk yang sesuai dengan kategori, kecuali produk yang sedang ditampilkan, dan mengacak hasilnya
        $matches = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder() // Mengacak hasil
            ->take(4) // Mengambil 4 produk
            ->get();

        $countPurchase = $product->sales->where('status', 'completed')->count();
        return view('pages.products.show', compact(
            'product',
            'categories',
            'matches',
            'countPurchase'
        ));
    }
}
