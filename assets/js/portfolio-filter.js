(() => {
  const root = document.querySelector("[data-portfolio]");
  if (!root) return;

  const filters = root.querySelectorAll("[data-filter]");
  const cards = root.querySelectorAll("[data-type]");

  if (!filters.length || !cards.length) return;

  const setActive = (btn) => {
    filters.forEach((b) => {
      const isActive = b === btn;
      b.classList.toggle("is-active", isActive);
      b.setAttribute("aria-selected", isActive ? "true" : "false");
    });
  };

  const applyFilter = (value) => {
    cards.forEach((card) => {
      const type = card.getAttribute("data-type");
      const show = value === "all" || type === value;
      card.toggleAttribute("hidden", !show);
    });
  };

  root.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-filter]");
    if (!btn) return;

    const value = btn.getAttribute("data-filter") || "all";
    setActive(btn);
    applyFilter(value);
  });

  // default
  applyFilter("all");
})();