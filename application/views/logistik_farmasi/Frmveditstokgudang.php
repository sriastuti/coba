<?php
$this->load->view('layout/header_left.php');
?>
    <script type='text/javascript'>
        //-----------------------------------------------Data Table
        $(document).ready(function() {

        } );
        //---------------------------------------------------------


        function save() {
            var id_inventory = $("#id_inventory").val();
            var exp_date = $("#exp_date").val();
            var qty_akhir = $("#qty_akhir").val();

            if(exp_date !== '' || qty_akhir !== '') {

                $.ajax({
                    type: 'POST',
                    dataType: 'text',
                    url: "<?php echo base_url('logistik_farmasi/Frmcstok/update_stok')?>",
                    data: {
                        id_inventory: id_inventory,
                        expire_date: exp_date,
                        qty_akhir: qty_akhir
                    },
                    success: function (data) {
                        if(data === 'sukses') {
                            swal({
                                    title: "Berhasil!",
                                    text: "Data sudah di Update",
                                    type: "success",
                                    closeOnConfirm: false,
                                    showLoaderOnConfirm: true
                                },
                                function () {
                                    window.close();
                                }
                            );
                            
                        }else{
                            sweetAlert('Oops!', 'Data Gagal Disimpan.', 'error');
                        }
                    },
                    error: function () {
                        alert("error");
                    }
                });
            }else{
                sweetAlert('Perhatian!', 'Silahkan Isi Expire Date/ Qty Akhirnya', 'error');
            }
        }
    </script>

<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msg');
    ?>
</section>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div style="background: #e4efe0">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">DAFTAR STOK BARANG</h3>
                </div>
                <div class="card-block">
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label">ID Obat</p>
                                <div class="col-sm-1">
                                    <input type="hidden" class="form-control" id="id_inventory" name="id_inventory" readonly value="<?=$detail->id_inventory?>">
                                    <input type="text" class="form-control" id="id_obat" name="id_obat" readonly value="<?=$detail->id_obat?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label">Nama Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nama" name="nama" readonly value="<?=$detail->nm_obat?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label">Expire Date</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="exp_date" name="exp_date" value="<?=$detail->expire_date?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label">QTY Awal</p>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="qty_awal" name="qty_awal" readonly value="<?=number_format($detail->qty, '0', ',', '.')?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label">QTY Akhir/ Baru</p>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="qty_akhir" name="qty_akhir">
                                </div>
                            </div>
                            <div class="form-group row">
                                <p class="col-sm-4 form-control-label"></p>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary" onclick="save()"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('layout/footer_left.php');
?>