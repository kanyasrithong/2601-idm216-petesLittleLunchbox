// alpha/js/app.js
const CART_KEY = "pll_cart_v1";
const JUST_ADDED_KEY = "pll_just_added_v1";

export function getCart() {
  try {
    return JSON.parse(localStorage.getItem(CART_KEY)) ?? [];
  } catch {
    return [];
  }
}

export function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

export function getCartCount() {
  return getCart().reduce((sum, item) => sum + (item.qty || 0), 0);
}

export function addToCart(newItem) {
  const cart = getCart();

  // simple “same item” match (later PHP will do this better)
  const key = `${newItem.id}|${JSON.stringify(newItem.options || {})}`;
  const existing = cart.find(i => `${i.id}|${JSON.stringify(i.options || {})}` === key);

  if (existing) {
    existing.qty += newItem.qty || 1;
  } else {
    cart.push({ ...newItem, qty: newItem.qty || 1 });
  }

  saveCart(cart);
  sessionStorage.setItem(JUST_ADDED_KEY, "1"); // so Home can pulse badge
}

export function removeFromCart(index) {
  const cart = getCart();
  cart.splice(index, 1);
  saveCart(cart);
}

export function setQty(index, qty) {
  const cart = getCart();
  if (!cart[index]) return;

  cart[index].qty = Math.max(1, qty);
  saveCart(cart);
}

export function wasJustAdded() {
  return sessionStorage.getItem(JUST_ADDED_KEY) === "1";
}

export function clearJustAdded() {
  sessionStorage.removeItem(JUST_ADDED_KEY);
}





export function getLastOrder(){
    try{
      const raw = localStorage.getItem("lastOrder");
      return raw ? JSON.parse(raw) : null;
    } catch(e){
      return null;
    }
  }


export function saveLastOrder(order){
    localStorage.setItem("lastOrder", JSON.stringify(order));
}


export function clearCart() {
    localStorage.removeItem(CART_KEY);
  }