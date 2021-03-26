/**
 * Detect if the device has touch screen.
 * https://stackoverflow.com/questions/4817029/whats-the-best-way-to-detect-a-touch-screen-device-using-javascript#4819886
 */
export const isTouch = () => {
  const mq = query => {
    return window.matchMedia(query).matches;
  };

  if ('ontouchstart' in window || (window.DocumentTouch && document instanceof DocumentTouch)) { // eslint-disable-line
    return true;
  }

  // include the 'heartz' as a way to have a non matching MQ to help terminate the join
  // https://git.io/vznFH
  const prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
  const query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
  return mq(query);
};
