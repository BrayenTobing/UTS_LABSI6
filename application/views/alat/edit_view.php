<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp;  <?= $title_web;?></li>
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
                    <form action="<?php echo base_url('data/prosesalat');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
								<div class="form-group">
									<label>Kategori</label>
									<select class="form-control select2" required="required"  name="kategori">
										<option disabled selected value> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>" <?php if($isi['id_kategori'] == $alat->id_kategori){ echo 'selected';}?>><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Rak / Lokasi</label>
                                    <select name="rak" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih Rak / Lokasi -- </option>
										<?php foreach($rakalat as $isi){?>
											<option value="<?= $isi['id_rak'];?>" <?php if($isi['id_rak'] == $alat->id_rak){ echo 'selected';}?>><?= $isi['nama_rak'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Alat</label>
                                    <input type="text" class="form-control" value="<?= $alat->nama_alat;?>" name="nama_alat" placeholder="Contoh : Cara Cepat Belajar Pemrograman Web">
                                </div>
                                <div class="form-group">
                                    <label>Brand</label>
                                    <input type="text" class="form-control" value="<?= $alat->brand;?>" name="brand" placeholder="Nama brand">
                                </div>
                                <div class="form-group">
                                    <label>Tahun Alat</label>
                                    <input type="number" class="form-control" value="<?= $alat->thn_alat;?>" name="thn" placeholder="Tahun alat : 2019">
                                </div>
								
                            </div>
                            <div class="col-sm-6">
								
								<div class="form-group">
                                    <label>Jumlah Alat</label>
                                    <input type="number" class="form-control" value="<?= $alat->jmlh;?>" name="jmlh" placeholder="Jumlah alat : 12">
								</div>
                                <div class="form-group">
								<label>Sampul <small style="color:green">(gambar) * opsional</small></label>
									<input type="file" accept="image/*" name="gambar">

									<?php if(!empty($alat->sampul !== "0")){?>
									<br/>
									<a href="<?= base_url('assets_style/image/alat/'.$alat->sampul);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/alat/'.$alat->sampul);?>" style="width:70px;height:70px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada Sampul</p>';}?>
								</div>
                                <div class="form-group">
								<label>Lampiran Alat <small style="color:green">(pdf) * ganti opsional</small></label>
                                    <input type="file" accept="" name="lampiran">
                                    <br>
									<?php if(!empty($alat->lampiran !== "0")){?>
									<a href="<?= base_url('assets_style/image/alat/'.$alat->lampiran);?>" class="btn btn-primary btn-md" target="_blank">
										<i class="fa fa-download"></i> Sample Alat
									</a>
									<?php  }else{ echo '<br/><p style="color:red">* Tidak ada Lampiran</p>';}?>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Lainnya</label>
                                    <textarea class="form-control" name="ket" id="summernotehal" style="height:120px"><?= $alat->isi;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="gmbr" value="<?= $alat->sampul;?>">
							<input type="hidden" name="lamp" value="<?= $alat->lampiran;?>">
							<input type="hidden" name="edit" value="<?= $alat->id_alat;?>">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                    </form>
                            <a href="<?= base_url('data');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
