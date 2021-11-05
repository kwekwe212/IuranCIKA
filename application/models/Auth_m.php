<?php

class Auth_m extends CI_Model
{
    public function register($data)
    {
        $this->db->insert('user', $data);
    }
}
