<?php

if (!function_exists('is_empty')) {
    function is_empty($field, $body)
    {
        if (!isset($body[$field]) || $body[$field] == '') {
            return true;
        }
        return false;
    }
}


if (!function_exists('is_unique')) {
    function is_unique($field, $body)
    {
        global $wpdb;
        if ($body[$field] != '') {
            $table = SMART_TABLE;
            $data = $body[$field];
            $result = $wpdb->get_results("SELECT * FROM $table WHERE $field='$data'");
            if ($result) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('is_validate')) {
    function is_validate($errors)
    {
        foreach ($errors as $value) {
            if ($value != "") {
                return false;
            }
        }
        return true;
    }
}
