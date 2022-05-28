<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php
	$idkat = $alat->id_kategori;
	$idrak = $alat->id_rak;

	$kat = $this->M_Admin->get_tableid_edit('tbl_kategori','id_kategori',$idkat);
	$rak = $this->M_Admin->get_tableid_edit('tbl_rak','id_rak',$idrak);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-book" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-book"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<h4><?= $alat->nama_alat;?></h4>
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
					<table class="table table-striped table-bordered">
						<tr>
							<td>Sampul Alat</td>
							<td><?php if(!empty($alat->sampul !== "0")){?>
									<a href="<?= base_url('assets_style/image/alat/'.$alat->sampul);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/alat/'.$alat->sampul);?>" style="width:170px;height:170px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada Sampul</p>';}?>
								</td>
						</tr>
						<tr>
							<td>Nama Alat</td>
							<td><?= $alat->nama_alat;?></td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td><?= $kat->nama_kategori;?></td>
						</tr>
						<tr>
							<td>Brand</td>
							<td><?= $alat->brand;?></td>
						</tr>
						<tr>
							<td>Tahun Terbit</td>
							<td><?= $alat->thn_alat;?></td>
						</tr>
						<tr>
							<td>Jumlah Alat</td>
							<td><?= $alat->jmlh;?></td>
						</tr>
						<tr>
							<td>Jumlah Sewa</td>
							<td>
								<?php
									$id = $alat->alat_id;
									$dd = $this->db->query("SELECT * FROM tbl_sewa WHERE alat_id= '$id' AND status = 'Disewa'");
									if($dd->num_rows() > 0 )
									{
										echo $dd->num_rows();
									}else{
										echo '0';
									}
								?> 
								<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary btn-xs" style="margin-left:1pc;">
									<i class="fa fa-sign-in"></i> Detail Sewa</a>
							</td>
						</tr>
						<tr>
							<td>Keterangan Lainnya</td>
							<td><?= $alat->isi;?></td>
						</tr>
						<tr>
							<td>Rak / Lokasi</td>
							<td><?= $rak->nama_rak;?></td>
						</tr>
						<tr>
							<td>Lampiran</td>
							<td><?php if(!empty($alat->lampiran !== "0")){?>
									<a href="<?= base_url('assets_style/image/alat/'.$alat->lampiran);?>" class="btn btn-primary btn-md" target="_blank">
										<i class="fa fa-download"></i> Sample Alat
									</a>
								<?php  }else{ echo '<br/><p style="color:red">* Tidak ada Lampiran</p>';}?>
                               </td>
						</tr>
						<tr>
							<td>Tanggal Masuk</td>
							<td><?= $alat->tgl_masuk;?></td>
						</tr>
					</table>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

 <!--modal import -->
<div class="modal fade" id="TableAnggota">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"> Anggota Yang Sedang Sewa</h4>
</div>
<div id="modal_body" class="modal-body fileSelection1">
<table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>ID</th>
			<th>Nama</th>
			<th>Jenkel</th>
			<th>Telepon</th>
			<th>Tgl Sewa</th>
			<th>Lama Sewa</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 1;
	$alatid = $alat->alat_id;
	$pin = $this->db->query("SELECT * FROM tbl_sewa WHERE alat_id ='$alatid' AND status = 'Disewa'")->result_array();
	foreach($pin as $si)
	{
		$isi = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$si['anggota_id']);
		if($isi->level == 'Anggota'){
		?>
		<tr>
			<td><?= $no;?></td>
			<td><?= $isi->anggota_id;?></td>
			<td><?= $isi->nama;?></td>
			<td><?= $isi->jenkel;?></td>
			<td><?= $isi->telpon;?></td>
			<td><?= $si['tgl_sewa'];?></td>
			<td><?= $si['lama_sewa'];?> Hari</td>
		</tr>
	<?php $no++;}}?>
	</tbody>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
