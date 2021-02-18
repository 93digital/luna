import classnames from 'classnames';

import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { close } from '@wordpress/icons';

import './editor.scss';

const ImageElement = props => {
  const { item, className } = props;

  return (
    <picture>
      <source srcSet={ item.src } media="(min-width: 768px)" />
      <source srcSet={ item.tabletSrc } media="(min-width: 375px)" />
      <img
        src={ item.mobileSrc }
        alt={ item.alt }
        width={ item.width }
        height={ item.height }
        className={ classnames(`${ className }__image`, 'lazy') }
      />
    </picture>
  );
};

export const LunaImage = props => {
  const {
    mediaID,
    onImageSelect,
    className = 'luna-image',
    image,
    size = 'large'
  } = props;

  const mediaRender = ({ open }) => (
    <Button
      isSmall
      isSecondary
      className={ mediaID ? 'luna-image-wrapper' : 'luna-image-wrapper luna-image-wrapper--button' }
      onClick={ open }
      style={
        {
          display: 'inline',
          height: '100%',
          width: '100%',
          padding: 0
        }
      }
    >
      { ! mediaID
        ? <span>{ __('Set image', 'luna') }</span>
        : <ImageElement className={ className } item={ image } />
      }
    </Button>
  );

  const mediaSelect = media => {
    const customSize = media.sizes[size] !== undefined;

    const mediaObject = {
      id: media.id,
      alt: media.alt,
      width: customSize ? media.sizes[size].width : media.width,
      height: customSize ? media.sizes[size].height : media.height,
      src: customSize ? media.sizes[size].url : media.url,
      mobileSrc: media.sizes.mobile !== undefined ? media.sizes.mobile.url : media.sizes.medium.url,
      tabletSrc: media.sizes.tablet !== undefined ? media.sizes.tablet.url : media.sizes.large.url
    };

    onImageSelect(mediaObject, media.id);
  };

  return (
    <div
      className={
        classnames(
          className,
          `luna-image-wrap`
        )
      }
    >

      <MediaUploadCheck>
        <MediaUpload
          type="image"
          value={ mediaID }
          onSelect={ mediaSelect }
          render={ mediaRender }
        />
      </MediaUploadCheck>

      { mediaID &&
        <Button
          isPrimary
          isDestructive
          icon={ close }
          className="luna-image-remove"
          label={ __('Remove image', 'luna') }
          onClick={ () => onImageSelect(null, null) }
        />
      }

    </div>
  );
};

LunaImage.Content = props => {
  const {
    className = 'luna-image',
    image
  } = props;

  return (
    <>
      { image &&
        <figure className={ className }>
          <picture>
            <source data-srcset={ image.src } media="(min-width: 768px)" />
            <source data-srcset={ image.tabletSrc } media="(min-width: 375px)" />
            <img
              data-src={ image.mobileSrc }
              alt={ image.alt }
              width={ image.width }
              height={ image.height }
              className={ classnames(`${ className }__image`, 'lazy') }
            />
          </picture>
        </figure>
      }
    </>
  );
};

