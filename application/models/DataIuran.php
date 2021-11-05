<?php

class DataIuran extends CI_Model
{
    public function getData()
    {
        $data = $this->db->get('iuran');
        return $data->result_array();
    }

    public function getDataById($id)
    {
        $data = $this->db->get_where('iuran', array('id' => $id));
        return $data->row_array();
    }

    public function getDataColumn($data)
    {
        $cat = $data['cat'];
        $term = $data['term'];

        $this->db->select('*');
        $this->db->from('person');
        $this->db->like('LOWER(' . $cat . ')', $term);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addData($data)
    {
        $this->db->insert('iuran', $data);
    }

    public function deleteData($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('iuran');
    }

    public function totalIuran()
    {
        // $query = $this->db->query("SELECT SUM(iuran_total) as total FROM iuran");
        $this->db->select_sum('iuran_total');
        $query = $this->db->get('iuran');

        return $query->row();
    }

    public function filterDate($data)
    {
        $result = $this->db->get_where('iuran', array('date' => $data));
        return $result->result_array();
    }

    public function filterSomeday($data)
    {
        $this->db->where('date >=', $data['tanggal']);
        $this->db->where('date <=', $data['tanggalEnd']);
        $result = $this->db->get('iuran');
        return $result->result_array();
    }
}
