<?= $this->extend('partials/backend/main') ?>

<?= $this->section('title') ?>
Kawasan Cagar Budaya
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3">
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header bg-primary">
            Daftar Kawasan
        </div>
        <div class="card-body">

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i>
                Buat Artikel Kawasan
            </button>
            <!--  -->

            <table class="table table-bordered" id="datatable">
                <thead>
                    <tr>
                        <th width="10px">No</th>
                        <th>Judul</th>
                        <th>Foto</th>
                        <th>NO REGNAS</th>
                        <th>Nama Pemilik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kawasan as $k) { ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $k['judul'] ?></td>
                            <td style="text-align: center;">
                                <img src="/img/<?= $k['foto']; ?>" class="zoom" alt="">
                            </td>
                            <td style="text-align: center;">
                                <?= $k['no_regnas'] ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $k['nama_pemilik'] ?>
                            </td>
                            <td style="text-align: center;">
                                <!-- Buutton edit-->
                                <button type="submit" class="btn btn-primary edit" id="edit" data-id="<?= $k['id'] ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <!--  -->
                                <!-- Buutton Delete-->
                                <form action="/kawasan/<?= $k['id']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin?');">
                                        <i class="fa fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                                <!--  -->
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<?php
$generateRandom = rand(11111111, 999999999) . '.' . rand(00, 99) . '.' . rand(111111, 999999);
?>
<div class="modal fade" id="exampleModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Buat Artikel Kawasan</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/kawasan/save" id="formKawasan" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="oldfoto" class="oldfoto">
                    <div class="form-group">
                        <label for="judul" class="control-label">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <div id="old_foto"></div>
                        <div id="file_name"></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto" name="foto">
                            <label class="custom-file-label" for="foto">Pilih Gambar</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_regnas" class="control-label">NO REGNAS</label>
                        <input type="text" name="no_regnas" id="no_regnas" value="RNCB.<?= $generateRandom ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sk_penetapan" class="control-label">SK Penetepan</label>
                        <input type="text" name="sk_penetapan" id="sk_penetapan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kategori_cb" class="control-label">Kategori</label>
                        <input type="text" name="kategori_cb" id="kategori_cb" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kabupaten_kota" class="control-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="provinsi" class="control-label">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_pemilik" class="control-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_pengelola" class="control-label">Nama Pengelola</label>
                        <input type="text" name="nama_pengelola" id="nama_pengelola" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<!-- Akhir Modal -->
<?= $this->section('script'); ?>
<script>
    $('.edit').click(function() {
        $('#exampleModalLabel').html('Form Edit Data Kawasan');
        var id = $(this).data('id');
        $('#formKawasan').attr('action', '/kawasan/update/' + id);

        // alert(id);
        $.ajax({
            url: 'kawasan/edit' + '/' + id,
            method: 'get',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $.each(data, function(key, value) {
                    // alert(key);
                    $('#id').val(value.id);
                    $('#judul').val(value.judul);
                    var foto = value.foto;
                    // alert(foto);
                    var old_foto = "<h6>Gambar Sebelumnya : <img src='/img/" + foto + "' width='100px;' class='margin: 10px;' alt=''> </h6>";
                    var file_name = "<h6>Nama File : " + foto + "</h6>";
                    $('#file_name').html(file_name);
                    $('#old_foto').html(old_foto);
                    $('.oldfoto').attr("value", value.foto);
                    $('#no_regnas').val(value.no_regnas);
                    $('#sk_penetapan').val(value.sk_penetapan);
                    $('#kategori_cb').val(value.kategori_cb);
                    $('#kabupaten_kota').val(value.kabupaten_kota);
                    $('#provinsi').val(value.provinsi);
                    $('#nama_pemilik').val(value.nama_pemilik);
                    $('#nama_pengelola').val(value.nama_pengelola);
                    $('#exampleModal').modal('show');
                });
            }
        });

    })
</script>
<?= $this->endSection(); ?>