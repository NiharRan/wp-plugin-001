<?php

namespace Nihar\WpApi\Models;

class User
{
    public $table = '';


    public function __construct()
    {
        $this->table = SMART_TABLE;
    }


    public function get_all_users($params = [])
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->table";
        $condition = '';
        if (count($params) > 0) {
            $condition = 'WHERE  ';
        }
        if (isset($params['id'])) {
            $condition .= "id=" . $params['id'] . " AND ";
        }
        $condition = rtrim($condition, " AND ");
        $sql .= " $condition";
        $sql .= " ORDER BY id DESC";
        return $wpdb->get_results($sql);
    }


    public function store($data)
    {
        global $wpdb;
        $result = $wpdb->insert($this->table, $data);

        if ($result) {
            $last_id = $wpdb->insert_id;
            return $this->find($last_id);
        }
        return null;
    }

    public function update($data, $id)
    {
        global $wpdb;
        $result = $wpdb->update($this->table, $data, array("id" => $id));

        if ($result) {
            return $this->find($id);
        }
        return null;
    }

    public function find($id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE id=%d", $id));
    }
}
