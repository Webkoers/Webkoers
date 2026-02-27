(() => {
  const root = document.querySelector("[data-marquee]");
  if (!root) return;

  const track = root.querySelector("[data-marquee-track]");
  if (!track) return;

  // Prevent double-init (in case of partial refresh)
  if (track.dataset.init === "1") return;
  track.dataset.init = "1";

  const original = Array.from(track.children);
  if (!original.length) return;

  // Duplicate until track is at least 2x wrapper width
  const wrapperWidth = root.getBoundingClientRect().width;

  const getTrackWidth = () => track.getBoundingClientRect().width;

  // Ensure we have enough items to scroll seamlessly
  while (getTrackWidth() < wrapperWidth * 2) {
    original.forEach((node) => track.appendChild(node.cloneNode(true)));
  }

  // Duplicate full set once more so -50% animation aligns
  const setNow = Array.from(track.children);
  setNow.forEach((node) => track.appendChild(node.cloneNode(true)));

  // Set CSS variable for exact half shift
  requestAnimationFrame(() => {
    const half = track.getBoundingClientRect().width / 2;
    track.style.setProperty("--marquee-shift", `-${half}px`);
  });

  // Recalc on resize (simple + cheap)
  let raf = 0;
  window.addEventListener("resize", () => {
    cancelAnimationFrame(raf);
    raf = requestAnimationFrame(() => {
      const half = track.getBoundingClientRect().width / 2;
      track.style.setProperty("--marquee-shift", `-${half}px`);
    });
  });
})();