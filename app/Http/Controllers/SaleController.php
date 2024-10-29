<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::user()->role === 'admin') {
            return view('dashboard.sales.index', [
                'sales' => Sale::all()
            ]);
        } else if (Auth::user()->role === 'seller') {
            $productIds = Product::where('seller_id', Auth::user()->id)->pluck('id');
            $sale = Sale::whereIn('product_id', $productIds)->paginate(10);
            return view('dashboard.sales.index', ['sales' => $sale]);
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        //
        $request->validated();
        $cartItems = $request->input('cartItems');
        $quantities = $request->input('quantities');
        $userId = Auth::user()->id;


        // Retrieve the user's wallet
        $wallet = Wallet::where('user_id', $userId)->first();
        if (!$wallet) {
            return redirect()->back()->with('error', 'Wallet not found.');
        }


        try {
            $totalAmount = 0;
            foreach ($cartItems as $cartId) {
                $cart = Sale::find($cartId);
                if ($cart && $cart->wallet_id == Auth::user()->wallet->id && $cart->status == 'pending') {
                    $quantity = $quantities[$cartId] ?? 1; // Default to 1 if quantity not found
                    $totalAmount += $cart->product->price * $quantity;
                }
            }

            // Check if wallet has enough balance
            if ($wallet->balance < $totalAmount) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Insufficient balance.');
            }

            foreach ($cartItems as $cartId) {
                $cart = Sale::find($cartId);
                if ($cart && $cart->wallet->id == Auth::user()->wallet->id && $cart->status == 'pending') {
                    $quantity = $quantities[$cartId] ?? 1; // Default to 1 if quantity not found
                    $cart->update([
                        'status' => 'completed',
                        'quantity' => $quantity,
                    ]);
                    // Create a new transaction for each sale
                    Transaction::create([
                        'wallet_id' => $wallet->id,
                        'sale_id' => $cart->id,
                        'type' => 'purchase',
                        'amount' => $cart->product->price * $quantity,
                    ]);
                }
            }

            // Deduct the total amount from the wallet
            $wallet->balance -= $totalAmount;
            $wallet->save();
            //menampilkan log
            Log::info('Checkout successful', ['user_id' => $userId, 'total_amount' => $totalAmount]);
            DB::commit();
            return redirect()->route('carts.index')->with('success', 'Checkout successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout failed. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //

        return view('dashboard.sales.show', [
            'sale' => $sale
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
