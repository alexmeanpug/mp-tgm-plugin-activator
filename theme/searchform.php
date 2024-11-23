<?php
/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$inf_unique_id = wp_unique_id( 'search-form-' );

$inf_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<div class="modal modal--search micromodal-slide group" id="search-modal" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
        <div class="w-full h-full relative bg-green" role="dialog" aria-modal="true">
            <div class="max-h-full w-full h-full flex flex-col justify-center items-center text-center pb-32" id="search-modal-content">
                <button class="block ml-auto absolute right-0 top-0 mr-4 md:mr-8 mt-4 md:mt-8" aria-label="Close modal" data-micromodal-close>
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icons/ic-close-white.svg" alt="icon-modal-close">
                </button>

                <div class="container">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label class="text-white" for="<?php echo esc_attr( $ps_unique_id ); ?>"><?php _e( 'Search', 'inf' ); ?></label>

                        <div class="flex pt-16 md:pt-32">
                            <input type="search" id="<?php echo esc_attr( $inf_unique_id ); ?>" placeholder="<?php _e('Start typing', 'inf') ?>" class="py-4 px-6 rounded-none flex-grow bg-transparent border-b-2 border-white font-sans text-base text-white" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="w-32 md:w-48 cursor-pointer bg-white text-green py-4 px-12"><?php echo esc_attr_x( 'Go', 'submit button', 'inf' ); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
