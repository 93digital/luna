<?php
/**
 * Template file for the custom pagination.
 *
 * @see Luna_Base_Utils::pagination()
 *
 * @package luna
 * @subpackage template-parts
 */

$args = array(
	'prev_text' => $luna->utils->svg( 'ico_next' ),
	'next_text' => $luna->utils->svg( 'ico_next' ),
);
?>

<nav class="pagination">
	<?php echo paginate_links( $args ); // phpcs:ignore ?>
</nav>
