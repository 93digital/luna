import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import { Flex, FlexBlock, FlexItem, TextHighlight, Button, Card, CardBody } from '@wordpress/components';
import { safeDecodeURI, filterURLForDisplay } from '@wordpress/url';

/**
 * Post Card
 * Card element used in both PostItem & PostItemPreview components.
 *
 * @param {Array} props PostCard props
 * @example
 * <PostCard
 *   id={ uniqueId }
 *   post={ postObject }
 *   searchTerm="identifying string"
 * />
 */
export const PostCard = props => {
  const {
    id = '',
    post,
    searchTerm = ''
  } = props;

  if (post && Object.keys(post).length === 0 && post.constructor === Object) {
    return null;
  }

  return (
    <Card size="small" id={ id }>
      <CardBody>
        <Flex>
          <FlexBlock>
            <span
              style={
                {
                  fontWeight: 600,
                  fontSize: '14px',
                  lineHeight: '20px',
                  whiteSpace: 'nowrap',
                  overflow: 'hidden',
                  textOverflow: 'ellipsis',
                  width: '98%',
                  display: 'block'
                }
              }
            >
              <TextHighlight
                text={ decodeEntities(post.title.rendered) }
                highlight={ searchTerm }
              />
            </span>
            <span
              style={
                {
                  display: 'block',
                  fontWeight: 400,
                  fontSize: '12px',
                  lineHeight: '16px',
                  width: '98%',
                  whiteSpace: 'nowrap',
                  overflow: 'hidden',
                  textOverflow: 'ellipsis'
                }
              }
            >
              { filterURLForDisplay(safeDecodeURI(post.link)) || '' }
            </span>
          </FlexBlock>
          { post.type && (
            <FlexItem>
              <Button disabled isSmall isSecondary>
                { post.type === 'post_tag' ? 'tag' : post.type }
              </Button>
            </FlexItem>
          ) }
        </Flex>
      </CardBody>
    </Card>
  );
};

/**
 * Post Item
 * Displays a simple card view of a post item.
 *
 * @param {Array} props PostItem Props
 * @example
 * <PostItem
 *   isSelected={ boolean }
 *   onClick={ () => handleEventSelection(postObject) }
 * />
 */
export const PostItem = props => {
  const {
    onClick,
    isSelected = false
  } = props;

  return (
    <Button
      onClick={ onClick }
      className={ isSelected && 'is-selected' }
      style={
        {
          padding: 0,
          width: '100%',
          height: 'auto',
          display: 'block',
          textAlign: 'left',
          margin: '8px 0'
        }
      }
    >
      <PostCard { ...props } />
    </Button>
  );
};

/**
 * Post Item Preview
 * Displays a preview with a defined label.
 *
 * @param {Array} props PostItemPreview props
 * @example
 * <PostItemPreview
 *   post={ selectedPost }
 *   label={ __('Selected Post:', 'luna') }
 *   onRemove={ () => setAttributes({ selectedPost: null }) }
 * />
 */
export function PostItemPreview(props) {
  const {
    post,
    label,
    onRemove
  } = props;
  const postID = `${ post.slug }-preview`;

  return (
    <div>
      <label
        htmlFor={ postID }
        style={
          {
            display: 'block',
            marginBottom: '8px'
          }
        }
      >
        { label || __('Selected Post:', 'luna') }
      </label>
      <PostCard
        post={ post }
        id={ postID }
      />
      { post &&
        <Button
          isLink
          isDestructive
          style={ { marginTop: '8px' } }
          onClick={ onRemove }
        >
          { __('Remove', 'luna') }
        </Button>
      }
    </div>
  );
}
