<?= $this->extend('admin/layout/template_qrcode'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi') ?>
<?php
$lat = $keluar['koordinat_latitude'];
$lng = $keluar['koordinat_longitude'];
$mapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ID</label>
                    <p class="col-sm-10 col-form-label"><?= $keluar['id_keluar'] ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Keluar</label>
                    <p class="col-sm-10 col-form-label"><?= datetime($keluar['created_at']) ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keterangan</label>
                    <p class="col-sm-10 col-form-label"><?= nl2br($keluar['keterangan']) ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Koordinat latitude</label>
                    <p class="col-sm-10 col-form-label"><?= $keluar['koordinat_latitude'] ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Koordinat longitude</label>
                    <p class="col-sm-10 col-form-label"><?= $keluar['koordinat_longitude'] ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <p class="col-sm-10 col-form-label"><?= $keluar['alamat'] ?></p>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Koordinat</label>
                    <p class="col-sm-10 col-form-label">
                        <?= $lat ?>, <?= $lng ?>
                        <br>
                        <a href="<?= $mapsUrl ?>" target="_blank" class="btn btn-sm btn-success mt-2">
                            📍 Lihat di Google Maps
                        </a>
                    </p>
                </div>

                <div class="form-group">
                    <table id="dataTable1" class="table table-bordered table-hover table-striped table-valign-middle">
                        <thead align="center">
                            <tr>
                                <td style="width: 70px;">No.</td>
                                <td>Nama Barang</td>
                                <td>Spesifikasi</td>
                                <td style="width: 200px;">Jumlah</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($keluarDetail as $data) : ?>
                                <tr align="center">
                                    <td><?= $i++ ?></td>
                                    <td align="left"><?= $data['nm_barang'] ?></td>
                                    <td align="left"><?= nl2br($data['spek_attime']) ?></td>
                                    <td><?= ribuan($data['jumlah']) . ' ' . $data['satuan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>