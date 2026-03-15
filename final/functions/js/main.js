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

function mountCategoryFilter(){
  const chips = Array.from(document.querySelectorAll(".chips .chip"));
  const page = document.querySelector("main.page");
  const sections = Array.from(document.querySelectorAll("main.page .section"));
  if (chips.length === 0 || sections.length === 0 || !page) return;

  function setActiveChip(activeChip){
    chips.forEach(chip => chip.classList.toggle("active", chip === activeChip));
  }

  function showAll(){
    sections.forEach(section => section.classList.remove("is-hidden"));
    page.classList.remove("is-filtered");
  }

  function showSectionById(id){
    sections.forEach(section => {
      section.classList.toggle("is-hidden", section.id !== id);
    });
    page.classList.add("is-filtered");
  }

  chips.forEach(chip => {
    chip.addEventListener("click", (event) => {
      event.preventDefault();
      const href = chip.getAttribute("href") || "";

      if (href === "#" || href === "") {
        showAll();
      } else {
        const id = href.startsWith("#") ? href.slice(1) : href;
        showSectionById(id);
      }

      setActiveChip(chip);
    });
  });

  const initialHash = window.location.hash.replace("#", "");
  if (initialHash) {
    const initialChip = chips.find(chip => chip.getAttribute("href") === `#${initialHash}`);
    if (initialChip) setActiveChip(initialChip);
    showSectionById(initialHash);
  } else {
    showAll();
  }
}

mountCategoryFilter();
