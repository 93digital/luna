/**
 * px to Rem Value
 * Converts a pixel value to rem value.
 *
 * Usage:
 * pxToRem(16); // returns '1rem'.
 *
 * @param {string|number} px - Pixel value (without 'px') to be converted.
 * @return {string|number} The coverted rem value.
 */
export const pxToRem = px => {
  const fontSize = parseFloat(
    getComputedStyle(document.querySelector('html'))['font-size']
  );
  const rem = px / fontSize;

  return rem;
};

/**
 * rem to px Value
 * Converts rem value to a pixel value.
 *
 * Usage:
 * remToPx(1); // returns '16px'.
 *
 * @param {string|number} rem - rem value (without 'rem') to be converted.
 * @return {string|number} The coverted px value.
 */
export const remToPx = rem => {
  const fontSize = parseFloat(
    getComputedStyle(document.querySelector('html'))['font-size']
  );
  const px = rem * fontSize;

  return px;
};

