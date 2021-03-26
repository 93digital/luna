/**
 * Get Ancestor Nodes.
 * Retrieves an array of ancestor nodes.
 *
 * Usage:
 * getAncestorNodes(element);
 *
 * @param {string|number} element - Element to use for retrieving all ancestors.
 * @return {Array} The returned ancestor nodes.
 */
export const getAncestorNodes = element => {
  const ancestors = [];
  while (element) {
    ancestors.unshift(element);
    element = element.parentNode;
  }

  return ancestors;
};

