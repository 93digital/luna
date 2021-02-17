import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import Inspector from './inspector';
import { LunaButton } from '../../components/button/index';

export default function Edit(props) {
  const { attributes, setAttributes } = props;

  const blockProps = useBlockProps({
    className: classnames(
      'm01 break-out'
    )
  });

  const {
    heading,
    buttonURL,
    buttonLabel,
    buttonTarget
  } = attributes;

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

      <LunaButton
        className="test-class-name button"
        label={ buttonLabel }
        url={ buttonURL }
        target={ buttonTarget }
        onLabelChange={ value => setAttributes({ buttonLabel: value }) }
        onInputChange={ value => setAttributes({ buttonURL: value }) }
        onTargetChange={ value => setAttributes({ buttonTarget: value }) }
      />

      <Inspector { ...props } key="inspector" />

    </article>
  );
}
