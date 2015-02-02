<?php
/*
  Plugin Name: DeMomentSomTres Lazy Load compatibility for WP Canvas Gallery
  Plugin URI: http://demomentsomtres.com
  Description: Bla bla bla
  Author: DeMomentSomTres
  Author URI: http://demomentsomtres.com
  Version: 0.1
  License: GPLv2 or later
 */

define('DMS3_WCANVAS_LAZY_TEXT_DOMAIN', 'DeMomentSomTres-Canvas-Lazy');

if (!function_exists('is_plugin_active'))
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
if ((!is_plugin_active('demomentsomtres-tools/demomentsomtres-tools.php')) && (!is_plugin_active_for_network('demomentsomtres-tools/demomentsomtres-tools.php'))):
    add_action('admin_notices', 'DMS3_canvas_lazy_messageNoTools');
else:
    if ((!is_plugin_active('wc-gallery/wc-gallery.php')) && (!is_plugin_active_for_network('wc-gallery/wc-gallery.php'))):
        add_action('admin_notices', 'DMS3_canvas_lazy_messageNoWCGallery');
    else:
        if ((!is_plugin_active('bj-lazy-load/bj-lazy-load.php')) && (!is_plugin_active_for_network('bj-lazy-load/bj-lazy-load.php'))):
            add_action('admin_notices', 'DMS3_canvas_lazy_messageNoBJLazyLoad');
        else:

            $dms3_canvas_lazy = new DeMomentSomTresCanvasLazy();
        endif;
    endif;
endif;

function DMS3_canvas_lazy_messageNoTools() {
    ?>
    <div class="error">
        <p><?php _e('The DeMomentSomTres Lazy Load Compatibility for WP Canvas Gallery plugin requires the free DeMomentSomTres Tools plugin.', DMS3_WCANVAS_LAZY_TEXT_DOMAIN); ?>
            <br/>
            <a href="http://demomentsomtres.com/english/wordpress-plugins/demomentsomtres-tools/?utm_source=web&utm_medium=wordpress&utm_campaign=adminnotice&utm_term=dms3CanvasLazy" target="_blank"><?php _e('Download it here', DMS3_WCANVAS_LAZY_TEXT_DOMAIN); ?></a>
        </p>
    </div>
    <?php
}

function DMS3_canvas_lazy_messageNoBJLazyLoad() {
    ?>
    <div class="error">
        <p><?php _e('The DeMomentSomTres Lazy Load Compatibility for WP Canvas Gallery plugin requires BJ Lazy Load Plugin.', DMS3_WCANVAS_LAZY_TEXT_DOMAIN); ?>
        </p>
    </div>
    <?php
}

function DMS3_canvas_lazy_messageNoWCGallery() {
    ?>
    <div class="error">
        <p><?php _e('The DeMomentSomTres Lazy Load Compatibility for WP Canvas Gallery plugin requires WP Canvas Gallery plugin.', DMS3_WCANVAS_LAZY_TEXT_DOMAIN); ?>
        </p>
    </div>
    <?php
}

class DeMomentSomTresCanvasLazy {

    const TEXT_DOMAIN = DMS3_WCANVAS_LAZY_TEXT_DOMAIN;
    const MENU_SLUG = 'dmst_wcanvas_lazy';
    const OPTIONS = 'dmst_wcanvas_lazy_options';
    const PAGE = 'dmst_wcanvas_lazy';

    private $pluginURL;
    private $pluginPath;
    private $langDir;

    /**
     * @since 1.0
     */
    function __construct() {
        $this->pluginURL = plugin_dir_url(__FILE__);
        $this->pluginPath = plugin_dir_path(__FILE__);
        $this->langDir = dirname(plugin_basename(__FILE__)) . '/languages';

        add_action('plugins_loaded', array(&$this, 'plugin_init'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    }

    /**
     * @since 1.0
     */
    function plugin_init() {
        load_plugin_textdomain(DMS3_WCANVAS_LAZY_TEXT_DOMAIN, false, $this->langDir);
    }

    function enqueue_scripts() {
        
        wp_enqueue_script('dms3BJLLWC',$this->pluginURL.'/js/demomentsomtres-wc-lazy.js',array('BJLL','jquery-masonry'));
    }
}
