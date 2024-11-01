<?php
/*
Plugin Name: WP MooTools CDN
Description: Activate Plugin and Select a MooTools CDN via the WP MooTools CDN options area ** Version numbers reference the MooTools Library
Author: InertiaInMotion
Version: 1.3.2.007
Author URI: http://inertiainmotion.com.au/
Plugin URI: http://wordpress.org/extend/plugins/wp-mootools-cdn/
*/
/*  Copyright 2011 InertiaInMotion

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
?>
<?php $mootools_version = "1.3.2"; ?>
<?php
	function wp_mootools_cdn_options_init(){
    	register_setting( 'wp_mootools_cdn_options', 'wp_mootools_cdn' );
	}
	add_action('admin_init', 'wp_mootools_cdn_options_init' );

    function wp_mootools_cdn_menu(){
    
        add_menu_page('WP MooTools CDN', 'WP MooTools CDN', 'manage_options', 'wp_mootools_cdn', 'wp_mootools_cdn');

	}
	add_action('admin_menu', 'wp_mootools_cdn_menu');

	function wp_mootools_cdn(){
        if(!current_user_can('manage_options')){
	        wp_die( __('You do not have sufficient permissions to access this page.') );
	    } ?>
	    <link rel="stylesheet" href="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-mootools-cdn/options.css" type="text/css" />
        <form id="options-form" method="post" action="options.php">
            <em>Set it and forget it...</em>
            <h1>WP MooTools CDN</h1>
        	<?php settings_fields('wp_mootools_cdn_options'); ?>
            <?php $options = get_option('wp_mootools_cdn'); ?>
			<select type="select" name="wp_mootools_cdn">
            	<option value="1" <?php if($options['wp_mootools_cdn'] == "1"){ echo "selected='selected'"; } ?>>
            		Google Ajax API MooTools CDN
            	</option>
                <option value="2" <?php if($options['wp_mootools_cdn'] == "2"){ echo "selected='selected'"; } ?>>
                	Local MooTools (Inside this plugins js folder)
                </option>
                <option value="3" <?php if($options['wp_mootools_cdn'] == "3"){ echo "selected='selected'"; } ?>>
					None (Dont load any mootools, Or i wish to load it myself)
			    </option>
           	</select>
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
            <p class="shameless-plug">Created by: <a href="http://inertiainmotion.com.au">inertiainmotion.com.au</a></p>
         </form><?php

	}
    $options = get_option('wp_mootools_cdn');
    
    if($options['wp_mootools_cdn'] != "3"){
    	if($options['wp_mootools_cdn'] == "1"){
			function wp_mootools_cdn_init(){
    			if (!is_admin()){
    				global $mootools_version;
        			wp_deregister_script('mootools');
        			wp_register_script('mootools', 'http://ajax.googleapis.com/ajax/libs/mootools/' . $mootools_version . '/mootools-yui-compressed.js');
        			wp_enqueue_script('mootools');
        		}
        	}
			add_action('init', 'wp_mootools_cdn_init');
    	}
    	 
    	if($options['wp_mootools_cdn'] == "2"){
			function wp_mootools_cdn_init(){
    			if (!is_admin()){
        			wp_deregister_script('mootools');
        			wp_register_script('mootools', '/wp-content/plugins/wp-mootools-cdn/js/local-mootools.js');
        			wp_enqueue_script('mootools');
        		}
        	}
			add_action('init', 'wp_mootools_cdn_init');
    	}
    	  	     	     	    	 
    }
        			
?>