import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Inspector } from './inspector';

export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps({
    className: classnames(
      'm01 break-out'
    )
  });
  const { heading } = attributes;

  return (
    <article { ...blockProps }>

      <h1>{ __('Hello World!', 'luna') }</h1>

      <RichText
        tagName="h2"
        value={ heading }
        className="m01__heading"
        placeholder={ __('Heading…', 'luna') }
        onChange={ value => setAttributes({ heading: value }) }
      />

      <Inspector { ...blockProps } key="inspector" />

    </article>
  );
}
