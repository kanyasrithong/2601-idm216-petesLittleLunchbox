// alpha/js/ui.js
import {
    getCart,
    getCartCount,
    removeFromCart,
    setQty,
    wasJustAdded,
    clearJustAdded
  } from "./app.js";
  
  /* =========================
     HOME: bag badge
     ========================= */
  export function mountHomeBadge() {
    const badge = document.getElementById("bagBadge");
    if (!badge) return;
  
    const count = getCartCount();
    renderBadge(badge, count);
  
    if (count > 0 && wasJustAdded()) {
      pulseBadge(badge);
      clearJustAdded();
    }
  }
  
  function renderBadge(badgeEl, count) {
    if (count <= 0) {
      badgeEl.classList.add("is-hidden");
      badgeEl.textContent = "";
      return;
    }
    badgeEl.classList.remove("is-hidden");
    badgeEl.textContent = String(count);
  }
  
  function pulseBadge(badgeEl) {
    badgeEl.classList.remove("pulse");
    void badgeEl.offsetWidth; // restart animation
    badgeEl.classList.add("pulse");
  }
  
  /* =========================
     BAG: pickup option toggle
     ========================= */
     function mountPickupOptions() {
        const asapBtn = document.getElementById("pickupAsap");
        const schedWrap = document.getElementById("pickupScheduledWrap");
        const timeSelect = document.getElementById("pickupTimeSelect");
      
        if (!asapBtn || !schedWrap || !timeSelect) return;
      
        const STORAGE_CHOICE = "pickupChoice";
        const STORAGE_TIME = "pickupTime";
      
        function apply(choice) {
          asapBtn.classList.toggle("is-selected", choice === "asap");
          schedWrap.classList.toggle("is-selected", choice === "scheduled");
        }
      
        // load saved state
        const savedChoice = localStorage.getItem(STORAGE_CHOICE) || "asap";
        const savedTime = localStorage.getItem(STORAGE_TIME) || "";
      
        if (savedTime) timeSelect.value = savedTime;
      
        // if they already picked a time before, show scheduled as selected
        apply(savedTime ? "scheduled" : savedChoice);
      
        // ASAP click
        asapBtn.addEventListener("click", () => {
          localStorage.setItem(STORAGE_CHOICE, "asap");
          apply("asap");
        });
      
        // Clicking the schedule box should select it + open dropdown
        schedWrap.addEventListener("click", () => {
          localStorage.setItem(STORAGE_CHOICE, "scheduled");
          apply("scheduled");
          timeSelect.focus();
          timeSelect.click(); // helps open on some browsers
        });
      
        // Changing time should select schedule + save
        timeSelect.addEventListener("change", () => {
          localStorage.setItem(STORAGE_CHOICE, "scheduled");
          localStorage.setItem(STORAGE_TIME, timeSelect.value);
          apply("scheduled");
        });
      }
  
  /* =========================
     BAG: render + empty state
     ========================= */
  export function mountBagPage() {
    mountPickupOptions();
  
    const empty = document.getElementById("bagEmpty");
    const list = document.getElementById("bagList");
    const totalEl = document.getElementById("bagTotal");
    const checkoutBtn = document.getElementById("bagCheckout");
  
    if (!empty || !list || !totalEl) return;
  
    const cart = getCart();
  
    // EMPTY BAG
    if (cart.length === 0) {
      empty.style.display = "flex";
      list.style.display = "none";
      totalEl.textContent = "$0.00";
  
      // hide proceed button when empty
      if (checkoutBtn) checkoutBtn.style.display = "none";
      return;
    }
  
    // BAG HAS ITEMS
    empty.style.display = "none";
    list.style.display = "flex";
    if (checkoutBtn) checkoutBtn.style.display = "flex";
  
    // render items
    list.innerHTML = cart
      .map((item, idx) => {
        const price = Number(item.price || 0);
        return `
          <article class="bag-item" data-index="${idx}">
            <div class="bag-item-row">
              <img class="bag-item-img" src="${item.img}" alt="${escapeHtml(item.name)}" />
              <div class="bag-item-content">
                <div class="bag-item-topline">
                  <div class="bag-item-text">
                    <p class="bag-item-name">${escapeHtml(item.name)}</p>
                    ${item.subtitle ? `<p class="bag-item-addon">${escapeHtml(item.subtitle)}</p>` : ``}
                  </div>
  
                  <div class="bag-item-right">
                    <p class="bag-item-price">$${price.toFixed(2)}</p>
                    <button class="trash-btn" type="button" data-action="remove" aria-label="Remove item">🗑</button>
                  </div>
                </div>
  
                <div class="bag-item-bottomline">
                  <a class="edit-btn" href="${item.editHref || "customize.html"}">EDIT ✎</a>
  
                  <div class="qty-controls">
                    <button class="qty-btn" type="button" data-action="dec" aria-label="Decrease quantity">−</button>
                    <p class="qty-num">${item.qty}</p>
                    <button class="qty-btn" type="button" data-action="inc" aria-label="Increase quantity">+</button>
                  </div>
                </div>
              </div>
            </div>
          </article>
        `;
      })
      .join("");
  
    // compute total
    const total = cart.reduce(
      (sum, item) => sum + Number(item.price || 0) * (item.qty || 1),
      0
    );
    totalEl.textContent = `$${total.toFixed(2)}`;
  
    // events (event delegation)
    list.addEventListener(
      "click",
      (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;
  
        const card = e.target.closest(".bag-item");
        if (!card) return;
  
        const index = Number(card.dataset.index);
        const action = btn.dataset.action;
  
        const cartNow = getCart();
        const cur = cartNow[index];
        if (!cur) return;
  
        if (action === "remove") {
          removeFromCart(index);
          mountBagPage();
          return;
        }
  
        if (action === "inc") {
          setQty(index, (cur.qty || 1) + 1);
          mountBagPage();
          return;
        }
  
        if (action === "dec") {
          setQty(index, (cur.qty || 1) - 1);
          mountBagPage();
          return;
        }
      },
      { once: true }
    );
  }
  
  /* =========================
     helpers
     ========================= */
  function escapeHtml(str) {
    return String(str)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }