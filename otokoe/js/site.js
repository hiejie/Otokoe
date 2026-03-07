// Toggle nav on mobile
document.body.classList.add('js');

var toggle    = document.querySelector('#toggle-navigation');
var menu      = document.querySelector('#menu');

if (toggle && menu) {
  toggle.addEventListener('click', function () {
    if (menu.classList.contains('is-active')) {
      this.setAttribute('aria-expanded', 'false');
      menu.classList.remove('is-active');
    } else {
      menu.classList.add('is-active');
      this.setAttribute('aria-expanded', 'true');
    }
  });
}

// Sticky header style on scroll
var header = document.getElementById('site-header');
if (header) {
  window.addEventListener('scroll', function () {
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
  anchor.addEventListener('click', function (e) {
    var target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Animate cards on scroll (Intersection Observer)
var observer = new IntersectionObserver(function (entries) {
  entries.forEach(function (entry) {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.drink-card, .menu-card, .store-card').forEach(function (card) {
  card.style.opacity = '0';
  card.style.transform = 'translateY(24px)';
  card.style.transition = 'opacity 0.5s ease, transform 0.5s ease, box-shadow 0.3s ease';
  observer.observe(card);
});
