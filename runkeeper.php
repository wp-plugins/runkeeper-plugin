<?php
/*
Plugin Name: Runkeeper
Plugin URI: http://sandjam.co.uk/sandjam/2010/04/runkeeper-wordpress-plugin/
Description: Insert a runkeeper preview into a post using the [runkeeper url=""] shortcode or a custom field called "runkeeper"
Author: Peter Smith
Version: 2.1
Author URI: http://sandjam.co.uk
*/

class WPRunkeeper {
	private $url, $with, $height, $x, $y = '';
	private $defaultOptions = array('rk_width'=>600, 'rk_height'=>400, 'rk_x'=>300, 'rk_y'=>300);

	public function __construct(){
		// add install/uninstall hooks
		register_activation_hook(__FILE__, array($this, 'install'));
		register_uninstall_hook( __FILE__, array($this, 'uninstall'));
		
		// add the admin options page
		add_action('admin_menu', array($this, 'admin_add_page'));
		
		// add the admin settings and such
		add_action('admin_init', array($this, 'admin_init'));
		
		// add the hook to render the iframe in posts
		add_shortcode('runkeeper', array($this, 'render_shortcode'));
		
		// add the hook to pick the runkeeper url out of the custom fields
		add_filter('the_post', array($this, 'filter_post'));
		add_filter('the_content', array($this, 'render_content'));
	}
	
	// ------------------------------------------------------------
	// INSTALLATION
	// ------------------------------------------------------------
	public function install() {
		$options = $this->defaultOptions;
		add_option('runkeeper_options', $options);
	}
	
	public function uninstall() {
		delete_option('runkeeper_options');
	}
	
	// ------------------------------------------------------------
	// ADMIN OPTIONS PAGES 
	// ------------------------------------------------------------	
	public function admin_add_page() {
		add_options_page('Runkeeper', 'Runkeeper', 'manage_options', 'runkeeper_settings_page', array($this, 'settings_page'));
	}
	public function admin_init(){
		register_setting('rk_options', 'rk_options', array($this, 'rk_settings_validate'));
		add_settings_section('basic_settings_section', 'Runkeeper Settings', array($this, 'basic_settings_text'), 'basic_settings');
		add_settings_field('rk_width', 'Width (px)', array($this, 'rk_width_setting'), 'basic_settings', 'basic_settings_section');
		add_settings_field('rk_height', 'Height (px)', array($this, 'rk_height_setting'), 'basic_settings', 'basic_settings_section');
		add_settings_field('rk_x', 'X Offset (px)', array($this, 'rk_x_setting'), 'basic_settings', 'basic_settings_section');
		add_settings_field('rk_y', 'Y Offset (px)', array($this, 'rk_y_setting'), 'basic_settings', 'basic_settings_section');
	}	
	public function basic_settings_text() {
		echo '';
	}
	public function rk_width_setting() {
		$options = get_option('rk_options');
		echo "<input id='rk_width' name='rk_options[rk_width]' size='8' type='text' value='{$options['rk_width']}' />";
	}
	public function rk_height_setting() {
		$options = get_option('rk_options');
		echo "<input id='rk_height' name='rk_options[rk_height]' size='8' type='text' value='{$options['rk_height']}' />";
	}
	public function rk_x_setting() {
		$options = get_option('rk_options');
		echo "<input id='rk_x' name='rk_options[rk_x]' size='8' type='text' value='{$options['rk_x']}' />";
	}
	public function rk_y_setting() {
		$options = get_option('rk_options');
		echo "<input id='rk_y' name='rk_options[rk_y]' size='8' type='text' value='{$options['rk_y']}' />";
	}
	public function rk_settings_validate($input) {
		return $input;
	}
	
	// display the admin options page
	public function settings_page() {
		$options = get_option('runkeeper_options');
		if ($options==''){
			$options = $this->default_options;
		}
		?>
		<div>
			<form action="options.php" method="post">
			<?php settings_fields('rk_options'); ?>
			<?php do_settings_sections('basic_settings'); ?>
			<p><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>
		</div>
		<?php
	}
	
	// ------------------------------------------------------------
	// USE TAG TO RENDER SNIPPIT ON PAGE 
	// ------------------------------------------------------------
	public function render_shortcode($vars) {
		$options = get_option('rk_options');
		$html = '';
		
		if (isset($vars['width']) && is_numeric($vars['width'])) {
			$this->width = $vars['width'];
		}
		if (isset($vars['height']) && is_numeric($vars['height'])) {
			$this->width = $vars['height'];
		}
		if (isset($vars['x']) && is_numeric($vars['rk_x'])) {
			$this->x = $vars['x'];
		}
		if (isset($vars['y']) && is_numeric($vars['rk_y'])) {
			$this->y = $vars['y'];
		}
		
		if (isset($vars['url'])) {
			$this->url = $vars['url'];
		}

		if ($this->url!='') {
			$html .= $this->get_html();
		}
		
		return $html;
	}
	
	function filter_post($post) {
		$url = get_post_meta($post->ID, 'runkeeper', true);
		if ($url!='') {
			$this->url = $url;
		}
	}
	
	function render_content($str) {
		$html = '';
		
		if ($this->url!='') {
			$html .= $this->get_html();
		}
		
		return $str.$html;
	}
		
	function get_html() {
		
 		// include plugin css and js
		wp_enqueue_script('runkeeper_js', plugin_dir_url( __FILE__ ) . 'runkeeper.js');
		
		$html = '';
		
		$options = get_option('rk_options');
		if (!isset($options['rk_width']) || $options['rk_width']=='') { $options['rk_width'] = $this->defaultOptions['rk_width']; }
		if (!isset($options['rk_height']) || $options['rk_height']=='') { $options['rk_height'] = $this->defaultOptions['rk_height']; }
		if (!isset($options['rk_x']) || $options['rk_x']=='') { $options['rk_x'] = $this->defaultOptions['rk_x']; }
		if (!isset($options['rk_y']) || $options['rk_y']=='') { $options['rk_y'] = $this->defaultOptions['rk_y']; }

		if ($this->width=='') { $this->width = $options['rk_width']; }
		if ($this->height=='') { $this->height = $options['rk_height']; }
		if ($this->x=='') { $this->x = $options['rk_x']; }
		if ($this->y=='') { $this->y = $options['rk_y']; }
		if ($this->x > 0) { $this->x = $this->x*-1; }
		if ($this->y > 0) { $this->y = $this->y*-1; }
		$html .= '<div id="runkeeper" title="'.$this->url.','.$this->x.','.$this->y.'" style="overflow:hidden; width:'.$this->width.'px; height:'.$this->height.'px;"></div>';	
		
		return $html;
	}
}

$wpRunkeeper = new WPRunkeeper();
?>
