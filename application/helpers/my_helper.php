<?php

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function logged_check()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('login');
    }
}

function anti_injection($string)
{
    $data = stripslashes(strip_tags(htmlentities(htmlspecialchars($string, ENT_QUOTES))));
    $data = str_replace("union", "", $data);
    $data = str_replace("+", "", $data);
    $data = str_replace("database", "", $data);
    $data = str_replace("information_schema", "", $data);
    $data = str_replace("tabel_name", "", $data);
    $data = str_replace("columns", "", $data);
    return str_replace("'", "", $data);
}
