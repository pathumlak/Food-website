let serachForm = document.querySelector('.searchForm');


document.querySelector('#search-btn').onclick =() =>{
    serachForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItems.classList.remove('active');
}

let cartItems = document.querySelector('.shopping-cart');


document.querySelector('#cart-btn').onclick =()=>{
    cartItems.classList.toggle('active');
    serachForm.classList.remove('active');
    navbar.classList.remove('active');

}

let navbar = document.querySelector('.navbar');


document.querySelector('#menu-btn').onclick =()=>{
    navbar.classList.toggle('active');
    serachForm.classList.remove('active');
    cartItems.classList.remove('active');

}

window.onscroll = ()=>{
    navbar.classList.toggle('active');
    serachForm.classList.remove('active');
    cartItems.classList.remove('active');
} 

function toggleUserBox() {
  const userBox = document.getElementById('user-box');
 

  if (userBox.style.display === 'block') {
      userBox.style.display = 'none';
  } else {
      ;
      userBox.style.display = 'block';
  }
}

  
  function login() {
    // Implement login functionality here
    console.log("Login button clicked");
  }
  
  function register() {
    // Implement register functionality here
    console.log("Register button clicked");
  }
  
