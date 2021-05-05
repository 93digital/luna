/**
 * SvgIcon - React component for outputting an svg image.
 *
 * @param {Array} props - SvgIcon properties.
 * @example <SvgIcon name="icon_name" />
 */
export const SvgIcon = props => {
  const { name } = props;

  if (name === undefined) {
    return;
  }

  return (
    <svg className={ `svg-icon svg-icon--${ name }` } role="img" aria-hidden="true">
      <use href={ `#sprite-${ name }` }></use>
    </svg>
  );
};