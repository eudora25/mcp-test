<?php
class Admin_model extends CI_Model {

    public function get_admin_by_id($admin_id) {		
        $this->db->where('admin_id', $admin_id);
        $this->db->where('state', 1);
        return $this->db->get('tb_admin')->row_array();
    }
}