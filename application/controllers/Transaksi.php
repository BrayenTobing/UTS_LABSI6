<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
		$this->data['CI'] =& get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		$this->load->library(array('cart'));
		if($this->session->userdata('masuk_sistem_rekam') != TRUE){
			$url=base_url('login');
			redirect($url);
		}
	 }
	 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{	
		$this->data['title_web'] = 'Data Sewa Alat ';
		$this->data['idbo'] = $this->session->userdata('ses_id');
		
		if($this->session->userdata('level') == 'Anggota'){
			$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, `anggota_id`, 
				`status`, `tgl_sewa`, `lama_sewa`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE status = 'Disewa' 
				AND anggota_id = ? ORDER BY sewa_id DESC", 
				array($this->session->userdata('anggota_id')));
		}else{
			$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, `anggota_id`, 
				`status`, `tgl_sewa`, `lama_sewa`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE status = 'Disewa' ORDER BY sewa_id DESC");
		}
		
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('sewa/sewa_view',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function kembali()
	{	
		$this->data['title_web'] = 'Data Pengembalian Alat ';
		$this->data['idbo'] = $this->session->userdata('ses_id');

		if($this->session->userdata('level') == 'Anggota'){
			$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, `anggota_id`, 
				`status`, `tgl_sewa`, `lama_sewa`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE anggota_id = ? AND status = 'Di Kembalikan' 
				ORDER BY id_sewa DESC",array($this->session->userdata('anggota_id')));
		}else{
			$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, `anggota_id`, 
				`status`, `tgl_sewa`, `lama_sewa`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE status = 'Di Kembalikan' ORDER BY id_sewa DESC");
		}
		
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('kembali/home',$this->data);
		$this->load->view('footer_view',$this->data);
	}


	public function sewa()
	{	

		$this->data['nop'] = $this->M_Admin->buat_kode('tbl_sewa','CS','id_sewa','ORDER BY id_sewa DESC LIMIT 1'); 
		$this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['user'] = $this->M_Admin->get_table('tbl_login');
		$this->data['alat'] =  $this->db->query("SELECT * FROM tbl_alat ORDER BY id_alat DESC");

		$this->data['title_web'] = 'Tambah Sewa Alat ';

		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('sewa/tambah_view',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function detailsewa()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');		
		$id = $this->uri->segment('3');
		if($this->session->userdata('level') == 'Anggota'){
			$count = $this->db->get_where('tbl_sewa',[
				'sewa_id' => $id, 
				'anggota_id' => $this->session->userdata('anggota_id')
			])->num_rows();
			if($count > 0)
			{
				$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, 
				`anggota_id`, `status`, 
				`tgl_sewa`, `lama_sewa`, 
				`tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE sewa_id = ? 
				AND anggota_id =?", 
				array($id,$this->session->userdata('anggota_id')))->row();
			}else{
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
			}
		}else{
			$count = $this->M_Admin->CountTableId('tbl_sewa','sewa_id',$id);
			if($count > 0)
			{
				$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, 
				`anggota_id`, `status`, 
				`tgl_sewa`, `lama_sewa`, 
				`tgl_balik`, `tgl_kembali` 
				FROM tbl_sewa WHERE sewa_id = '$id'")->row();
			}else{
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
			}
		}
		$this->data['sidebar'] = 'kembali';
		$this->data['title_web'] = 'Detail sewa alat ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('sewa/detail',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function kembalisewa()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');		
		$id = $this->uri->segment('3');
		$count = $this->M_Admin->CountTableId('tbl_sewa','sewa_id',$id);
		if($count > 0)
		{
			$this->data['sewa'] = $this->db->query("SELECT DISTINCT `sewa_id`, 
			`anggota_id`, `status`, 
			`tgl_sewa`, `lama_sewa`, 
			`tgl_balik`, `tgl_kembali` 
			FROM tbl_sewa WHERE sewa_id = '$id'")->row();
		}else{
			echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
		}


		$this->data['title_web'] = 'Kembali sewa alat ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('sewa/kembali',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function prosessewa()
	{
		$post = $this->input->post();

		if(!empty($post['tambah']))
		{

			$tgl = $post['tgl'];
			$tgl2 = date('Y-m-d', strtotime('+'.$post['lama'].' days', strtotime($tgl)));

			$hasil_cart = array_values(unserialize($this->session->userdata('cart')));
			foreach($hasil_cart as $isi)
			{
				$data[] = array(
					'sewa_id'=>htmlentities($post['nosewa']), 
					'anggota_id'=>htmlentities($post['anggota_id']), 
					'alat_id' => $isi['id'], 
					'status' => 'Disewa', 
					'tgl_sewa' => htmlentities($post['tgl']), 
					'lama_sewa' => htmlentities($post['lama']), 
					'tgl_balik'  => $tgl2, 
					'tgl_kembali'  => '0',
				);
			}
			$total_array = count($data);
			if($total_array != 0)
			{
				$this->db->insert_batch('tbl_sewa',$data);

				$cart = array_values(unserialize($this->session->userdata('cart')));
				for ($i = 0; $i < count($cart); $i ++){
				  unset($cart[$i]);
				  // $this->session->unset_userdata($cart[$i]);
				  // $this->session->unset_userdata('cart');
				}
			}

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah sewa alat Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi')); 
		}

		if($this->input->get('sewa_id'))
		{
			$this->M_Admin->delete_table('tbl_sewa','sewa_id',$this->input->get('sewa_id'));
			$this->M_Admin->delete_table('tbl_denda','sewa_id',$this->input->get('sewa_id'));

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p>  Hapus Transaksi sewa alat Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi')); 
		}

		if($this->input->get('kembali'))
		{
			$id = $this->input->get('kembali');
			$sewa = $this->db->query("SELECT  * FROM tbl_sewa WHERE sewa_id = '$id'");

			foreach($sewa->result_array() as $isi){
				$sewa_id = $isi['sewa_id'];
				$denda = $this->db->query("SELECT * FROM tbl_denda WHERE sewa_id = '$sewa_id'");
				$jml = $this->db->query("SELECT * FROM tbl_sewa WHERE sewa_id = '$sewa_id'")->num_rows();			
				if($denda->num_rows() > 0){
					$s = $denda->row();
					echo $s->denda;
				}else{
					$date1 = date('Ymd');
					$date2 = preg_replace('/[^0-9]/','',$isi['tgl_balik']);
					$diff = $date2 - $date1;
					if($diff >= 0 )
					{
						$harga_denda = 0;
						$lama_waktu = 0;
					}else{
						$dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda','stat','Aktif'); 
						$harga_denda = $jml*($dd->harga_denda*abs($diff));
						$lama_waktu = abs($diff);
					}
				}
				
			}

			$data = array(
				'status' => 'Di Kembalikan', 
				'tgl_kembali'  => date('Y-m-d'),
			);

			$total_array = count($data);
			if($total_array != 0)
			{	
				$this->db->where('sewa_id',$this->input->get('kembali'));
				$this->db->update('tbl_sewa',$data);
			}

			$data_denda = array(
				'sewa_id' => $this->input->get('kembali'), 
				'denda' => $harga_denda, 
				'lama_waktu'=>$lama_waktu, 
				'tgl_denda'=> date('Y-m-d'),
			);
			$this->db->insert('tbl_denda',$data_denda);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Pengembalian sewa alat Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi')); 

		}
	}

	public function denda()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');	

		$this->data['denda'] =  $this->db->query("SELECT * FROM tbl_biaya_denda ORDER BY id_biaya_denda DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_biaya_denda','id_biaya_denda',$id);
			if($count > 0)
			{			
				$this->data['den'] = $this->db->query("SELECT *FROM tbl_biaya_denda WHERE id_biaya_denda='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('transaksi/denda').'"</script>';
			}
		}

		$this->data['title_web'] = ' Denda ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('denda/denda_view',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function dendaproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= htmlentities($this->input->post());
			$data = array(
				'harga_denda'=>htmlentities($post['harga']),
				'stat'=>'Tidak Aktif',
				'tgl_tetap' => date('Y-m-d')
			);

			$this->db->insert('tbl_biaya_denda', $data);
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah  Harga Denda  Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 
		}

		if(!empty($this->input->post('edit')))
		{
			$dd = $this->M_Admin->get_tableid('tbl_biaya_denda','stat','Aktif');
			foreach($dd as $isi)
			{
				$data1 = array(
					'stat'=>'Tidak Aktif',
				);
				$this->db->where('id_biaya_denda',$isi['id_biaya_denda']);
				$this->db->update('tbl_biaya_denda', $data1);
			}

			$post= $this->input->post();
			$data = array(
				'harga_denda'=>htmlentities($post['harga']),
				'stat'=>$post['status'],
				'tgl_tetap' => date('Y-m-d')
			);

			$this->db->where('id_biaya_denda',$post['edit']);
			$this->db->update('tbl_biaya_denda', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Harga Denda  Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 	
		}

		if(!empty($this->input->get('denda_id')))
		{
			$this->db->where('id_biaya_denda',$this->input->get('denda_id'));
			$this->db->delete('tbl_biaya_denda');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Harga Denda Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 
		}
	}


	public function result()
    {	
		
		$user = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$this->input->post('kode_anggota'));
		error_reporting(0);
		if($user->nama != null)
		{
			echo '<table class="table table-striped">
						<tr>
							<td>Nama Anggota</td>
							<td>:</td>
							<td>'.$user->nama.'</td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td>:</td>
							<td>'.$user->telepon.'</td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>:</td>
							<td>'.$user->email.'</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td>'.$user->alamat.'</td>
						</tr>
						<tr>
							<td>Level</td>
							<td>:</td>
							<td>'.$user->level.'</td>
						</tr>
					</table>';
		}else{
			echo 'Anggota Tidak Ditemukan !';
		}
        
	}

	public function alat()
    {	
		$id = $this->input->post('kode_alat');
		$row = $this->db->query("SELECT * FROM tbl_alat WHERE alat_id ='$id'");
		
		if($row->num_rows() > 0)
		{
			$tes = $row->row();
			$item = array(
				'id'      => $id,
				'qty'     => 1,
                'price'   => '1000',
				'name'    => $tes->nama_alat,
			);
			if(!$this->session->has_userdata('cart')) {
				$cart = array($item);
				$this->session->set_userdata('cart', serialize($cart));
			} else {
				$index = $this->exists($id);
				$cart = array_values(unserialize($this->session->userdata('cart')));
				if($index == -1) {
					array_push($cart, $item);
					$this->session->set_userdata('cart', serialize($cart));
				} else {
					$cart[$index]['quantity']++;
					$this->session->set_userdata('cart', serialize($cart));
				}
			}
		}else{

		}
        
	}

	public function alat_list()
	{
	?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Alat</th>
					<th>Brand</th>
					<th>Tahun</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php $no=1;
				foreach(array_values(unserialize($this->session->userdata('cart'))) as $items){?>
				<tr>
					<td><?= $no;?></td>
					<td><?= $items['name'];?></td>
					<td><?= $items['options']['brand'];?></td>
					<td><?= $items['options']['thn_alat'];?></td>
					<td style="width:17%">
					<a href="javascript:void(0)" id="delete_alat<?=$no;?>" data_<?=$no;?>="<?= $items['id'];?>" class="btn btn-danger btn-sm">
						<i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<script>
					$(document).ready(function(){
						$("#delete_alat<?=$no;?>").click(function (e) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url('transaksi/del_cart');?>",
								data:'kode_alat='+$(this).attr("data_<?=$no;?>"),
								beforeSend: function(){
								},
								success: function(html){
									$("#tampil").html(html);
								}
							});
						});
					});
				</script>
			<?php $no++;}?>
			</tbody>
		</table>
		<?php foreach(array_values(unserialize($this->session->userdata('cart'))) as $items){?>
			<input type="hidden" value="<?= $items['id'];?>" name="idalat[]">
		<?php }?>
		<div id="tampil"></div>
	<?php
	}

	public function del_cart()
    {
		error_reporting(0);
        $id = $this->input->post('alat_id');
        $index = $this->exists($id);
        $cart = array_values(unserialize($this->session->userdata('cart')));
        unset($cart[$index]);
        $this->session->set_userdata('cart', serialize($cart));
       // redirect('jual/tambah');
		echo '<script>$("#result_alat").load("'.base_url('transaksi/alat_list').'");</script>';
    }

    private function exists($id)
    {
        $cart = array_values(unserialize($this->session->userdata('cart')));
        for ($i = 0; $i < count($cart); $i ++) {
            if ($cart[$i]['alat_id'] == $id) {
                return $i;
            }
        }
        return -1;
    }

}
