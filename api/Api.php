<?php

namespace Nihar\WpApi;

use WP_REST_Controller;

class Api extends WP_REST_Controller
{
    public function __construct()
    {
        add_action("rest_api_init", [$this, 'register_routes']);
    }

    public function register_routes()
    {
        (new User_Route)->register_routes();
    }
}
