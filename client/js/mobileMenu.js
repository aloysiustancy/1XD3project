// js/mobileMenu.js — TOG · McMaster Mindfulness Club

document.addEventListener('DOMContentLoaded', function () {

    var burger   = document.getElementById('nav-burger');
    var navLinks = document.getElementById('nav-links');

    if (!burger || !navLinks) return;

    function closeMenu() {
        navLinks.classList.remove('nav-open');
        burger.classList.remove('is-active');
        burger.setAttribute('aria-expanded', 'false');
    }

    function openMenu() {
        navLinks.classList.add('nav-open');
        burger.classList.add('is-active');
        burger.setAttribute('aria-expanded', 'true');
    }

    // Toggle on burger click
    burger.addEventListener('click', function (e) {
        e.stopPropagation();
        if (navLinks.classList.contains('nav-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Close when a nav link is tapped
    navLinks.addEventListener('click', function (e) {
        if (e.target.classList.contains('nav-link')) {
            closeMenu();
        }
    });

    // Close when clicking anywhere outside the nav
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#nav')) {
            closeMenu();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });

});