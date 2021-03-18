/**
 * Smooth scroll hash links.
 * Animated scroll to a hashed element on the page.
 * Fallbacks to default hash links when JS is disabled.
 *
 * Usage:
 * Add `data-smooth-scroll` to anchor tag with a hash href value.
 *
 * Options:
 * Add `data-smooth-scroll-no-hash` to prevent the address bar hash from updating.
 *
 * Example:
 * <a href="#id-of-element-to-scroll-to" data-smooth-scroll data-smooth-scroll-no-hash>
 *   Scroll to section
 * </a>
 */

(() => {
  const scrollLinks = document.querySelectorAll('[data-smooth-scroll]');
  scrollLinks.forEach(link => {
    /**
     * Firstly we need to add a tabindex=-1 to the link.
     *
     * There is no way to set the duration of the scrollTo function and therefore focus
     * on a new element after the scroll has finished.
     * (Adding elem.focus() straight after the scrollTo() function removes the animation).
     */
    link.setAttribute('tabindex', '-1');
    // get the no-hash option.
    link.addHash = link.getAttribute('data-smooth-scroll-no-hash') === null;
    link.addEventListener('click', e => {
      const id = e.target.hash.replace('#', '');
      const scrollTarget = document.getElementById(id);
      if (scrollTarget) {
        if (link.addHash) {
          // Add the hash to the address bar.
          window.location.hash = e.target.hash;
        }
        // Prevent the default behaviour hear after window.location.hash has been updated.
        e.preventDefault();
        // Do that saucy scrolling magic.
        window.scrollTo({
          left: 0,
          top: scrollTarget.offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
})();
