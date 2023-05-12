<?php

namespace App;

/**
 * Register BGA Block Category
 *
 * @param   array $block_categories                         Array of categories for block types.
 * @param   WP_Block_Editor_Context $block_editor_context   The current block editor context.
 */
add_filter( 'block_categories_all', function ( $block_categories ) {
    // You can add extra validation such as seeing which post type
    // is used to only include categories in some post types.
    // if ( in_array( $block_editor_context->post->post_type, ['post', 'my-post-type'] ) ) { ... }

    return array_merge(
        $block_categories,
        [
            [
                'slug'  => 'custom-blocks',
                'title' => esc_html__( 'Custom Blocks', 'sage' )
            ],
        ]
    );
} );
