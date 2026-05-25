/* =============================================
   TaskFlow — script.js
   Theme, Navigation, Animations, Validation
   ============================================= */

// ─── Theme Toggle ────────────────────────────
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;

// Load saved theme
const savedTheme = localStorage.getItem('taskflow-theme') || 'light';
html.setAttribute('data-theme', savedTheme);

if (themeToggle) {
  themeToggle.addEventListener('click', () => {
    const current = html.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('taskflow-theme', next);
  });
}

// ─── Mobile Nav Toggle ───────────────────────
const navToggle = document.getElementById('navToggle');
const navLinks  = document.getElementById('navLinks');

if (navToggle && navLinks) {
  navToggle.addEventListener('click', () => {
    navLinks.classList.toggle('open');
  });
  // Close nav on link click
  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => navLinks.classList.remove('open'));
  });
}

// ─── Navbar scroll shadow ────────────────────
const navbar = document.getElementById('navbar');
if (navbar) {
  window.addEventListener('scroll', () => {
    navbar.style.boxShadow = window.scrollY > 10
      ? '0 4px 24px rgba(0,0,0,0.08)'
      : 'none';
  });
}

// ─── Animated counters ───────────────────────
function animateCounter(el) {
  const target = parseInt(el.getAttribute('data-target'), 10);
  const duration = 1600;
  const step = target / (duration / 16);
  let current = 0;

  const tick = () => {
    current += step;
    if (current >= target) {
      el.textContent = target.toLocaleString();
    } else {
      el.textContent = Math.floor(current).toLocaleString();
      requestAnimationFrame(tick);
    }
  };
  tick();
}

const counters = document.querySelectorAll('.stat-num');
if (counters.length) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(c => observer.observe(c));
}

// ─── Form Validation (shared) ────────────────
function validateForm(formId, rules) {
  const form = document.getElementById(formId);
  if (!form) return;

  form.addEventListener('submit', function(e) {
    let valid = true;

    rules.forEach(rule => {
      const group = form.querySelector(`[name="${rule.name}"]`)?.closest('.form-group');
      const input = form.querySelector(`[name="${rule.name}"]`);
      if (!input || !group) return;

      const val = input.value.trim();
      let errorMsg = '';

      if (rule.required && !val) {
        errorMsg = rule.emptyMsg || 'Câmpul este obligatoriu.';
      } else if (rule.minLength && val.length < rule.minLength) {
        errorMsg = rule.shortMsg || `Minim ${rule.minLength} caractere.`;
      } else if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        errorMsg = rule.emailMsg || 'Email invalid.';
      } else if (rule.match) {
        const matchVal = form.querySelector(`[name="${rule.match}"]`)?.value.trim();
        if (val !== matchVal) errorMsg = rule.matchMsg || 'Câmpurile nu coincid.';
      }

      const errEl = group.querySelector('.error-msg');
      if (errorMsg) {
        group.classList.add('has-error');
        input.classList.add('error');
        if (errEl) errEl.textContent = errorMsg;
        valid = false;
      } else {
        group.classList.remove('has-error');
        input.classList.remove('error');
      }
    });

    if (!valid) e.preventDefault();
  });

  // Live clear errors
  form.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', () => {
      const group = input.closest('.form-group');
      if (group) {
        group.classList.remove('has-error');
        input.classList.remove('error');
      }
    });
  });
}

// ─── Auto-hide alerts ────────────────────────
document.querySelectorAll('.alert').forEach(alert => {
  setTimeout(() => {
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  }, 4000);
});

// ─── Smooth anchor scroll ────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
