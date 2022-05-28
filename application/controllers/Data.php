<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
     $this->data['CI'] =& get_instance();
     $this->load->helper(array('form', 'url'));
     $this->load->model('M_Admin');
		if($this->session->userdata('masuk_sistem_rekam') != TRUE){
				$url=base_url('login');
				redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['alat'] =  $this->db->query("SELECT * FROM tbl_alat ORDER BY id_alat DESC");
        $this->data['title_web'] = 'Data Alat';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('alat/alat_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function alatdetail()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_alat','id_alat',$this->uri->segment('3'));
		if($count > 0)
		{
			$this->data['alat'] = $this->M_Admin->get_tableid_edit('tbl_alat','id_alat',$this->uri->segment('3'));
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['rakalat'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC")->result_array();

		}else{
			echo '<script>alert("alat TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data alat Detail';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('alat/detail',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function alatedit()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_alat','id_alat',$this->uri->segment('3'));
		if($count > 0)
		{
			
			$this->data['alat'] = $this->M_Admin->get_tableid_edit('tbl_alat','id_alat',$this->uri->segment('3'));
	   
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['rakalat'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC")->result_array();

		}else{
			echo '<script>alert("alat TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data alat Edit';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('alat/edit_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function alattambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
		$this->data['rakalat'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC")->result_array();


        $this->data['title_web'] = 'Tambah alat';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('alat/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}


	public function prosesalat()
	{
		if(!empty($this->input->get('alat_id')))
		{
        
			$alat = $this->M_Admin->get_tableid_edit('tbl_alat','id_alat',htmlentities($this->input->get('alat_id')));
			
			$sampul = './assets_style/image/alat/'.$alat->sampul;
			if(file_exists($sampul))
			{
				unlink($sampul);
			}
			
			$lampiran = './assets_style/image/alat/'.$alat->lampiran;
			if(file_exists($lampiran))
			{
				unlink($lampiran);
			}
			
			$this->M_Admin->delete_table('tbl_alat','id_alat',$this->input->get('alat_id'));
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Berhasil Hapus alat !</p>
			</div></div>');
			redirect(base_url('data'));  
		}
		if(!empty($this->input->post('tambah')))
		{

			$post= $this->input->post();
			// setting konfigurasi upload
			$config['upload_path'] = './assets_style/image/alat/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc'; 
			$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
			// load library upload
			$this->load->library('upload',$config);
			$alat_id = $this->M_Admin->buat_kode('tbl_alat','BK','id_alat','ORDER BY id_alat DESC LIMIT 1'); 

			// upload gambar 1
			if(!empty($_FILES['gambar']['name'] && $_FILES['lampiran']['name']))
			{

				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}
				$data = array(
					'alat_id'=>$alat_id,
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => $file1['upload_data']['file_name'],
                    'lampiran' => $file2['upload_data']['file_name'],
					'nama_alat'  => htmlentities($post['nama_alat']), 
					'brand'=> htmlentities($post['brand']), 
					'thn_alat' => htmlentities($post['thn_alat']), 
					'isi' => $this->input->post('ket'), 
					'jmlhh'=> htmlentities($post['jmlhh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

				

			}elseif(!empty($_FILES['gambar']['name'])){
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}
				$data = array(
					'alat_id'=>$alat_id,
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => $file1['upload_data']['file_name'],
                    'lampiran' => '0',
					'nama_alat'  => htmlentities($post['nama_alat']), 
					'brand'=> htmlentities($post['brand']), 
					'thn_alat' => htmlentities($post['thn_alat']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

			}elseif(!empty($_FILES['lampiran']['name'])){

				$this->upload->initialize($config);

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				$this->upload->do_upload('lampiran');
				$file2 = array('upload_data' => $this->upload->data());
				$data = array(
					'alat_id'=>$alat_id,
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => '0',
                    'lampiran' => $file2['upload_data']['file_name'],
					'nama_alat'  => htmlentities($post['nama_alat']), 
					'brand'=> htmlentities($post['brand']), 
					'thn_alat' => htmlentities($post['thn_alat']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

				
			}else{
				$data = array(
					'alat_id'=>$alat_id,
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => '0',
                    'lampiran' => '0',
					'nama_alat'  => htmlentities($post['nama_alat']), 
					'brand'=> htmlentities($post['brand']),    
					'thn_alat' => htmlentities($post['thn']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			}

			$this->db->insert('tbl_alat', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah alat Sukses !</p>
			</div></div>');
			redirect(base_url('data')); 
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			// setting konfigurasi upload
			$config['upload_path'] = './assets_style/image/alat/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
			$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
			// load library upload
        	$this->load->library('upload',$config);
			// upload gambar 1
			if(!empty($_FILES['gambar']['name'] && $_FILES['lampiran']['name']))
			{

				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				$gambar = './assets_style/image/alat/'.htmlentities($post['gmbr']);
				if(file_exists($gambar))
				{
					unlink($gambar);
				}

				$lampiran = './assets_style/image/alat/'.htmlentities($post['lamp']);
				if(file_exists($lampiran))
				{
					unlink($lampiran);
				}

				$data = array(
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => $file1['upload_data']['file_name'],
                    'lampiran' => $file2['upload_data']['file_name'],
					'nama_alat'  => htmlentities($post['nama_alat']),
					'brand'=> htmlentities($post['brand']),  
					'thn_alat' => htmlentities($post['thn']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

				

			}elseif(!empty($_FILES['gambar']['name'])){
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}


				$gambar = './assets_style/image/alat/'.htmlentities($post['gmbr']);
				if(file_exists($gambar))
				{
					unlink($gambar);
				}

				$data = array(
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'sampul' => $file1['upload_data']['file_name'],
					'nama_alat'  => htmlentities($post['nama_alat']),
					'brand'=> htmlentities($post['brand']),  
					'thn_alat' => htmlentities($post['thn']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

			}elseif(!empty($_FILES['lampiran']['name'])){

				$this->upload->initialize($config);

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				$lampiran = './assets_style/image/alat/'.htmlentities($post['lamp']);
				if(file_exists($lampiran))
				{
					unlink($lampiran);
				}

				// script uplaod file kedua
				$this->upload->do_upload('lampiran');
				$file2 = array('upload_data' => $this->upload->data());

				$data = array(
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
                    'lampiran' => $file2['upload_data']['file_name'],
					'nama_alat'  => htmlentities($post['nama_alat']),
					'brand'=> htmlentities($post['brand']),  
					'thn_alat' => htmlentities($post['thn']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);

				
			}else{
				$data = array(
					'id_kategori'=>htmlentities($post['kategori']), 
					'id_rak' => htmlentities($post['rak']), 
					'nama_alat'  => htmlentities($post['nama_alat']), 
					'brand'=> htmlentities($post['brand']),    
					'thn_alat' => htmlentities($post['thn']), 
					'isi' => $this->input->post('ket'), 
					'jmlh'=> htmlentities($post['jmlh']),  
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			}

			$this->db->where('id_alat',htmlentities($post['edit']));
			$this->db->update('tbl_alat', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit alat Sukses !</p>
			</div></div>');
			redirect(base_url('data')); 
		}
		
	}

	public function kategori()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['kategori'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_kategori','id_kategori',$id);
			if($count > 0)
			{			
				$this->data['kat'] = $this->db->query("SELECT *FROM tbl_kategori WHERE id_kategori='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/kategori').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Kategori ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('kategori/kat_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function katproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);

			$this->db->insert('tbl_kategori', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);
			$this->db->where('id_kategori',htmlentities($post['edit']));
			$this->db->update('tbl_kategori', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 		
		}

		if(!empty($this->input->get('kat_id')))
		{
			$this->db->where('id_kategori',$this->input->get('kat_id'));
			$this->db->delete('tbl_kategori');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 
		}
	}

	public function rak()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['rakalat'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_rak','id_rak',$id);
			if($count > 0)
			{	
				$this->data['rak'] = $this->db->query("SELECT *FROM tbl_rak WHERE id_rak='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/rak').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Rak alat ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('rak/rak_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function rakproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_rak'=>htmlentities($post['rak']),
			);

			$this->db->insert('tbl_rak', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Rak alat Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_rak'=>htmlentities($post['rak']),
			);
			$this->db->where('id_rak',htmlentities($post['edit']));
			$this->db->update('tbl_rak', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Rak Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak')); 		
		}

		if(!empty($this->input->get('rak_id')))
		{
			$this->db->where('id_rak',$this->input->get('rak_id'));
			$this->db->delete('tbl_rak');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Rak alat Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak')); 
		}
	}
}
