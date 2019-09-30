<?php
/**
 * Flatsome Infinite scroll extension
 *
 * @author     UX Themes
 * @category   Extension
 * @package    Flatsome/Extensions
 * @since      3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Flatsome_Infinite_Scroll
 */
class Flatsome_Infinite_Scroll {

	/**
	 * Version number
	 *
	 * @var string
	 */
	private $version = '1.5';

	/**
	 * Holds loader type selected from theme settings.
	 * ex. button, spinner, image, etc.
	 *
	 * @var string
	 */
	private $loader_type;

	/**
	 * Holds category list style from theme settings.
	 * ex. grid, list, masonry
	 *
	 * @var string
	 */
	private $list_style;

	/**
	 * Static instance
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Flatsome_Infinite_Scroll constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initializes the extension object and returns its instance
	 *
	 * @return object The extension object instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize extension
	 */
	public function init() {
		if ( is_admin() ) {
			return;
		} // Disable for admin

		$this->loader_type = get_theme_mod( 'infinite_scroll_loader_type', 'spinner' );
		$this->list_style  = get_theme_mod( 'category_grid_style',  'grid' );

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 99 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'add_page_loader' ), 20 );
		add_action( 'wp_head', array( $this, 'add_css' ), 110 );
	}

	/**
	 * Add extension scripts
	 */
	public function add_scripts() {
		global $extensions_uri;
		wp_enqueue_script( 'flatsome-infinite-scroll-js', get_template_directory_uri() . '/assets/libs/infinite-scroll.pkgd.min.js', array( 'jquery', 'flatsome-js' ), '3.0.4', true );
		wp_enqueue_script( 'flatsome-infinite-scroll', $extensions_uri . '/flatsome-infinite-scroll/flatsome-infinite-scroll.js', array( 'jquery', 'flatsome-js' ), $this->version, true );

		$params = array(
			'scroll_threshold' => 400,
			'fade_in_duration' => 300,
			'type'             => $this->loader_type,
			'list_style'       => $this->list_style,
			'history'          => 'push',
		);

		wp_localize_script( 'flatsome-infinite-scroll', 'flatsome_infinite_scroll', apply_filters( 'flatsome_infinite_scroll_params', $params ) );
	}

	/**
	 *  Adds page loader template
	 */
	public function add_page_loader() {
		$this->get_template( $this->loader_type );
	}

	/**
	 * Add extension CSS
	 */
	public function add_css() {
		ob_start();
		?>
		<style id="infinite-scroll-css" type="text/css">
			.page-load-status,
			.archive .woocommerce-pagination {
				display: none;
			}
		</style>
		<?php
		$css = ob_get_clean();
		echo flatsome_minify_css( $css ); // @codingStandardsIgnoreLine
	}

	/**
	 * Gets and includes loader template file specified by name.
	 *
	 * @param string $name Name of the template.
	 */
	private function get_template( $name ) {
		global $extensions_url;
		$template = $extensions_url . "/flatsome-infinite-scroll/templates/{$name}.php";
		include $template;
	}
}

/**
 * Init Flatsome_Infinite_Scroll
 */
Flatsome_Infinite_Scroll::get_instance();
