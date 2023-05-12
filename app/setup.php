<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('icomoon/intulse', 'https://d1azc1qln24ryf.cloudfront.net/141886/Intulse/style-cf.css?fh5sna', false, null);
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_style( 'editor-css', asset_path('/styles/editor.css'), [], false, 'all' );
    wp_enqueue_style('icomoon/intulse', 'https://d1azc1qln24ryf.cloudfront.net/141886/Intulse/style-cf.css?fh5sna', false, null);
});

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {

    /**
     * Enable features from the Soil plugin if activated.
     * for Soil 4.x
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);


    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Add Excerpt
     * @link https://wordpress.org/support/article/settings-sidebar/#excerpt
     */
    add_post_type_support( 'page', 'excerpt' );

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/editor.css'));

    /**
     * Add Gutenberg supports
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
     * @see resources/assets/styles/common/_variables.scss
     */
    add_theme_support( 'editor-styles' );
    add_theme_support ('align-wide');
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_attr__( 'Primary', 'sage' ),
            'slug'  => 'primary',
            'color' => '#0079c2',
        ),
        array(
            'name'  => esc_attr__( 'Secondary', 'sage' ),
            'slug'  => 'secondary',
            'color' => '#495965',
        ),
        array(
            'name'  => esc_attr__( 'Dark Grey', 'sage' ),
            'slug'  => 'dark-grey',
            'color' => '#242424',
        ),
        array(
            'name'  => esc_attr__( 'Light Grey', 'sage' ),
            'slug'  => 'light-grey',
            'color' => '#ccc',
        ),
        array(
            'name'  => esc_attr__( 'Light Grey 2', 'sage' ),
            'slug'  => 'light-grey-2',
            'color' => '#e7eaeb',
        ),
        array(
            'name'  => esc_attr__( 'Light Grey 3', 'sage' ),
            'slug'  => 'light-grey-3',
            'color' => '#f7f5f6',
        ),
        array(
            'name'  => esc_attr__( 'Black', 'sage' ),
            'slug'  => 'black',
            'color' => '#000',
        ),
        array(
            'name'  => esc_attr__( 'White', 'sage' ),
            'slug'  => 'white',
            'color' => '#fff',
        ),
    ));
}, 20);

/**
 * Change ACF Color Picker Palette to match options above
 */
add_action('acf/input/admin_footer', function () {
    ?><script type="text/javascript">
    (function($) {
        acf.add_filter('color_picker_args', function( args, $field ){
            args.palettes = ["#0079c2", "#495965", "#242424", "#ccc", "#e7eaeb", "#f7f5f6" "#000", "#fff"]
            return args;
        });
    })(jQuery);
    </script>
    <?php });

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Initialize ACF Builder in Fields folder
 */
add_action('init', function () {
    collect(glob(config('theme.dir').'/app/Fields/*.php'))->map(function ($field) {
        return require_once($field);
    })->map(function ($field) {
        if ($field instanceof FieldsBuilder) {
            acf_add_local_field_group($field->build());
        }
    });
});

/**
 * Initialize ACF Builder in Blocks folder
 */
add_action('init', function () {
	collect(glob(config('theme.dir').'/app/Blocks/*.php'))->map(function ($field) {
			return require_once($field);
	})->map(function ($field) {
			if ($field instanceof FieldsBuilder) {
					acf_add_local_field_group($field->build());
			}
	});
});

// Remove <p> tag wraps around everyting in Contact Forms.
add_filter( 'wpcf7_autop_or_not', '__return_false' );
