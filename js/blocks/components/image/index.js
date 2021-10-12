import classnames from 'classnames';
import { v4 as uuidv4 } from 'uuid';
import LazyLoad from 'vanilla-lazyload';

import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { close } from '@wordpress/icons';

import './editor.scss';

const isGIF = image => {
  const url = image.split('?')[0];
  const parts = url.split('.');
  const extension = parts[parts.length - 1];
  //define some image types to test against
  const imageTypes = ['gif'];
  if (imageTypes.indexOf(extension) !== -1) {
    return true;
  }
};

const ImageElement = props => {
  const { item, className } = props;

  if (item === undefined) {
    return;
  }

  return (
    <>
      { isGIF(item.src) &&
        <figure className={ className }>
          <img
            src={ item.mobileSrc }
            data-src={ item.full }
            alt={ item.alt }
            width={ item.width }
            height={ item.height }
            className={ classnames(`${ className }__image lazy`) }
          />
        </figure>
      }
      { ! isGIF(item.src) &&
        <figure className={ className }>
          <picture>
            <source srcSet={ item.src } media="(min-width: 768px)" />
            <source srcSet={ item.tabletSrc } media="(min-width: 375px)" />
            <img
              src={ item.mobileSrc }
              alt={ item.alt }
              width={ item.width }
              height={ item.height }
              className={ classnames(`${ className }__image`) }
            />
          </picture>
        </figure>
      }
    </>
  );
};

const ImageElementSave = props => {
  const { item, className } = props;

  if (item === undefined) {
    return;
  }

  new LazyLoad({
    elements_selector: '.lazy'
  });

  const placeholderSrc = (width, height) => `data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${ width } ${ height }"%3E%3C/svg%3E`;

  return (
    <>
      { isGIF(item.src) &&
        <figure className={ className }>
          <img
            src={ placeholderSrc(item.width, item.height) }
            data-src={ item.full }
            alt={ item.alt }
            width={ item.width }
            height={ item.height }
            className={ classnames(`${ className }__image lazy`) }
          />
        </figure>
      }
      { ! isGIF(item.src) &&
        <figure className={ className }>
          <picture>
            <source data-srcset={ item.src } media="(min-width: 768px)" />
            <source data-srcset={ item.tabletSrc } media="(min-width: 375px)" />
            <img
              src={ placeholderSrc(item.width, item.height) }
              data-src={ item.mobileSrc }
              alt={ item.alt }
              width={ item.width }
              height={ item.height }
              className={ classnames(`${ className }__image lazy`) }
            />
          </picture>
        </figure>
      }
    </>
  );
};

/**
 * LunaImage - React component for adding inline images to Gutenberg blocks.
 *
 * @param {Array} props - LunaImage properties.
 * @example
 * const { size, mediaID, image, className, onImageSelect } = props;
 *
 * <LunaImage
 *   size="large"
 *   mediaID={ mediaID }
 *   image={ mediaObject }
 *   className="m02__media"
 *   onImageSelect={
 *     (imageObject, imageID) => setAttributes({
 *       mediaObject: imageObject,
 *       mediaID: imageID
 *     })
 *   }
 * />
 */
export const LunaImage = props => {
  const {
    mediaID,
    onImageSelect,
    className = 'luna-image',
    image,
    size = 'large'
  } = props;

  const labelId = uuidv4();

  const mediaRender = ({ open }) => (
    <>
      { ! mediaID
        ? <Button id={ labelId } className={ className } onClick={ open }><span>{ __('Set image', 'luna') }</span></Button>
        : (
          <Button
            className="luna-image-button"
            id={ labelId }
            onClick={ open }
            style={
              {
                padding: 0,
                height: 'auto',
                display: 'contents'
              }
            }
          >
            <ImageElement className={ className } item={ image } />
          </Button>
        )
      }
    </>
  );

  const mediaSelect = media => {
    const customSize = media.sizes[size] !== undefined;
    const mobileFallback = (media.sizes.medium ? media.sizes.medium.url : media.url);
    const tabletFallback = (media.sizes.tablet ? media.sizes.tablet.url : media.url);

    const mediaObject = {
      id: media.id,
      alt: media.alt,
      full: media.url,
      width: customSize ? media.sizes[size].width : media.width,
      height: customSize ? media.sizes[size].height : media.height,
      src: customSize ? media.sizes[size].url : media.url,
      mobileSrc: media.sizes.mobile !== undefined ? media.sizes.mobile.url : mobileFallback,
      tabletSrc: media.sizes.tablet !== undefined ? media.sizes.tablet.url : tabletFallback
    };

    onImageSelect(mediaObject, media.id);
  };

  return (
    <div className="luna-image-wrap">

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
          icon={ close }
          label={ __('Remove image', 'luna') }
          className="luna-image-remove"
          onClick={ () => onImageSelect(null, null) }
        />
      }

    </div>
  );
};

/**
 * LunaInspectorImage - React component for adding images to Gutenberg block inspector.
 *
 * @param {Array} props - LunaInspectorImage properties.
 * @example
 * const { size, mediaID, image, className, onImageSelect } = props;
 *
 * <LunaInspectorImage
 *   label={ __('Background Image', 'luna') }
 *   size="large"
 *   mediaID={ mediaID }
 *   image={ mediaObject }
 *   className="m02__media"
 *   onImageSelect={
 *     (imageObject, imageID) => setAttributes({
 *       mediaObject: imageObject,
 *       mediaID: imageID
 *     })
 *   }
 * />
 */
export const LunaInspectorImage = props => {
  const {
    label,
    mediaID,
    onImageSelect,
    className = 'luna-image',
    image,
    size = 'large'
  } = props;

  const labelId = uuidv4();

  const mediaRender = ({ open }) => (
    <>
      { label &&
        <label
          htmlFor={ labelId }
          style={
            {
              display: 'block',
              marginBottom: '8px'
            }
          }
        >
          { label }
        </label>
      }
      { ! mediaID
        ? <Button id={ labelId } className="editor-post-featured-image__toggle" onClick={ open }><span>{ __('Set image', 'luna') }</span></Button>
        : (
          <Button
            className="luna-image-button"
            id={ labelId }
            onClick={ open }
            style={
              {
                padding: 0,
                height: 'auto',
                marginBottom: '1em'
              }
            }
          >
            <ImageElement className={ className } item={ image } />
          </Button>
        )
      }
    </>
  );

  const mediaSelect = media => {
    const customSize = media.sizes[size] !== undefined;
    const mobileFallback = (media.sizes.medium ? media.sizes.medium.url : media.url);
    const tabletFallback = (media.sizes.tablet ? media.sizes.tablet.url : media.url);

    const mediaObject = {
      id: media.id,
      alt: media.alt,
      full: media.url,
      width: customSize ? media.sizes[size].width : media.width,
      height: customSize ? media.sizes[size].height : media.height,
      src: customSize ? media.sizes[size].url : media.url,
      mobileSrc: media.sizes.mobile !== undefined ? media.sizes.mobile.url : mobileFallback,
      tabletSrc: media.sizes.tablet !== undefined ? media.sizes.tablet.url : tabletFallback
    };

    onImageSelect(mediaObject, media.id);
  };

  return (
    <div className="luna-image-wrap">
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
          isLink
          isDestructive
          style={ { marginTop: '1em' } }
          onClick={ () => onImageSelect(null, null) }
        >
          { __('Remove image', 'luna') }
        </Button>
      }
    </div>
  );
};

/**
 * LunaImage.Content - React component for adding images to save function.
 *
 * @param {Array} props - LunaImage.Content properties.
 * @example
 * const { className, image } = props;
 *
 * <LunaImage.Content
 *   className="custom-image"
 *   image={ mediaObject }
 * />
 */
LunaImage.Content = props => {
  const { className, image } = props;
  return (
    <ImageElementSave className={ className } item={ image } />
  );
};
