<?php defined('BASEPATH') OR exit('No direct script access allowed');

function cek_login($sessname = '', $url_redirect = '/login/', $redirect = TRUE)
{   
    $CI =& get_instance();

    $CI->session->set_userdata('last_page',current_url());

    if($sessname == '')
    {
        $sessname = $CI->config->item('sessname_store_login');
    }

    if(!$redirect)
    {
        if($CI->session->userdata($sessname) && !empty($CI->session->userdata($sessname)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        if(!$CI->session->userdata($sessname))
        {
            redirect($url_redirect, 'location', 301);
            exit();
        }
    }        
}

function include_login( $login_status = FALSE )
{
    $CI =& get_instance();
    $include_login = ($login_status)? '' : $CI->load->view('main/include/login',NULL, TRUE);
    return $include_login;
}


function query_kategori_produk()
{
    $sql = "SELECT * FROM kategori_produk ORDER BY kategori";
    return $sql;
}

function query_produk_index()
{
    $sql = "SELECT produk.kode_prod, nama, harga, berat, panjang, lebar, stok ";
    $sql .= ", caption, description, filename, file_ext, folder ";
    $sql .= "FROM produk ";
    $sql .= "LEFT JOIN foto_produk ON foto_produk.kode_prod = produk.kode_prod AND foto_produk.main_pic = 1 ";
    $sql .= "ORDER BY tgl_input DESC ";
    $sql .= "LIMIT 12";
    return $sql;
}

function get_query($par = NULL)
{
    $CI =& get_instance();
    if($par == 'kategori_produk')
    {
        $rs_kategori = $CI->model_auth->freequery(query_kategori_produk());
        return $rs_kategori;
    }
    else if($par == 'produk_index')
    {
        $rs_produk = $CI->model_auth->freequery(query_produk_index());
        return $rs_produk;
    }
}
