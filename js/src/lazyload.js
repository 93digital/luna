/**
 * LazyLoad
 * Defers the loading of 'below-the-fold' images, videos and iframes.
 *
 * Usage:
 * See official docs https://github.com/verlok/lazyload
 *
 * Basic Example:
 * <img class="lazy" data-src="https://via.placeholder.com/150" alt="">
 * <div class="lazy" data-bg="https://via.placeholder.com/150"></div>
 */

import * as $ from 'jquery';
import { lazyLoadInstance } from '../helpers/lazyload-instance';

(() => {
  // eslint-disable-next-line no-unused-expressions
  lazyLoadInstance;

  $('body').on('terraDone', () => {
    lazyLoadInstance.update();
  });
})();