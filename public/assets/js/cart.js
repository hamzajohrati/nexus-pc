//
// (function(){
//   const STORAGE_KEY = 'nexus_cart';
//
//   function getCart(){
//     try{
//       return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
//     }catch(e){ return []; }
//   }
//
//   function saveCart(cart){
//     localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
//   }
//
//   function updateBadge(){
//     const count = getCart().reduce((sum,i)=>sum + i.qty,0);
//     const badge = document.getElementById('cartCount');
//     if(badge){ badge.textContent = count; }
//   }
//
//   function addItem(item){
//     const cart = getCart();
//     const existing = cart.find(p=>p.id===item.id);
//     if(existing){
//        existing.qty += item.qty;
//     }else{
//        cart.push(item);
//     }
//     saveCart(cart);
//     updateBadge();
//   }
//
//   function removeItem(id){
//     let cart = getCart().filter(p=>p.id!==id);
//     saveCart(cart);
//     updateBadge();
//   }
//
//   function changeQty(id,delta){
//     const cart = getCart();
//     const item = cart.find(p=>p.id===id);
//     if(item){
//       item.qty += delta;
//       if(item.qty<1){ removeItem(id); return; }
//       saveCart(cart);
//       updateBadge();
//     }
//   }
//
//   // Expose globally
//   window.NexusCart = { getCart, addItem, removeItem, changeQty, updateBadge };
//
//   // Auto-update on load
//   document.addEventListener('DOMContentLoaded', updateBadge);
//
//   // Attach listeners for any .addToCart buttons
//   document.addEventListener('click', function(e){
//     const btn = e.target.closest('.addToCart');
//     if(!btn) return;
//     const id = btn.dataset.id;
//     const name = btn.dataset.name;
//     const price = parseFloat(btn.dataset.price);
//     if(!id || !name || isNaN(price)) return;
//     addItem({ id, name, price, qty: 1 });
//     // simple toast
//     if(typeof bootstrap!=='undefined'){
//       let toastEl = document.getElementById('cartToast');
//       if(!toastEl){
//         toastEl = document.createElement('div');
//         toastEl.className = 'toast position-fixed bottom-0 end-0 m-3';
//         toastEl.id='cartToast';
//         toastEl.innerHTML = '<div class="toast-body">Added to cart!</div>';
//         document.body.appendChild(toastEl);
//       }
//       const toast = new bootstrap.Toast(toastEl);
//       toast.show();
//     }else{
//       alert('Added to cart');
//     }
//   });
//
// })();
