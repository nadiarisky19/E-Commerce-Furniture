// cart container 
const cartButton = document.getElementById('cart-button');
const cartContainer = document.getElementById('cart-container');
const bodyContainer = document.querySelector('body');

let toggle  = 0;
cartButton.addEventListener('click', ()=> {
    if(toggle === 0)
    {
        cartContainer.style.visibility = 'visible';
        cartContainer.style.opacity = '1';
        cartContainer.style.height = '300px';
        cartButton.style.color = 'black';
        toggle = 1;
    }
    else 
    {
        cartContainer.style.visibility = 'hidden';
        cartContainer.style.opacity = '0';
        cartContainer.style.height = '0px';
        cartButton.style.color = 'gray';
        toggle = 0;
    }
});

//navigation 
const roomButtonContainer = document.getElementById('nav-room-container-desc')
const roomButton = document.getElementById('room-button');

let roomButtonToggle = 0;
roomButton.addEventListener('click', ()=> {
    console.log('room nav clicked')
    if(roomButtonToggle === 0)
    {
        roomButtonContainer.style.visibility = 'visible';
        roomButtonContainer.style.opacity = '1';
        roomButtonContainer.style.height = '300px'
        roomButton.style.color = 'black';
        roomButtonToggle = 1;
    }
    else 
    {
        roomButtonContainer.style.visibility = 'hidden';
        roomButtonContainer.style.opacity = '0';
        roomButtonContainer.style.height = '100px'
        roomButton.style.color = 'gray';
        roomButtonToggle = 0;
    }
});

// product container 

const productButtonContainer = document.getElementById('nav-product-container-description')
const productButton = document.getElementById('product-button');

let productButtonToggle = 0;
productButton.addEventListener('click', ()=> {
    console.log('room nav clicked')
    if(productButtonToggle === 0)
    {
        productButtonContainer.style.visibility = 'visible';
        productButtonContainer.style.opacity = '1';
        productButtonContainer.style.height = '300px'
        productButton.style.color = 'black';
        productButtonToggle = 1;
    }
    else 
    {
        productButtonContainer.style.visibility = 'hidden';
        productButtonContainer.style.opacity = '0';
        productButtonContainer.style.height = '100px'
        productButton.style.color = 'gray';
        productButtonToggle = 0;
    }
});

AOS.init();


//loader 

window.addEventListener('load', ()=> {
    const loader = document.querySelector('.loader-wrapper');
    loader.style.display = 'none';
})



// malskar chair

const mainProductImage = document.getElementById('main-product-image');
const imgComponent = document.querySelectorAll('#img-component');

imgComponent.forEach(image => {
    image.addEventListener('click', ()=> {
        removeActiveFunction();
        image.classList.add('active-chair-img');
        mainProductImage.setAttribute('src',image.getAttribute('src'));
    })
})

function removeActiveFunction()
{
    imgComponent.forEach(image => {
        image.classList.remove('active-chair-img');
    })
}
 
//stock 

const stockMinus = document.getElementById('stock-minus');
const stockPlus = document.getElementById('stock-plus');
const stockValue = document.getElementById('stock-value');

let currentStockValue = 1;
stockMinus.addEventListener('click', ()=> {
    if(currentStockValue <= 1)
    {
        currentStockValue = 1;
        stockValue.textContent = currentStockValue;
    }
    else 
    {
        currentStockValue--;
        stockValue.textContent = currentStockValue;
    }
})
stockPlus.addEventListener('click', ()=> {
    currentStockValue++;
    stockValue.textContent = currentStockValue;
})

const heartIcon = document.getElementById('heart-icon');
const addToCart = document.getElementById('add-to-cart-btn');

let toggleheart = false;
heartIcon.addEventListener('click', ()=> {
    if(toggleheart === false)
    {
        heartIcon.classList.remove('fa-regular');
        heartIcon.classList.add("fa-solid")
        toggleheart = true;
    }
    else 
    {
        heartIcon.classList.remove("fa-solid")
        heartIcon.classList.add('fa-regular');
        toggleheart = false;
    }
})


// add to cart 

const cartProduct = document.getElementById('cart-product');
const emptyCartMessage = document.getElementById('empty-cart-msg');
const trashButton = document.getElementById('cart-trash-button');
const cartPriceMessage = document.getElementById('cart-price-msg');

addToCart.addEventListener('click', ()=> {
    addToCart.classList.remove('add-to-cart-button');
    addToCart.classList.add('addedSuccessfully');
    addToCart.textContent = "Added Successfully";

    emptyCartMessage.style.display = 'none';
    cartProduct.style.display = "block";
    cartPriceMessage.innerHTML = '$ ' + 28.88 * currentStockValue;
})

trashButton.addEventListener('click', ()=> {
    cartProduct.style.display = "none";
    emptyCartMessage.style.display = 'block';
})