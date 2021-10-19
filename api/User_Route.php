<?php

namespace Nihar\WpApi;

use Nihar\WpApi\Models\User;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
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
                    'callback' => [$this, 'destroy'],
                    'permission_callback' => [$this, 'get_users_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );
    }

    public function get_users(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $response = $this->user->get_filter_users($params);
        return $response;
    }


    public function store(WP_REST_Request $request)
    {
        $params = $request->get_params();

        $errors = [];

        if (is_empty('name', $params)) {
            $errors['name'] = 'Name is required';
        } elseif (!isset($errors['name'])) {
            $errors['name'] = '';
        }

        if (is_empty('email', $params)) {
            $errors['email'] = 'E-mail is required';
        } elseif (!isset($errors['email'])) {
            $errors['email'] = '';
        }

        if (is_empty('role', $params)) {
            $errors['role'] = 'Role is required';
        } elseif (!isset($errors['role'])) {
            $errors['role'] = '';
        }

        if (!is_unique('name', $params)) {
            $errors['name'] = 'Name is already exist';
        } elseif (!isset($errors['name'])) {
            $errors['name'] = '';
        }

        if (!is_unique('email', $params)) {
            $errors['email'] = 'E-mail is already exist';
        } elseif (!isset($errors['email'])) {
            $errors['email'] = '';
        }


        if (!is_validate($errors)) {
            return new WP_REST_Response($errors, 404);
        }

        $data['name'] = $params['name'];
        $data['email'] = $params['email'];
        $data['role'] = $params['role'];
        $data['status'] = 1;
        $result = $this->user->store($data);
        return new WP_REST_Response($result);
    }

    public function update(WP_REST_Request $request)
    {
        $params = $request->get_params();

        $errors = [];

        if (is_empty('name', $params)) {
            $errors['name'] = 'Name is required';
        } elseif (!isset($errors['name'])) {
            $errors['name'] = '';
        }

        if (is_empty('email', $params)) {
            $errors['email'] = 'E-mail is required';
        } elseif (!isset($errors['email'])) {
            $errors['email'] = '';
        }

        if (is_empty('role', $params)) {
            $errors['role'] = 'Role is required';
        } elseif (!isset($errors['role'])) {
            $errors['role'] = '';
        }

        if (!is_validate($errors)) {
            return new WP_REST_Response($errors, 404);
        }

        $data['name'] = $params['name'];
        $data['email'] = $params['email'];
        $data['role'] = $params['role'];
        $data['status'] = $params['status'];
        $result = $this->user->update($data, $params['id']);
        return new WP_REST_Response($result);
    }


    public function destroy(WP_REST_Request $request)
    {
        $params = $request->get_params();
        if (is_array($params['id'])) {
            return $this->user->destroy_many($params['id']);
        }

        return $this->user->destroy($params['id']);
    }


    public function get_users_permission_check()
    {
        return true;
    }
}
