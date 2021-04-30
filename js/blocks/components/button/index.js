import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { Button, ToggleControl, Card, CardBody, CardFooter } from '@wordpress/components';
import { RichText, URLInput } from '@wordpress/block-editor';
import { link, keyboardReturn } from '@wordpress/icons';

import './editor.scss';

/**
 * LunaButton - React component for outputting custom Gutenberg links.
 *
 * @param {Array} props - LunaButton properties.
 * @example
 * const { buttonURL, buttonLabel, buttonTarget } = props;
 * <LunaButton
 *   className="button"
 *   url={ buttonURL }
 *   label={ buttonLabel }
 *   target={ buttonTarget }
 *   onLabelChange={ value => setAttributes({ buttonLabel: value }) }
 *   onInputChange={ value => setAttributes({ buttonURL: value }) }
 *   onTargetChange={ value => setAttributes({ buttonTarget: value }) }
 * />
 */
export const LunaButton = props => {
  const {
    className,
    url,
    label,
    target,
    onInputChange,
    onLabelChange,
    onTargetChange
  } = props;

  const [isURL, setIsURL] = useState(false);

  const toggleURL = () => setIsURL(! isURL);

  return (
    <div className="luna-button-wrap">

      <span className={ className }>
        <RichText
          tag="a"
          value={ label }
          className="luna-button-label"
          placeholder={ __('Button label…', 'luna') }
          keepPlaceholderOnFocus={ true }
          onChange={ onLabelChange }
        />
      </span>

      <Button
        isPrimary
        icon={ link }
        label={ url ? __('Edit link', 'luna') : __('Insert link', 'luna') }
        onClick={ toggleURL }
        className={ url ? 'luna-button-url is-active' : 'luna-button-url' }
      />

      { isURL && (
        <Card
          size="small"
          className="luna-button-card"
        >
          <CardBody>
            <form
              className="luna-button-form"
              onSubmit={
                event => {
                  event.preventDefault();
                  toggleURL();
                }
              }
            >
              <URLInput
                value={ url }
                className="luna-button-input"
                onChange={ onInputChange }
              />

              <Button
                icon={ keyboardReturn }
                label={ __('Submit', 'luna') }
                type="submit"
                onClick={ toggleURL }
              />
            </form>
          </CardBody>
          <CardFooter>
            <ToggleControl
              label={ __('Open in new tab', 'luna') }
              checked={ target }
              onChange={ onTargetChange }
              className="luna-button-toggle"
            />
          </CardFooter>
        </Card>
      ) }
    </div>
  );
};

LunaButton.Content = props => {
  const {
    className,
    url,
    label,
    target
  } = props;

  return (
    <a
      href={ url }
      className={ className }
      target={ target && '_blank' }
      rel={ target && 'noopener noreferrer' }
    >
      { label }
    </a>
  );
};