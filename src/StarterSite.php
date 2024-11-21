<?php

namespace App;

use Timber\Site;
use Timber\Timber;

/**
 * Class StarterSite
 */
class StarterSite extends Site
{
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));

		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_filter('timber/twig/environment/options', [$this, 'update_twig_environment_options']);

		parent::__construct();
	}

	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types()
	{
		$publication_args = array(
			'labels' => array(
				'name' => 'Publications',
				'singular_name' => 'Publication',
				'add_new_item' => 'Add New Publication',
				'edit_item' => 'Edit Publication',
				'new_item' => 'New Publication',
				'view_item' => 'View Publication',
				'view_items' => 'View Publications',
				'search_items' => 'Search Publications',
				'not_found' => 'No publication found',
				'not_found_in_trash' => 'No publication found in trash',
				'all_items' => 'All Publications',
				'archives' => 'Publication Archives',
				'attributes' => 'Publication Attributes',
				'insert_into_item' => 'Insert into publication',
				'uploaded_to_this_item' => 'Uploaded to this publication',
				'filter_items_list' => 'Filter publications list',
				'items_list_navigation' => 'Publications list navigation',
				'items_list' => 'Publications list',
				'item_published' => 'Publication published...',
				'item_published_privately' => 'Publication published privately...',
				'item_reverted_to_draft' => 'Publication reverted to draft.',
				'item_trashed' => 'Publication trashed.',
				'item_scheduled' => 'Publication scheduled.',
				'item_updated' => 'Publication updated.',
				'item_link' => 'Publication Link',
				'item_link_description' => 'A link to a publication.'
			),
			'description' => 'Datasheets, brochures, flyers, white papers, etc.',
			'public' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-admin-page',
			'supports' => array(
				'title',
				'editor',
				'author',
				'excerpt',
				'thumbnail'
			),
			'has_archive' => 'publications',
			'rewrite' => array('slug' => 'publication'),
			'template' => array(
				array('core/image'),
				array('core/paragraph')
			)
		);

		register_post_type( 'publication', $publication_args );
	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies()
	{
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = Timber::get_menu();
		$context['site']  = $this;

		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}

	/**
	 * This would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo($text)
	{
		$text .= ' bar!';
		return $text;
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig($twig)
	{
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter(new \Twig\TwigFilter('myfoo', [$this, 'myfoo']));

		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * @param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options($options)
	{
		// $options['autoescape'] = true;

		return $options;
	}
}
