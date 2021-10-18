<?php

namespace Nihar\WpApi\Includes;

use Nihar\WpApi\Models\User;

class Frontend
{
    protected $user;
    public function __construct()
    {
        $this->register_shortcode();
        add_action("wp_enqueue_scripts", [$this, "register_scripts_and_styles"]);
        $this->user = new User();
    }


    public function register_shortcode()
    {
        add_shortcode('WPVUESC-001', [$this, 'add_user_list_shortcode']);
        add_shortcode("WPVUE-CREATE-USER", [$this, "add_user_modify_shortcode"]);
    }

    public function register_scripts_and_styles()
    {
        $this->load_scripts();
        $this->load_styles();
    }

    public function load_scripts()
    {
    }

    public function load_styles()
    {
        wp_register_style(
            'wp-vue-front-css',
            WP_VUE_PLUGIN_URL . "assets/app.css",
            [],
            false
        );

        wp_enqueue_style('wp-vue-front-css');
    }

    public function add_user_list_shortcode($atts, $content = null)
    {
        ob_start();
        $data['users'] = $this->user->get_all_users();
        extract($data);
        require_once WP_VUE_VIEW_DIR . "shortcodes/user-list.php";
        return ob_get_clean();
    }

    public function add_user_modify_shortcode()
    {
        ob_start();
        $data['user'] = null;
        $data['action'] = $action = $_REQUEST['action'];
        if ($action == 'edit') {
            $data['id'] = $id = $_REQUEST['id'];
            $data['user'] = $this->user->find($id);
        }
        extract($data);
        require_once WP_VUE_VIEW_DIR . "shortcodes/user-modify.php";
        return ob_get_clean();
    }
}
