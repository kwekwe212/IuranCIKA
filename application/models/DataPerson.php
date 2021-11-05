<?php

class DataPerson extends CI_Model
{
    public function getData()
    {
        $data = $this->db->get('person');
        return $data->result_array();
    }

    public function getDataById($id)
    {
        $data = $this->db->get_where('person', array('id' => $id));
        return $data->row_array();
    }

    public function addData($data)
    {
        $this->db->insert('person', $data);
    }

    public function editData($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update('person', $data);
    }

    public function deleteData($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('person');
    }
}
