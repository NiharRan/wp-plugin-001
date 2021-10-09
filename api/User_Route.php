<?php

namespace Nihar\WpApi;

use Nihar\WpApi\Models\User;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Server;

class User_Route extends WP_REST_Controller
{
    protected $namespace = '';
    protected $basename = '';
    protected $user;
    public function __construct()
    {
        $this->user = new User();
        $this->namespace = 'wp-vue/v1';
    }


    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/users',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_users'],
                    'permission_callback' => [$this, 'get_users_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store'],
                    'permission_callback' => [$this, 'get_users_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'update'],
                    'permission_callback' => [$this, 'get_users_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'delete'],
                    'permission_callback' => [$this, 'get_users_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );
    }

    public function get_users(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $data = [];
        if (isset($params['id'])) {
            $data['id'] = $params['id'];
        }
        $response = $this->user->get_all_users($data);
        return $response;
    }


    public function store(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $data['name'] = $params['name'];
        $data['email'] = $params['email'];
        $data['role'] = $params['role'];
        $data['status'] = 1;
        $result = $this->user->store($data);
        return $result;
    }

    public function update(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $data['name'] = $params['name'];
        $data['email'] = $params['email'];
        $data['role'] = $params['role'];
        $data['status'] = $params['status'];
        $result = $this->user->update($data, $params['id']);
        return $result;
    }


    public function get_users_permission_check()
    {
        return true;
    }
}
