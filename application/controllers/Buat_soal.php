<?php

Class Buat_soal extends OperatorController {

    function __construct() {
        parent::__construct();
        // if (empty($this->session->userdata('username'))) {
        //     redirect('auth');
        // }
        //chekAksesModule();
        $this->load->library('ssp');
        $this->menu = "akademik";
        $this->sub_menu = "buat-soal";
        // $this->load->model('Model_gelombang');
    }

    
    function data() {
        // nama tabel
        $table = 'tb_kelas';
        // nama PK
        $primaryKey = 'id_kelas';
        // list field
        $columns = array(
            array('db' => 'id_kelas', 'dt' => 'id_kelas'),
            array('db' => 'nama_kelas', 'dt' => 'nama_kelas'),
            array('db' => 'status_kelas', 'dt' => 'status_kelas'),
            array(
                'db' => 'id_kelas',
                'dt' => 'aksi',
                'formatter' => function( $d) {
                    //return "<a href='edit.php?id=$d'>EDIT</a>";
                    return anchor('kelas/edit/'.$d,'<i class="fa fa-edit"></i>','class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"').' 
                        '.anchor('kelas/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete" onclick="return confirm(\'Are you sure delete?\')"');
                }
            )
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    function index() {
        $data['heading']    = $this->template->link('Akademik - Buat Soal ');
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;
        $this->template->load('template', 'buat_soal/list' ,$data);
    }

    
    function add() {
        
        if (!$_POST) {
            $data['input'] = (object) $this->Model_buat_soal->getDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->Model_buat_soal->validate()) {
            // $halaman     = $this->halaman;
            $data['mainView']   = 'buat_soal/add';
            $data['heading']    = $this->template->link('buat_soal > Tambah');
            $data['formAction'] = "buat_soal/add";
            $data['buttonText'] = 'Tambah';
            $data['menu']       = $this->menu;
            $data['sub_menu']   = $this->sub_menu;
            $this->template->load('template', $data['mainView'],$data);
            // $this->load->view('template', compact('halaman', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->Model_buat_soal->insert($data['input'])) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect($this->sub_menu);
    }

    
    public function edit($id = null)
    {
        $buat_soal = $this->Model_buat_soal->find('id_soal',$id);
        if (!$buat_soal) {
            flashMessage('error', 'Data tidak ditemukan!');
            redirect('buat_soal', 'refresh');
        }

        $data['input'] = (object) $this->input->post(null, true);
        if (! $_POST) {
            $data['input'] = (object) $buat_soal;
        }

        $validate = $this->Model_buat_soal->validate();
        if (! $validate) {
            $data['mainView']   = 'buat_soal/add';
            $data['heading']    = $this->template->link('buat_soal > Edit ');
            $data['formAction'] = "buat_soal/edit/$id";
            $data['buttonText'] = 'Update';
            $data['menu'] = $this->menu;
            $data['sub_menu'] = $this->sub_menu;
            $this->template->load('template', $data['mainView'] ,$data);
            return;
        }

        $update = $this->Model_buat_soal->update($id, $data['input'],'id_soal');
        if (! $update) {
            flashMessage('error', 'Data gagal diupdate!');
        } else {
            flashMessage('success', 'Data berhasil diupdate.');
        }

        redirect($this->sub_menu, 'refresh');
    }

    public function delete($id)
    {
        $buat_soal = $this->Model_buat_soal->find('id_soal',$id);
        if (!$buat_soal) {
            flashMessage('error', 'Data tidak ditemukan!');
            redirect('buat_soal', 'refresh');
        }

        $hapus = $this->Model_buat_soal->where('id_buat_soal',$id)->delete();

        if (!$hapus) {
            flashMessage('error', 'Data gagal dihapus!');
        } else {
            flashMessage('success', 'Data berhasil dihapus.');
        }
        
        redirect($this->sub_menu, 'refresh');
    }

}