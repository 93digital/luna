// import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { Button, ToggleControl, Card, CardBody, CardFooter } from '@wordpress/components';
import { RichText, URLInput } from '@wordpress/block-editor';
import { link, keyboardReturn } from '@wordpress/icons';

import './editor.scss';

/**
 * Luna Button
 * Custom Button Component.
 *
 * @param {Object} props Props
 * @return {*} React JSX
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
      <RichText
        tagName="a"
        aria-label={ __('Button text', 'luna') }
        placeholder={ __('Add text…', 'luna') }
        value={ label }
        onChange={ onLabelChange }
        withoutInteractiveFormatting
        className={ className }
        identifier="text"
      />

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

/**
 * Luna Button Content
 * Output preivew of the LunaButton Component.
 *
 * @param {Object} props Props
 * @return {*} React JSX
 */
LunaButton.Content = props => {
  const {
    className,
    url,
    label,
    target
  } = props;

  return (
    <RichText.Content
      tagName="a"
      className={ className }
      href={ url }
      value={ label }
      target={ target && '_blank' }
      rel={ target && 'noopener noreferrer' }
    />
  );
};