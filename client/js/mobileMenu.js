/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Controls the mobile nav menu. Toggles open/close on the burger
 *              button, and closes the menu when a link is tapped, the user clicks
 *              outside the nav, or the Escape key is pressed.
 */

document.addEventListener('DOMContentLoaded', function () {

    var burger   = document.getElementById('nav-burger');
    var navLinks = document.getElementById('nav-links');

    if (!burger || !navLinks) return;

    /**
     * Closes the mobile menu.
     */
    function closeMenu() {
        navLinks.classList.remove('nav-open');
        burger.classList.remove('is-active');
        burger.setAttribute('aria-expanded', 'false');
    }

    /**
     * Opens the mobile menu.
     */
    function openMenu() {
        navLinks.classList.add('nav-open');
        burger.classList.add('is-active');
        burger.setAttribute('aria-expanded', 'true');
    }

    burger.addEventListener('click', function (e) {
        e.stopPropagation(); // prevent the document click handler below from firing
        if (navLinks.classList.contains('nav-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    navLinks.addEventListener('click', function (e) {
        if (e.target.classList.contains('nav-link')) closeMenu();
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#nav')) closeMenu();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });

});