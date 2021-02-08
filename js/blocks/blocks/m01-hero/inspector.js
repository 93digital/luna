import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

export default function Inspector(props) {
  const { attributes, setAttributes } = props;
  const { heading } = attributes;

  return (
    <InspectorControls key="inspector">
      <PanelBody
        title={ __('Link settings', 'luna') }
        initialOpen={ true }
      >

        <TextControl
          label={ __('Module Heading', 'luna') }
          value={ heading }
          onChange={ value => setAttributes({ heading: value }) }
        />

      </PanelBody>
    </InspectorControls>
  );
}
