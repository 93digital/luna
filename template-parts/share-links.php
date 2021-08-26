<?php
/**
 * Template file for share links.
 *
 * @package luna
 * @subpackage template-parts
 */

global $luna;

if ( is_home() ) :
  $permalink = get_the_permalink( get_option( 'page_for_posts' ) );
elseif ( is_archive() ) :
  $permalink = get_post_type_archive_link( get_queried_object()->name );
else :
  $permalink = get_the_permalink();
endif;

$email_url    = 'mailto:info@example.com?&subject=&cc=&bcc=&body=' . $permalink;
$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
$twitter_url  = 'https://twitter.com/intent/tweet?url=' . $permalink . '&text=';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=&summary=&source=';

?>

<section class="share-links">
  <ul class="share-links__list">
    <li class="share-links__list-item">
      <a href="<?php echo esc_url( $email_url ); ?>" class="share-links__link share-links__link--email" target="_blank" rel="noopener noreferrer">
        <?php $luna->utils->svg( 'icon-email' ); ?>
        <span class="screen-reader-text"><?php esc_html_e( 'Share via Email', 'luna' ); ?></span>
      </a>
    </li>
    <li class="share-links__list-item">
      <a href="<?php echo esc_url( $facebook_url ); ?>" class="share-links__link share-links__link--facebook" target="_blank" rel="noopener noreferrer">
        <?php $luna->utils->svg( 'icon-facebook' ); ?>
        <span class="screen-reader-text"><?php esc_html_e( 'Share via Facebook', 'luna' ); ?></span>
      </a>
    </li>
    <li class="share-links__list-item">
      <a href="<?php echo esc_url( $linkedin_url ); ?>" class="share-links__link share-links__link--linkedin" target="_blank" rel="noopener noreferrer">
        <?php $luna->utils->svg( 'icon-linkedin' ); ?>
        <span class="screen-reader-text"><?php esc_html_e( 'Share via Linkedin', 'luna' ); ?></span>
      </a>
    </li>
    <li class="share-links__list-item">
      <a href="<?php echo esc_url( $twitter_url ); ?>" class="share-links__link share-links__link--twitter" target="_blank" rel="noopener noreferrer">
        <?php $luna->utils->svg( 'icon-twitter' ); ?>
        <span class="screen-reader-text"><?php esc_html_e( 'Share via Twitter', 'luna' ); ?></span>
      </a>
    </li>
  </ul>
</section>