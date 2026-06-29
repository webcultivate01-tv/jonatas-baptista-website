// ═══════════════════════════════════════════════════════
// Jonatas Baptista - Real Estate Coach Website
// Main JavaScript - Animations & Interactions
// ═══════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', function() {
  'use strict';

  // ── Page Load Animation
  document.body.classList.add('loaded');

  // ── Mobile Menu
  const menuBtn = document.getElementById('menuBtn');
  const menuClose = document.getElementById('menuClose');
  const mobileMenu = document.getElementById('mobileMenu');
  
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
    
    if (menuClose) {
      menuClose.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        document.body.style.overflow = '';
      });
    }
  }

  // ── Navbar Scroll Effect
  const header = document.getElementById('siteHeader');
  
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

  // ── Scroll Reveal Animation
  const revealElements = document.querySelectorAll('.reveal, .reveal-delay-1, .reveal-delay-2, .reveal-delay-3, .reveal-delay-4');
  
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  });

  revealElements.forEach(el => {
    revealObserver.observe(el);
  });

  // ── Card Lift Effect
  const cards = document.querySelectorAll('.card-lift');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });

  // ── Counter Animation
  const counterElements = document.querySelectorAll('[data-counter]');
  
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = parseInt(entry.target.dataset.target);
        const suffix = entry.target.dataset.suffix || '';
        animateCounter(entry.target, 0, target, 2000, suffix);
        counterObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counterElements.forEach(el => {
    counterObserver.observe(el);
  });

  function animateCounter(element, start, end, duration, suffix) {
    const startTime = performance.now();
    
    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      
      const easeOutQuart = 1 - Math.pow(1 - progress, 4);
      const current = Math.floor(start + (end - start) * easeOutQuart);
      
      element.textContent = current + suffix;
      
      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }
    
    requestAnimationFrame(update);
  }

  // ── Smooth Scroll for Anchor Links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href !== '#' && href !== '#0') {
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
  });

  // ── WhatsApp Float Button Animation
  const waBtn = document.getElementById('whatsappFloat');
  if (waBtn) {
    waBtn.style.cssText = `
      animation: wa-float 3s ease-in-out infinite;
    `;
  }

  // ── Form Handling (if exists)
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Basic validation
      const firstName = document.getElementById('firstName').value.trim();
      const email = document.getElementById('email').value.trim();
      const message = document.getElementById('message').value.trim();
      
      if (!firstName || !email || !message) {
        alert('Please fill in all required fields');
        return;
      }
      
      // Simulate form submission
      const formContent = document.getElementById('formContent');
      const formSuccess = document.getElementById('formSuccess');
      
      if (formContent && formSuccess) {
        formContent.style.display = 'none';
        formSuccess.style.display = 'block';
      }
    });
  }

  console.log('✅ Jonatas Baptista Website Loaded Successfully');
});

// CSS Keyframes added dynamically
const style = document.createElement('style');
style.textContent = `
  @keyframes wa-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
`;
document.head.appendChild(style);
