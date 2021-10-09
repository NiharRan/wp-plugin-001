
<?php
/**
 * @link            https://wp-vue.com
 * @since           1.0.0
 * @package         WP_Vue
 *
 * Plugin Name: WP Vue
 * Plugin URI: https://wp-vue.com
 * Description: A wp vue starter for plugin development.
 * Version: 1.0.0
 * Author: Nihar Ranjan Das
 * Author URI: https://nihardev.me
 * License: GPL v3
 * Text-Domain: textdomain
 */

use Nihar\WpApi\Api;
use Nihar\WpApi\Includes\Admin;

if (!defined('ABSPATH')) exit(); // No direct access allowed

/**
 * Require Autoloader
 */

require_once "vendor/autoload.php";


class WP_VUE
{

    protected $version = '1.0';
    public function __construct()
    {
        $this->register_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deativate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    public function register_constants()
    {
        global $wpdb;
        define("WP_VUE_VERSION", $this->version);
        define("SMART_TABLE", $wpdb->prefix . 'smrt_table');
        define("WP_VUE_PLUGIN_URL", trailingslashit(plugin_dir_url(__FILE__)));
        define("WP_VUE_PLUGIN_DIR", trailingslashit(plugin_dir_url(__FILE__)));
        define('WPVK_NONCE', 'b?le*;K7.T2jk_*(+3&[G[xAc8O~Fv)2T/Zk9N:GKBkn$piN0.N%N~X91VbCn@.4');
    }

    public function activate()
    {
        $this->create_database_schema();

        $is_installed = get_option("wp_vue_installed");
        if (!$is_installed) {
            update_option("wp_vue_installed", time());
        }

        update_option("wp_vue_installed", WP_VUE_VERSION);
    }

    public function create_database_schema()
    {
        global $wpdb;

        $table_name = SMART_TABLE;

        // need to create the table for plugin
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            role VARCHAR(10) NULL,
            status TINYINT(4) DEFAULT 1,

            PRIMARY KEY  (id)
        )";

        require_once ABSPATH . "wp-admin/includes/upgrade.php";
        dbDelta($sql);

        $smart_table_data = [
            [
                'name' => 'Nihar Ranjan Das',
                'email' => 'niharranjandasmu@gmail.com',
                'role' => 'admin',
                'status' => 1
            ],
            [
                'name' => 'Akash Das',
                'email' => 'akash@gmail.com',
                'role' => 'customer',
                'status' => 1
            ],
        ];

        foreach ($smart_table_data as $data) {
            $wpdb->insert(SMART_TABLE, $data);
        }
    }

    public function deativate()
    {
        global $wpdb;
        $table_name = SMART_TABLE;

        $sql = "DROP TABLE $table_name";
        $wpdb->query($sql);
    }

    public function init_plugin()
    {
        new Admin();
        new Api();
    }

    public static function init()
    {
        $instance = null;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }
}


if (!function_exists('wp_vue_start')) {
    function wp_vue_start()
    {
        WP_VUE::init();
    }
}

wp_vue_start();
