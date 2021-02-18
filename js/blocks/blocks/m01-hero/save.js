import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { LunaButton } from '../../components/button/index';
import { LunaImage } from '../../components/image';

export default function Save({ attributes }) {
  const blockProps = useBlockProps.save({
    className: classnames(
      'm01 break-out'
    )
  });

  const {
    heading,
    buttonURL,
    buttonLabel,
    buttonTarget,
    mediaObject
  } = attributes;

  return (
    <article { ...blockProps }>

      <h1>{ __('Hello World!', 'luna') }</h1>

      <RichText.Content
        tagName="h2"
        value={ heading }
        className="m01__heading"
      />

      <LunaButton.Content
        className="test-class-name button"
        url={ buttonURL }
        label={ buttonLabel }
        target={ buttonTarget }
      />

      <LunaImage.Content
        image={ mediaObject }
      />

    </article>
  );
}
