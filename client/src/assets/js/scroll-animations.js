(function () {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.15 }
  );

  document.querySelectorAll('.reveal').forEach(function (el) {
    observer.observe(el);
  });

  document.querySelectorAll('.reveal-children').forEach(function (parent) {
    var children = parent.children;
    for (var i = 0; i < children.length; i++) {
      children[i].classList.add('reveal-child');
      children[i].style.transitionDelay = (i * 120) + 'ms';
    }
  });
})();
