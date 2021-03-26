import classnames from 'classnames';
import { v4 as uuidv4 } from 'uuid';

import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { close } from '@wordpress/icons';

import './editor.scss';

/**
 * Image Element
 * Figure Image output from LunaImage component.
 *
 * @param {Object} props Props
 * @return {*} React JSX
 */
const ImageElement = props => {
  const { item, className } = props;

  return (
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
  );
};

/**
 * LunaImage
 * Image component for use in custom blocks.
 *
 * @param {Object} props Props
 * @return {*} React JSX
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
        ? <Button id={ labelId } className={ className } onClick={ open }><span>{ __('Set image', 'stella') }</span></Button>
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
          label={ __('Remove image', 'stella') }
          className="luna-image-remove"
          onClick={ () => onImageSelect(null, null) }
        />
      }

    </div>
  );
};

/**
 * LunaInspectorImage
 * Image component for use in custom blocks inspector.
 *
 * @param {Object} props Props
 * @return {*} React JSX
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
        ? <Button id={ labelId } className="editor-post-featured-image__toggle" onClick={ open }><span>{ __('Set image', 'stella') }</span></Button>
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
        <>
          <div>
            <Button isSecondary onClick={ open }>{ __('Replace Image', 'luna') }</Button>
          </div>
          <Button
            isLink
            isDestructive
            style={ { marginTop: '1em' } }
            onClick={ () => onImageSelect(null, null) }
          >
            { __('Remove image', 'stella') }
          </Button>
        </>
      }

    </div>
  );
};

/**
 * LunaImage Content
 * Image component output.
 *
 * @param {Object} props Props
 * @return {*} React JSX
 */
LunaImage.Content = props => {
  return (
    <ImageElement { ...props } />
  );
};

