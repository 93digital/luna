import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { PostSelect } from '../../components/post-select/index';
import { PostItemPreview } from '../../components/post-item/index';

export default function Inspector(props) {
  const { attributes, setAttributes } = props;
  const { heading, selectedPost } = attributes;

  return (
    <InspectorControls key="inspector">
      <PanelBody
        title={ __('Block settings', 'luna') }
        initialOpen={ true }
      >

        <TextControl
          label={ __('Module Heading', 'luna') }
          value={ heading }
          onChange={ value => setAttributes({ heading: value }) }
        />

        { selectedPost &&
          <PostItemPreview
            post={ selectedPost }
            setAttributes={ setAttributes }
            label={ __('Selected Post:', 'luna') }
          />
        }

        <PostSelect
          label={ __('Search page/post', 'luna') }
          postTypes={ ['posts', 'pages'] }
          placeholder={ __('Search…', 'luna') }
          onSelectPost={ post => setAttributes({ selectedPost: post }) }
        />

      </PanelBody>
    </InspectorControls>
  );
}
