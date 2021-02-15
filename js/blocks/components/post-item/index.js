import { Flex, FlexBlock, FlexItem, TextHighlight, Button, Card, CardBody } from '@wordpress/components';
import { safeDecodeURI, filterURLForDisplay } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Post Item
 * Displays a simple card view of a post item.
 *
 * @param {Object} props react props
 * @return {*} React JSX
 */
export const PostItem = props => {
  const {
    suggestion,
    onClick,
    searchTerm = '',
    isSelected = false,
    id = ''
  } = props;

  return (
    <Button
      id={ id }
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
      <Card size="small">
        <CardBody>
          <Flex>
            <FlexBlock>
              <span
                style={
                  {
                    fontWeight: 600,
                    fontSize: '14px',
                    lineHeight: '20px'
                  }
                }
              >
                <TextHighlight
                  text={ decodeEntities(suggestion.title.rendered) }
                  highlight={ searchTerm }
                />
              </span>
              <span
                style={
                  {
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
                { filterURLForDisplay(safeDecodeURI(suggestion.link)) || '' }
              </span>
            </FlexBlock>
            { suggestion.type && (
              <FlexItem>
                <Button disabled isSmall isSecondary>
                  { suggestion.type === 'post_tag' ? 'tag' : suggestion.type }
                </Button>
              </FlexItem>
            ) }
          </Flex>
        </CardBody>
      </Card>
    </Button>
  );
};

/**
 * Post Item Preview
 * Displays a preview with a defined label.
 *
 * @param {Object} props react props
 * @return {*} React JSX
 */
export function PostItemPreview(props) {
  const { post, label } = props;
  const postID = `${ post.slug }-preview`;

  return (
    <div>
      <label htmlFor={ postID }>{ label }</label>
      <PostItem
        suggestion={ post }
        onClick={ null }
        id={ postID }
      />
    </div>
  );
}
