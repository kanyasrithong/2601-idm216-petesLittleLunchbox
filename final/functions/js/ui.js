/* =========================
    HOME: bag badge
   ========================= */
export function mountHomeBadge() {
  const badge = document.getElementById("bagBadge");
  if (!badge) return;

  const count = parseInt(document.querySelector("#bagCount").value);
  renderBadge(badge, count);

  if (count > 0) {
    pulseBadge(badge);
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
export function mountPickupOptions() {
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

  const savedChoice = localStorage.getItem(STORAGE_CHOICE) || "asap";
  const savedTime = localStorage.getItem(STORAGE_TIME) || "";

  if (savedTime) timeSelect.value = savedTime;

  // if already picked a time before, show scheduled as selected
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
    timeSelect.click();
  });

  // Changing time should select schedule + save
  timeSelect.addEventListener("change", () => {
    localStorage.setItem(STORAGE_CHOICE, "scheduled");
    localStorage.setItem(STORAGE_TIME, timeSelect.value);
    apply("scheduled");
  });
}
