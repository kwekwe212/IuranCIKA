<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		logged_check();
		$this->load->model('DataPerson');
	}

	public function index()
	{
		$this->load->view('dashboard_v');
	}



	public function ambilData()
	{
		$data = $this->DataPerson->getData();

		$arr = [];
		foreach ($data as $row) {
			$sub = [];
			$sub['name'] = $row['name'];
			$sub['address'] = $row['address'];
			$sub['telp'] = $row['telp'];
			$sub['keterangan'] = $row['keterangan'];
			$sub['action'] =
				"<div class='text-center'>
					<button class='btn btn-warning m-1 ubah' data-id='" . $row['id'] . "'>Ubah</button>
					<button class='btn btn-danger m-1 hapus' data-id='" . $row['id'] . "'>Hapus</button>
				</div>";
			$arr[] = $sub;
		}

		echo json_encode($arr);
	}

	public function ambilDataId()
	{
		if ($_POST) {
			$post = $this->input->post();
			$data = $this->DataPerson->getDataById(anti_injection($post['id']));

			echo json_encode($data);
		}
	}

	public function tambahData()
	{
		if ($_POST) {
			$post = $this->input->post();

			$arr = [
				"id" => uniqid(),
				"name" => anti_injection($post['nama']),
				"address" => anti_injection($post['alamat']),
				"telp" => anti_injection($post['notelp']),
				"keterangan" => anti_injection($post['keterangan']),
			];

			$this->DataPerson->addData($arr);

			$result = ['pesan' => "Data berhasil ditambahkan"];
			echo json_encode($result);
		}
	}

	public function ubahData()
	{
		if ($_POST) {
			$post = $this->input->post();

			$id = anti_injection($post['id']);
			$arr = [
				"name" => anti_injection($post['nama']),
				"address" => anti_injection($post['alamat']),
				"telp" => anti_injection($post['notelp']),
				"keterangan" => anti_injection($post['keterangan']),
			];

			$this->DataPerson->editData($arr, $id);

			$result = ['pesan' => "Data berhasil diubah"];
			echo json_encode($result);
		}
	}

	public function hapusData()
	{
		if ($_POST) {
			$post = $this->input->post();
			$this->DataPerson->deleteData(anti_injection($post['id']));
		}
	}
}
