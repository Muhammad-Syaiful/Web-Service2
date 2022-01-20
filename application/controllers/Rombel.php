<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Rombel extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get()
    {
        $id = $this->get('id');
        if ($id == '') {
            $rombel = $this->db->get('siswa')->result();
        } else {
            $this->db->where('id', $id);
            $rombel = $this->db->get('siswa')->result();
        }
        $result = [
            "took" => $_SERVER["REQUEST_TIME_FLOAT"],
            "code" => 200,
            "message" => "Respon berhasil",
            "data" => $rombel
        ];
        $this->response($rombel, 200);
    }

    function index_post()
    {
        $data = array(
            'id_siswa'           => $this->post('id_siswa'),
            'nama'          => $this->post('nama'),
            'nis'    => $this->post('nis'),
            'alamat'          => $this->post('alamat'),
        );
        $insert = $this->db->insert('siswa', $data);
        if ($insert) {
            $result = [
                "took" => $_SERVER["REQUEST_TIME_FLOAT"],
                "code" => 201,
                "message" => "Data berhasil ditambahkan",
                "data" => $data
            ];
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put()
    {
        $id = $this->put('id');
        $data = array(
            'id'       => $this->put('id'),
            'nama'          => $this->put('nama'),
            'nis'    => $this->put('nis'),
            'alamat'          => $this->put('alamat'),
        );

        $this->db->where('id', $id);
        $update = $this->db->update('siswa', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('siswa');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
