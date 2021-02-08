import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Save({ attributes }) {
  const blockProps = useBlockProps.save();
  const { heading } = attributes;

  return (
    <div { ...blockProps }>

      <h1>{ __('Hello World!', 'luna') }</h1>
      <h1>{ __('Hello World!', 'luna') }</h1>
      <h1>{ __('Hello World!', 'luna') }</h1>

      <RichText.Content
        tagName="h2"
        value={ heading }
        className="m01__heading"
      />

    </div>
  );
}
