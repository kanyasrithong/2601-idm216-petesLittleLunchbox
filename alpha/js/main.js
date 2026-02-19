/* alpha/js/main.js */
import { initUI } from "./ui.js";

document.addEventListener("DOMContentLoaded", () => {
  initUI();
});

// alpha/js/main.js
import { getLastOrder } from "./app.js";

function mountOrderBanner(){
  const banner = document.getElementById("orderBanner");
  if (!banner) return;

  const last = getLastOrder();
  if (last && last.items && last.items.length > 0){
    banner.style.display = "flex";
  } else {
    banner.style.display = "none";
  }
}

mountOrderBanner();