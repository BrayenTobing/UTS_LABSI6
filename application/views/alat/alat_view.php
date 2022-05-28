<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<?php if($this->session->userdata('level') == 'Petugas'){?>
                    <a href="data/alattambah"><button class="btn btn-primary">
						<i class="fa fa-plus"> </i> Tambah Alat</button></a>
					<?php }?>
                </div>
				<!-- /.box-header -->
				<div class="box-body">
                    <br/>
					<div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sampul</th>
                                <th>Nama Alat</th>
                                <th>Brand</th>
                                <th>Tahun Alat</th>
                                <th>Stok Alat</th>
                                <th>Disewa</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1;foreach($alat->result_array() as $isi){?>
                            <tr>
                                <td><?= $no;?></td>
                                <td>
                                    <center>
                                        <?php if(!empty($isi['sampul'] !== "0")){?>
                                        <img src="<?php echo base_url();?>assets_style/image/alat/<?php echo $isi['sampul'];?>" alt="#" 
                                        class="img-responsive" style="height:auto;width:100px;"/>
                                        <?php }else{?>
                                            <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
											<i class="fa fa-book fa-3x" style="color:#333;"></i> <br/><br/>
											Tidak Ada Sampul
                                        <?php }?>
                                    </center>
                                </td>
                                <td><?= $isi['nama_alat'];?></td>
                                <td><?= $isi['brand'];?></td>
                                <td><?= $isi['thn_alat'];?></td>
                                <td><?= $isi['jmlh'];?></td>
								<td>
									<?php
										$id = $isi['alat_id'];
										$dd = $this->db->query("SELECT * FROM tbl_sewa WHERE alat_id= '$id' AND status = 'Disewa'");
										if($dd->num_rows() > 0 )
										{
											echo $dd->num_rows();
										}else{
											echo '0';
										}
									?>
								</td>
                                <td><?= $isi['tgl_masuk'];?></td>
									<td <?php if($this->session->userdata('level') == 'Petugas'){?>style="width:17%;"<?php }?>>
								
									<?php if($this->session->userdata('level') == 'Petugas'){?>
									<a href="<?= base_url('data/alatedit/'.$isi['id_alat']);?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
									<a href="<?= base_url('data/alatdetail/'.$isi['id_alat']);?>">
									<button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
                                    <a href="<?= base_url('data/prosesalat?alat_id='.$isi['id_alat']);?>" onclick="return confirm('Anda yakin alat ini akan dihapus ?');">
									<button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
									<?php }else{?>
										<a href="<?= base_url('data/alatdetail/'.$isi['id_alat']);?>">
										<button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
									<?php }?>
                                </td>
                            </tr>
                        <?php $no++;}?>
                        </tbody>
                    </table>
			    </div>
			    </div>
	        </div>
    	</div>
    </div>
</section>
</div>
