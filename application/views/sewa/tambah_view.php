<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-plus" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form action="<?php echo base_url('transaksi/prosespinjam');?>" method="POST" enctype="multipart/form-data">
						
						<div class="row">
							<div class="col-sm-5">
								<table class="table table-striped">
									<tr style="background:yellowgreen">
										<td colspan="3">Data Transaksi</td>
									</tr>
									<tr>
										<td>No Sewa</td>
										<td>:</td>
										<td>
											<input type="text" name="nopinjam" value="<?= $nop;?>" readonly class="form-control">
										</td>
									</tr>
									<tr>
										<td>Tgl Sewa</td>
										<td>:</td>
										<td>
											<input type="date" value="<?= date('Y-m-d');?>" name="tgl" class="form-control">
										</td>
									</tr>
									<tr>
										<td>ID Anggota</td>
										<td>:</td>
										<td>
											<div class="input-group">
												<input type="text" class="form-control" required autocomplete="off" name="anggota_id" id="search-box" placeholder="Contoh ID Anggota : AG001" type="text" value="">
												<span class="input-group-btn">
													<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary"><i class="fa fa-search"></i></a>
												</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Biodata</td>
										<td>:</td>
										<td>
											<div id="result_tunggu"> <p style="color:red">* Belum Ada Hasil</p></div>
											<div id="result"></div>
										</td>
									</tr>
									<tr>
										<td>Lama sewa</td>
										<td>:</td>
										<td>
											<input type="number" required placeholder="Lama Pinjam Contoh : 2 Hari (2)" name="lama" class="form-control">
										</td>
									</tr>
								</table>
							</div>
							<div class="col-sm-7">
								<table class="table table-striped">
									<tr style="background:yellowgreen">
										<td colspan="3">Pinjam Alat</td>
									</tr>
									<tr>
										<td>Kode Alat</td>
										<td>:</td>
										<td>
											<div class="input-group">
												<input type="text" class="form-control" autocomplete="off" name="alat_id" id="alat-search" placeholder="Contoh ID alat : BK001" type="text" value="">
												<span class="input-group-btn">
													<a data-toggle="modal" data-target="#TableAlat" class="btn btn-primary"><i class="fa fa-search"></i></a>
												</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Data Alat</td>
										<td>:</td>
										<td>
											<div id="result_tunggu_alat"> <p style="color:red">* Belum Ada Hasil</p></div>
											<div id="result_alat"></div>
										</td>
									</tr>
								</table>
							</div>
						</div>
                        <div class="pull-right">
							<input type="hidden" name="tambah" value="tambah">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                    </form>
							<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
						</div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
<!--modal import -->
<div class="modal fade" id="Tablealat">
<div class="modal-dialog" style="width:80%;">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Add Alat</h4>
</div>
<div id="modal_body" class="modal-body fileSelection1">
<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Alat</th>
				<th>Brand</th>
				<th>Tahun Alat</th>
				<th>Stok Alat</th>
				<th>Tanggal Masuk</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $no=1;foreach($alat->result_array() as $isi){?>
			<tr>
				<td><?= $no;?></td>
				<td><?= $isi['nama_alat'];?></td>
				<td><?= $isi['brand'];?></td>
				<td><?= $isi['thn_alat'];?></td>
				<td><?= $isi['jmlh'];?></td>
				<td><?= $isi['tgl_masuk'];?></td>
				<td style="width:17%">
				<button class="btn btn-primary" id="Select_File2" data_id="<?= $isi['alat_id'];?>">
					<i class="fa fa-check"> </i> Pilih
				</button>
				<a href="<?= base_url('data/alatdetail/'.$isi['id_alat']);?>" target="_blank">
					<button class="btn btn-success"><i class="fa fa-sign-in"></i> Detail</button></a>
				</td>
			</tr>
		<?php $no++;}?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
	$(".fileSelection1 #Select_File2").click(function (e) {
		document.getElementsByName('alat_id')[0].value = $(this).attr("data_id");
		$('#Tablealat').modal('hide');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('transaksi/alat');?>",
			data:'kode_alat='+$(this).attr("data_id"),
			beforeSend: function(){
				$("#result_alat").html("");
				$("#result_tunggu_alat").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html){
				$("#result_alat").load("<?= base_url('transaksi/alat_list');?>");
				$("#result_tunggu_alat").html('');
			}
		});
	});
	</script>
	  
	<script>
	// AJAX call for autocomplete 
	$(document).ready(function(){
		$("#alat-search").keyup(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('transaksi/alat');?>",
				data:'kode_alat='+$(this).val(),
				beforeSend: function(){
					$("#result_tunggu_alat").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
				},
				success: function(html){
					$("#result_alat").load("<?= base_url('transaksi/alat_list');?>");
					$("#result_tunggu_alat").html('');
				}
			});
		});
	});
	</script>
 <!--modal import -->
 <div class="modal fade" id="TableAnggota">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Add Anggota</h4>
	</div>
	<div id="modal_body" class="modal-body fileSelection1">
	<table id="example3" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>ID</th>
				<th>Nama</th>
				<th>Jenkel</th>
				<th>Telepon</th>
				<th>Level</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $no=1;foreach($user as $isi){
			if($isi['level'] == 'Anggota'){
			?>
			<tr>
				<td><?= $no;?></td>
				<td><?= $isi['anggota_id'];?></td>
				<td><?= $isi['nama'];?></td>
				<td><?= $isi['jenkel'];?></td>
				<td><?= $isi['telepon'];?></td>
				<td><?= $isi['level'];?></td>
				<td style="width:20%;">
					<button class="btn btn-primary" id="Select_File1" data_id="<?= $isi['anggota_id'];?>">
					<i class="fa fa-check"> </i> Pilih
					</button>
				</td>
			</tr>
		<?php $no++;}}?>
		</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
	</div>
	</div>
	<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<script>
	$(".fileSelection1 #Select_File1").click(function (e) {
		document.getElementsByName('anggota_id')[0].value = $(this).attr("data_id");
		$('#TableAnggota').modal('hide');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('transaksi/result');?>",
			data:'kode_anggota='+$(this).attr("data_id"),
			beforeSend: function(){
				$("#result").html("");
				$("#result_tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html){
				$("#result").html(html);
				$("#result_tunggu").html('');
			}
		});
	});
	</script>
	  
	<script>
	// AJAX call for autocomplete 
	$(document).ready(function(){
		$("#search-box").keyup(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('transaksi/result');?>",
				data:'kode_anggota='+$(this).val(),
				beforeSend: function(){
					$("#result").html("");
					$("#result_tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
				},
				success: function(html){
					$("#result").html(html);
					$("#result_tunggu").html('');
				}
			});
		});
	});
	</script>
