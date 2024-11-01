<?php
/*
Plugin Name: XML Editor
Plugin URI: http://www.ghtech.org/tools/plugins.html
Description: This plugin loads an XML file specifying different "bricks" used to make up a fundraising image map.  
The plugin parses this file and displays the data in the admin tools menu as a form for editing as bricks are purchased.  
Once edited, the plugin saves the new file to the original location, overwriting the original file.  Compatible with Wordpress 2.7+
Version: 1.0
Author: Eric Lagally
Author URI: http://eric.lagallyconsulting.com
License: GPL2
*/





/*  Copyright 2011  Eric Lagally  (email : eric.lagally@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/




// Add Options page under Settings menu
function buybrick_menu() {
	add_plugins_page('XML Editor Options', 'XML Editor Options', 'manage_options', 'buybrickplugin', 'buybrick_options_page');
}
// Add Management page under Tools menu - this is where the magic happens 
function buybrick_edit() {
	add_management_page('XML Editor', 'XML Editor', 'manage_options', 'buymybrick', 'buybrick_now');
}

function buybrick_options_page() {
	?>
	<div id="wrap">
		<form action="options.php" method="post">
		<?php settings_fields('buybrick_options'); ?>
		<?php do_settings_sections('buybrickplugin'); ?>
			<input name="Submit" class="button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</form>
	</div>
<?php
}

function buybrick_now() {
	include('xmleditparser.php');
}

 // add the admin settings and such


function buybrick_admin_init(){
	register_setting( 'buybrick_options', 'buybrick_options', 'buybrick_options_validate' );
	
	add_settings_section('buybrick_main', 'XML Editor Settings', 'buybrick_section_text', 'buybrickplugin');
	add_settings_field('buybrick_xmlpath', '<strong>Path to XML file</strong><br />Enter the name of the XML file to edit as a path from your website\'s home directory.', 'buybrick_xmlpath_string', 'buybrickplugin', 'buybrick_main');	
	add_settings_field('buybrick_numfields', '<strong>Fundraising Levels</strong><br />Enter the various fundraising levels represented in the bricks, separated by commas.', 'buybrick_numfields_string', 'buybrickplugin', 'buybrick_main');
	add_settings_field('buybrick_linkpath', '<strong>Purchase Links Path</strong><br />Enter the base path (including http://) to the links that the bricks connect to.  See instructions for more details.', 'buybrick_setting_string', 'buybrickplugin', 'buybrick_main');
	add_settings_field('buybrick_bricklinks', '<strong>Individual Brick Links</strong><br />For each brick amount, enter the link the brick will direct to, separated by commas. See instructions for more details.', 'buybrick_link_string', 'buybrickplugin', 'buybrick_main');
	add_settings_field('buybrick_imagespath', '<strong>Images Path</strong><br />Enter the base path (including http://) to the images specifying the purchased and unpurchased bricks. See instructions for more details.', 'buybrick_imgpath_string', 'buybrickplugin', 'buybrick_main');
	add_settings_field('buybrick_pbrickimg', '<strong>Purchased Brick Image</strong><br />Enter the filename for the purchased brick image.', 'buybrick_pimage_string', 'buybrickplugin', 'buybrick_main');
	add_settings_field('buybrick_upbrickimg', '<strong>Unpurchased Brick Image</strong><br />Enter the filename for the unpurchased brick image.', 'buybrick_upimage_string', 'buybrickplugin', 'buybrick_main');
}

 function buybrick_section_text() {
	echo '<p>Here you can configure the XML Editor</p>';
} 

function buybrick_xmlpath_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_xmlpath' name='buybrick_options[xmlpath]' size='40' type='text' value='{$options['xmlpath']}' />";
}

function buybrick_setting_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_linkpath' name='buybrick_options[linkpath]' size='40' type='text' value='{$options['linkpath']}' />";
}

function buybrick_numfields_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_numfields' name='buybrick_options[numfields]' size='40' type='text' value='{$options['numfields']}' />";	
}

function buybrick_link_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_bricklinks' name='buybrick_options[bricklinks]' size='40' type='text' value='{$options['bricklinks']}' />";	
}

function buybrick_imgpath_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_imagespath' name='buybrick_options[imagespath]' size='40' type='text' value='{$options['imagespath']}' />";	
}

function buybrick_pimage_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_pbrickimg' name='buybrick_options[pbrickimg]' size='40' type='text' value='{$options['pbrickimg']}' />";	
}

function buybrick_upimage_string() {
	$options = get_option('buybrick_options');
	echo "<input id='buybrick_upbrickimg' name='buybrick_options[upbrickimg]' size='40' type='text' value='{$options['upbrickimg']}' />";	
}

 // validate our options
function buybrick_options_validate($buybrick_options) {
	$patterns = array();
	$patterns[0] = '/\$/';
//	$patterns[1] = '/[a-z]/';
	$patterns[3] = '/[?#@\\\]/';	
	$buybrick_options['xmlpath'] = preg_replace( $patterns, '', $buybrick_options['xmlpath'] );
	$buybrick_options['numfields'] = preg_replace( $patterns, '', $buybrick_options['numfields'] );
	$buybrick_options['linkpath'] = preg_replace( $patterns, '', $buybrick_options['linkpath'] );
	$buybrick_options['bricklinks'] = preg_replace( $patterns, '', $buybrick_options['bricklinks'] );
	$buybrick_options['imagespath'] = preg_replace( $patterns, '', $buybrick_options['imagespath'] );
	$buybrick_options['pbrickimg'] = preg_replace( $patterns, '', $buybrick_options['pbrickimg'] );
	$buybrick_options['upbrickimg'] = preg_replace( $patterns, '', $buybrick_options['upbrickimg'] );
	
	return $buybrick_options;
}

add_action('admin_menu', 'buybrick_menu');
add_action('admin_menu', 'buybrick_edit');
add_action('admin_init', 'buybrick_admin_init');
add_action( 'admin_head', 'admin_register_buybrick_styles' );
//add stylesheet
function admin_register_buybrick_styles(){
	$url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'xmledit.css';
	echo "<link rel='stylesheet' href='$url' />\r\n"; 
}

//add a settings link on the plugins page
function buybrick_settings_link($links){

  $settings_link = '<a href="plugins.php?page=buybrickplugin">Settings</a>';
  array_unshift($links, $settings_link);
  return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", "buybrick_settings_link");
?>