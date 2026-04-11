(function () {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  document.querySelectorAll('[data-reveal]').forEach(function (el) {
    el.classList.add('reveal');
  });

  document.querySelectorAll('[data-reveal-children]').forEach(function (parent) {
    parent.classList.add('reveal');
    var children = parent.children;
    for (var i = 0; i < children.length; i++) {
      children[i].classList.add('reveal-child');
      children[i].style.transitionDelay = (i * 120) + 'ms';
    }
  });

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
})();
