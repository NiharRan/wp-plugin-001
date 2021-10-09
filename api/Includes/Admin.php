<?php

namespace Nihar\WpApi\Includes;

class Admin
{
    public function __construct()
    {
        add_action("admin_menu", [$this, 'admin_menu']);
        add_action("admin_enqueue_scripts", [$this, "register_styles_and_scripts"], 99);
    }


    public function register_styles_and_scripts()
    {
        $this->load_styles();
        $this->load_scripts();
    }

    public function load_styles()
    {
        wp_register_style(
            'wp-vue-css',
            WP_VUE_PLUGIN_URL . 'assets/app.css',
            [],
            false
        );

        wp_enqueue_style('wp-vue-css');
    }

    public function load_scripts()
    {
        wp_register_script(
            'wp-vue-js',
            WP_VUE_PLUGIN_URL . 'assets/main.js',
            [],
            rand(),
            true
        );


        wp_enqueue_script('wp-vue-js');


        wp_localize_script('wp-vue-admin', 'WpVue', [
            'adminUrl' => admin_url('/'),
            'ajaxUrl' => admin_url('/admin-ajax.php'),
            'apiUrl' => home_url('/wp-json')
        ]);
    }

    public function admin_menu()
    {
        global $submenu;
        $capability = 'manage_options';
        $slug = 'wp-vue';

        $hook = add_menu_page(
            "Wp Vue",
            "Wp Vue",
            $capability,
            $slug,
            [$this, 'menu_page_template'],
            'dashicons-buddicons-replies'
        );


        if (current_user_can($capability)) {
            $submenu[$slug][] = ["Wp Vue", $capability, 'admin.php?page=' . $slug . '#/'];
            $submenu[$slug]['settings'] = ["Settings", $capability, 'admin.php?page=' . $slug . '#/settings'];
        }
    }

    public function menu_page_template()
    {
        echo '<div class="wrap"><div id="wp-vue"></div></div>';
    }
}
