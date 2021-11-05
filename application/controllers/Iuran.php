<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Iuran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        logged_check();
        $this->load->model('DataIuran');
    }

    // VIEW
    public function index()
    {
        $this->load->view('iuran_v');
    }

    public function data()
    {
        $this->load->view('iuran_data_v');
    }



    // AJAX PROSES
    public function ambilData()
    {
        $data = $this->DataIuran->getData();

        $arr = [];
        foreach ($data as $row) {
            $sub = [];
            $sub['nama'] = $row['name'];
            $sub['iuranWajib'] = rupiah($row['iuran_wajib']);
            $sub['iuranSampingan'] = rupiah($row['iuran_sampingan']);
            $sub['totalIuran'] = rupiah($row['iuran_total']);
            $sub['tanggal'] = date("d-m-Y", strtotime($row['date']));
            $sub['action'] =
                "<div class='text-center'>
					<button class='btn btn-danger m-1 hapus' data-id='" . $row['id'] . "'>Hapus</button>
				</div>";
            $arr[] = $sub;
        }

        echo json_encode($arr);
    }

    public function ambilDataKolom()
    {
        if ($_POST) {
            $post = $this->input->post();

            $arr = [
                'term' => anti_injection(strtolower($post['term']['term'])),
                'cat' => anti_injection($post['cat'])
            ];

            $data = $this->DataIuran->getDataColumn($arr);
            echo json_encode($data);
        }
    }

    public function totalIuran()
    {
        $data = rupiah($this->DataIuran->totalIuran()->iuran_total);
        // echo '<pre>';
        // print_r($this->DataIuran->totalIuran());
        echo json_encode($data);
    }

    public function tambahIuran()
    {
        if ($_POST) {
            $post = $this->input->post();

            $data = [
                'id' => uniqid(),
                'name' => anti_injection($post['nama']),
                'iuran_wajib' => anti_injection($post['nominal_wajib']),
                'iuran_sampingan' => anti_injection($post['nominal_sampingan']),
                'iuran_total' => anti_injection($post['nominal_wajib'] + $post['nominal_sampingan']),
                'date' => anti_injection(date('Y-m-d', strtotime($post['tanggal'])))
            ];

            $this->DataIuran->addData($data);
        }
    }

    public function filterTanggal()
    {
        if ($_POST) {
            $post = $this->input->post();

            if (!$_POST['tanggalEnd']) {
                // Filter 1 hari
                $data = anti_injection(date('Y-m-d', strtotime($post['tanggal'])));
                $result = $this->DataIuran->filterDate($data);
            } else {
                // Filter lebih 1 hari
                $arr = [
                    'tanggal' => anti_injection(date('Y-m-d', strtotime($post['tanggal']))),
                    'tanggalEnd' => anti_injection(date('Y-m-d', strtotime($post['tanggalEnd']))),
                ];
                $result = $this->DataIuran->filterSomeday($arr);
            }

            $array = [];
            foreach ($result as $row) {
                $sub = [];
                $sub['nama'] = $row['name'];
                $sub['iuranWajib'] = rupiah($row['iuran_wajib']);
                $sub['iuranSampingan'] = rupiah($row['iuran_sampingan']);
                $sub['totalIuran'] = rupiah($row['iuran_total']);
                $sub['tanggal'] = date("d-m-Y", strtotime($row['date']));
                $sub['action'] =
                    "<div class='text-center'>
                        <button class='btn btn-danger m-1 hapus' data-id='" . $row['id'] . "'>Hapus</button>
                    </div>";
                $array[] = $sub;
            }

            echo json_encode($array);
        }
    }

    public function hapusData()
    {
        if ($_POST) {
            $post = $this->input->post();
            $this->DataIuran->deleteData(anti_injection($post['id']));
        }
    }



    // EXPORT PDF
    public function printPdf($tanggal = 0, $tanggalEnd = 0)
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

        // Get Data
        if ($tanggal == 0 && $tanggalEnd == 0) {
            $result['data'] = $this->DataIuran->getData();
        } else {
            if ($tanggal !== 0 && $tanggalEnd == 0) {
                // Get Data by Filter 1 hari
                $data = date('Y-m-d', strtotime(str_replace('-', '/', $tanggal)));

                $result['data'] = $this->DataIuran->filterDate($data);
            } else if ($tanggal !== 0 && $tanggalEnd !== 0) {
                // Get Data by Filter lebih 1 hari
                $arr = [
                    'tanggal' => date('Y-m-d', strtotime(str_replace('-', '/', $tanggal))),
                    'tanggalEnd' => date('Y-m-d', strtotime(str_replace('-', '/', $tanggalEnd)))
                ];

                $result['data'] = $this->DataIuran->filterSomeday($arr);
            }
        }

        $totalsum = [];
        foreach ($result['data'] as $a) {
            $totalsum[] = $a['iuran_total'];
        }

        $result['total'] = array_sum($totalsum);

        $data = $this->load->view('iuran_pdf_v', $result, true);

        $mpdf->SetTitle("Laporan Iuran");
        $mpdf->WriteHTML($data);
        $mpdf->Output("Coba.pdf", "I");

        redirect('iuran/data');
    }

    // EXPORT EXCEL
    public function printExcel()
    {
        $data = $this->DataIuran->getData();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Iuran Wajib')
            ->setCellValue('D1', 'Iuran Sampingan')
            ->setCellValue('E1', 'Total Iuran')
            ->setCellValue('F1', 'Tanggal');

        $kolom = 2;
        $no = 1;
        foreach ($data as $a) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $no)
                ->setCellValue('B' . $kolom, $a['name'])
                ->setCellValue('C' . $kolom, $a['iuran_wajib'])
                ->setCellValue('D' . $kolom, $a['iuran_sampingan'])
                ->setCellValue('E' . $kolom, $a['iuran_total'])
                ->setCellValue('F' . $kolom, $a['date']);

            $kolom++;
            $no++;
        }

        $styleAlignMiddleCentered = [
            'bold',
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleBorderCell = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $lengthData = count($data) + 1;

        $spreadsheet->getActiveSheet()->getStyle('1')->applyFromArray($styleAlignMiddleCentered);
        $spreadsheet->getActiveSheet()->getStyle('A')->applyFromArray($styleAlignMiddleCentered);
        $spreadsheet->getActiveSheet()->getStyle('C:F')->applyFromArray($styleAlignMiddleCentered);
        $spreadsheet->getActiveSheet()->getStyle("A1:F$lengthData")->applyFromArray($styleBorderCell);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('1')->getFont()->setBold(true);

        foreach (range('B', 'F') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Iuran.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
