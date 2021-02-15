import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { TextControl, Button, Spinner, NavigableMenu } from '@wordpress/components';
import PostItem from '../post-item/index.js';

/**
 * Post Select
 *
 * @param {Object} props react props
 * @return {*} React JSX
 */
export const PostSelect = props => {
  const {
    onSelectPost,
    label = '',
    postTypes = [
      'posts',
      'pages'
    ],
    placeholder = ''
  } = props;

  const [searchString, setSearchString] = useState('');
  const [searchResults, setSearchResults] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);

  function handleItemSelection(post) {
    onSelectPost(post);
    setSearchResults([]);
    setSearchString('');
  }

  /**
   * Using the keyword and the list of tags that are linked to the parent block
   * search for posts that match and return them to the autocomplete component.
   *
   * @param {string} keyword search query string
   */
  const handleSearchStringChange = keyword => {
    setSearchString(keyword);
    setIsLoading(true);

    Promise.all(postTypes.map(postType => apiFetch({
      path: `/wp/v2/${ postType }?search=${ keyword }`
    }))).then(results => {
      setSearchResults(
        results.reduce((result, final) => [...final, ...result], [])
      );
      setIsLoading(false);
    });
  };

  function handleSelection(item) {
    if (item === 0) {
      setSelectedItem(null);
    }

    setSelectedItem(item);
  }

  return (
    <NavigableMenu onNavigate={ handleSelection } orientation={ 'vertical' }>

      <TextControl
        label={ label }
        value={ searchString }
        onChange={ handleSearchStringChange }
        placeholder={ placeholder }
      />

      { searchString.length ? (
        <ul
          style={
            {
              margin: '0',
              paddingLeft: '0',
              listStyle: 'none'
            }
          }
        >
          { isLoading && <Spinner /> }

          { ! isLoading && ! searchResults.length && (
            <li>
              <Button disabled>{ __('No Items found', 'luna') }</Button>
            </li>
          ) }

          { searchResults.map((post, index) => {
            if (! post.title.rendered.length) {
              return null;
            }

            return (
              <li
                key={ post.id }
                style={ { marginBottom: 0 } }
              >
                <PostItem
                  onClick={ () => handleItemSelection(post) }
                  searchTerm={ searchString }
                  suggestion={ post }
                  isSelected={ selectedItem === index + 1 }
                />
              </li>
            );
          }) }

        </ul>
      ) : null }

    </NavigableMenu>
  );
};