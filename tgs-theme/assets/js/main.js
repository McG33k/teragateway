/**
 * TGS Theme — main.js
 * Handles: mobile nav, sticky header shadow, scroll-triggered animations,
 * stat counter animation, smooth anchor scrolling.
 */

( function () {
  'use strict';

  /* ─────────────────────────────────────────
     MOBILE NAVIGATION TOGGLE
     ───────────────────────────────────────── */
  const toggle = document.querySelector( '.nav-toggle' );
  const nav    = document.getElementById( 'primary-nav' );

  if ( toggle && nav ) {
    toggle.addEventListener( 'click', function () {
      const expanded = this.getAttribute( 'aria-expanded' ) === 'true';
      this.setAttribute( 'aria-expanded', String( ! expanded ) );
      nav.classList.toggle( 'open' );
    } );

    // Close nav when clicking outside
    document.addEventListener( 'click', function ( e ) {
      if ( nav.classList.contains( 'open' ) && ! nav.contains( e.target ) && ! toggle.contains( e.target ) ) {
        nav.classList.remove( 'open' );
        toggle.setAttribute( 'aria-expanded', 'false' );
      }
    } );

    // Close on Escape
    document.addEventListener( 'keydown', function ( e ) {
      if ( e.key === 'Escape' && nav.classList.contains( 'open' ) ) {
        nav.classList.remove( 'open' );
        toggle.setAttribute( 'aria-expanded', 'false' );
        toggle.focus();
      }
    } );
  }

  /* ─────────────────────────────────────────
     STICKY HEADER SHADOW ENHANCEMENT
     ───────────────────────────────────────── */
  const header = document.getElementById( 'site-header' );

  if ( header ) {
    const updateHeaderShadow = () => {
      if ( window.scrollY > 20 ) {
        header.style.boxShadow = '0 4px 24px rgba(26,60,143,0.14)';
      } else {
        header.style.boxShadow = '0 2px 16px rgba(0,0,0,0.08)';
      }
    };

    window.addEventListener( 'scroll', updateHeaderShadow, { passive: true } );
    updateHeaderShadow();
  }

  /* ─────────────────────────────────────────
     INTERSECTION OBSERVER — SCROLL ANIMATIONS
     Animates .animate-in elements, service cards, stat items
     ───────────────────────────────────────── */
  const prefersReducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

  if ( ! prefersReducedMotion && 'IntersectionObserver' in window ) {

    // Hero elements already have CSS animation; skip here.
    // Add .js-animate to service cards, stat items, industry items on DOMContentLoaded.
    const animatableSelectors = [
      '.service-card',
      '.stat-item',
      '.industry-item',
      '.why-item',
    ];

    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -40px 0px',
    };

    const observer = new IntersectionObserver( ( entries, obs ) => {
      entries.forEach( ( entry, idx ) => {
        if ( entry.isIntersecting ) {
          const el = entry.target;
          // Stagger based on sibling index
          const siblings = Array.from( el.parentElement.children );
          const i        = siblings.indexOf( el );
          el.style.transitionDelay = ( i * 60 ) + 'ms';
          el.classList.add( 'is-visible' );
          obs.unobserve( el );
        }
      } );
    }, observerOptions );

    // Inject CSS for the .is-visible reveal
    const styleTag = document.createElement( 'style' );
    styleTag.textContent = `
      .service-card,
      .stat-item,
      .industry-item,
      .why-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
      }
      .service-card.is-visible,
      .stat-item.is-visible,
      .industry-item.is-visible,
      .why-item.is-visible {
        opacity: 1;
        transform: translateY(0);
      }
    `;
    document.head.appendChild( styleTag );

    animatableSelectors.forEach( selector => {
      document.querySelectorAll( selector ).forEach( el => observer.observe( el ) );
    } );
  }

  /* ─────────────────────────────────────────
     STAT COUNTER ANIMATION
     ───────────────────────────────────────── */
  function animateCounter( el ) {
    const text    = el.textContent.trim();
    const suffix  = text.replace( /[\d]/g, '' );   // e.g. "+"
    const target  = parseInt( text.replace( /\D/g, '' ), 10 );
    const duration = 1500;
    const start    = performance.now();

    function update( now ) {
      const progress = Math.min( ( now - start ) / duration, 1 );
      const eased    = 1 - Math.pow( 1 - progress, 3 ); // ease-out cubic
      el.textContent = Math.round( eased * target ) + suffix;
      if ( progress < 1 ) requestAnimationFrame( update );
    }

    requestAnimationFrame( update );
  }

  if ( ! prefersReducedMotion && 'IntersectionObserver' in window ) {
    const statNumbers = document.querySelectorAll( '.stat-number' );

    const statObserver = new IntersectionObserver( ( entries, obs ) => {
      entries.forEach( entry => {
        if ( entry.isIntersecting ) {
          animateCounter( entry.target );
          obs.unobserve( entry.target );
        }
      } );
    }, { threshold: 0.5 } );

    statNumbers.forEach( el => statObserver.observe( el ) );
  }

  /* ─────────────────────────────────────────
     SMOOTH ANCHOR SCROLLING
     (for same-page links like #services, #about)
     ───────────────────────────────────────── */
  document.querySelectorAll( 'a[href^="#"]' ).forEach( anchor => {
    anchor.addEventListener( 'click', function ( e ) {
      const href   = this.getAttribute( 'href' );
      const target = document.querySelector( href );
      if ( target ) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 0;
        const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
        window.scrollTo( { top, behavior: 'smooth' } );
        target.setAttribute( 'tabindex', '-1' );
        target.focus( { preventScroll: true } );
      }
    } );
  } );

  /* ─────────────────────────────────────────
     CONTACT FORM (if present on page)
     ───────────────────────────────────────── */
  const contactForm = document.getElementById( 'tgs-contact-form' );

  if ( contactForm && typeof tgsData !== 'undefined' ) {
    const statusEl = document.getElementById( 'tgs-form-status' );

    contactForm.addEventListener( 'submit', async function ( e ) {
      e.preventDefault();
      const submitBtn = this.querySelector( '[type="submit"]' );
      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending…';

      const body = new URLSearchParams( {
        action  : 'tgs_contact',
        nonce   : tgsData.nonce,
        name    : this.querySelector( '[name="name"]' ).value,
        email   : this.querySelector( '[name="email"]' ).value,
        message : this.querySelector( '[name="message"]' ).value,
      } );

      try {
        const res  = await fetch( tgsData.ajaxUrl, { method: 'POST', body } );
        const data = await res.json();

        if ( statusEl ) {
          statusEl.textContent  = data.data.message;
          statusEl.style.color  = data.success ? 'green' : 'red';
          statusEl.style.display = 'block';
        }

        if ( data.success ) contactForm.reset();
      } catch ( err ) {
        if ( statusEl ) {
          statusEl.textContent  = 'An unexpected error occurred. Please try again.';
          statusEl.style.color  = 'red';
          statusEl.style.display = 'block';
        }
      } finally {
        submitBtn.disabled    = false;
        submitBtn.textContent = 'Send Message';
      }
    } );
  }

} )();
