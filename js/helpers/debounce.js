/**
 * Debounce Function.
 *
 * Usage:
 * debounce(event => { console.log(event) }), 500);
 *
 * @param {Function} func - Function we wish to debounce.
 * @param {number} timeout - Element to use for retrieving all ancestors.
 * @return {Function} The returned function.
 */
export const debounce = (func, timeout = 500) => {
  let timer;

  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      func.apply(this, args);
    }, timeout);
  };
};