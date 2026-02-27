document.addEventListener("DOMContentLoaded", function () {
  const preloaderEl = document.getElementById("preloader");

  if (!preloaderEl) return;

  // Wacht even zodat je 'm ziet
  setTimeout(function () {
    preloaderEl.classList.add("fade-out");

    // Na de transition: echt verwijderen
    setTimeout(function () {
      preloaderEl.style.display = "none";
    }, 500); // moet matchen met CSS transition
  }, 800); // hoe lang preloader zichtbaar blijft
});