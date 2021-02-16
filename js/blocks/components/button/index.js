import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useCallback } from '@wordpress/element';
import { Button, PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { RichText, URLInput, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { link, keyboardReturn, arrowLeft } from '@wordpress/icons';
import './editor.scss';

function Inspector({ target, title, setAttributes }) {
  const updateTarget = useCallback(
    value => {
      setAttributes({ target: value });
    }, [setAttributes]
  );
  const updateTitle = useCallback(
    value => {
      setAttributes({ title: value });
    }, [setAttributes]
  );

  return (
    <InspectorControls key="inspector">
      <PanelBody
        title={ __('Button settings', 'luna') }
        initialOpen={ true }
      >

        <ToggleControl
          label={ __('Open in new tab', 'luna') }
          checked={ target }
          onChange={ updateTarget }
        />

        <TextControl
          label={ __('Link title', 'luna') }
          value={ title }
          onChange={ updateTitle }
        />

      </PanelBody>
    </InspectorControls>
  );
}

export const LunaButton = props => {
  const {
    attributes,
    setAttributes
  } = props;

  const {
    url,
    title,
    target = false,
    label = '',
    expanded = false
  } = attributes;

  const blockProps = useBlockProps();

  const toggleURL = () => setAttributes({ expanded: expanded === false });

  return (
    <div className={ classnames(blockProps.className) }>

      <RichText
        tagName="a"
        aria-label={ __('Button text', 'luna') }
        placeholder={ __('Add text…', 'luna') }
        value={ label }
        onChange={ value => setAttributes({ label: value }) }
        withoutInteractiveFormatting
        className={ classnames(`${ blockProps.className }__button`) }
        identifier="text"
      />

      <Button
        icon={ link }
        label={ url ? __('Edit link', 'luna') : __('Insert link', 'luna') }
        isPrimary
        onClick={ toggleURL }
        className={ url ? 'luna-button-url is-active' : 'luna-button-url' }
      />

      { expanded && (
        <form
          className="luna-button-form"
          onSubmit={ event => {
            event.preventDefault();
            toggleURL();
          } }
        >

          <Button
            icon={ arrowLeft }
            label={ __('Close', 'luna') }
            onClick={ toggleURL }
            className="luna-button-close"
          />

          <URLInput
            value={ url }
            className="luna-button-input"
            onChange={ newURL => setAttributes({ url: newURL }) }
          />

          <Button
            type="submit"
            icon={ keyboardReturn }
            label={ __('Submit', 'luna') }
            onClick={ toggleURL }
            className="luna-button-submit"
          />

        </form>
      ) }

      <Inspector target={ target } title={ title } setAttributes={ setAttributes } />
    </div>
  );
};

export const LunaButtonSave = props => {
  const {
    url,
    title,
    label,
    target
  } = props;

  const blockProps = useBlockProps.save();

  return (
    <div className={ classnames(blockProps.className) }>
      <RichText.Content
        tagName="a"
        className={ classnames(`${ blockProps.className }__button`) }
        href={ url }
        title={ title }
        value={ label }
        target={ target && '_blank' }
        rel={ target && 'noopener noreferrer' }
      />
    </div>
  );
};