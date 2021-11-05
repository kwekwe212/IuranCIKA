<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_m', 'modelAuth');
        // $this->load->helper('cookie');
    }

    public function login()
    {
        $this->load->view('login_v');
    }

    public function register()
    {
        $this->load->view('register_v');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }



    public function doregister()
    {
        if ($_POST) {
            $post = $this->input->post();

            $name = anti_injection($post['nama']);
            $username = anti_injection($post['username']);
            $pw = anti_injection($post['password']);
            $pw2 = anti_injection($post['password2']);

            $user_check = $this->db->get_where('user', ['username' => $post['username']])->row_array();


            if (!isset($post['terms'])) {
                $result = [
                    'error' => 1,
                    'pesan' => "Anda belum centang terms",
                ];
            } else {
                if ($user_check) {
                    $result = [
                        'error' => 1,
                        'pesan' => "Username sudah terpakai",
                    ];
                } else {
                    if ($pw !== $pw2) {
                        $result = [
                            'error' => 1,
                            'pesan' => "Password harus sama",
                        ];
                    } else {
                        $arr = [
                            'id' => uniqid(),
                            'name' => $name,
                            'username' => $username,
                            'password' => password_hash($pw, PASSWORD_DEFAULT),
                        ];

                        $this->modelAuth->register($arr);

                        $result = [
                            'error' => 0,
                            'pesan' => "Register berhasil",
                            'lokasi' => "login"
                        ];
                    }
                }
            }

            echo json_encode($result);
        }
    }

    public function dologin()
    {
        if ($_POST) {
            $post = $this->input->post();
            $username = $post['username'];
            $password = $post['password'];
            $user_check = $this->db->get_where('user', ['username' => $username])->row_array();
            // echo '<pre>';
            // print_r($user_check);

            if ($user_check) {
                if (password_verify($password, $user_check['password'])) {
                    $session = array(
                        'id' => $user_check['id'],
                        'username' => $user_check['username'],
                    );

                    $this->session->set_userdata($session);
                    $result = [
                        'error' => 0,
                        'pesan' => "Login berhasil",
                        'lokasi' => "dashboard"
                    ];
                } else {
                    $result = [
                        'error' => 1,
                        'pesan' => "Password salah"
                    ];
                }
            } else {
                $result = [
                    'error' => 1,
                    'pesan' => "User tidak ada"
                ];
            }

            echo json_encode($result);
        }
    }
}
