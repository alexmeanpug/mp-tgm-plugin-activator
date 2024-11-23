<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package infra
 */

get_header();
?>
	<div id="primary" class="content-area">
        <?php
        $archive_template = 'archive';

        if (is_post_type_archive('practice-area')) {
            $archive_template = 'practice-area';
        }
        get_template_part( 'template-parts/archives/content', $archive_template);
        ?>
	</div><!-- #primary -->

<?php
get_footer();
