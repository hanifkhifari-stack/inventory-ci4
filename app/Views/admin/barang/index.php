<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi') ?>
<?php helper('qr'); ?>



<!-- form data barang -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('item/searching') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Pencarian" name="keyword" value="<?= $keyword; ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                        </div>
                    </div>
                </form>

                <p>
                    <a href="<?= base_url('item/add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                </p>
                <table id="dataTable1" class="table table-bordered table-hover table-striped">
                    <thead align="center">
                        <tr>
                            <td style="width: 40px;">No.</td>
                            <td style="width: 100px;">ID</td>                           
                            <td style="width: 200px;">Nama Barang</td>
                            <td style="width: 200px;">Harga Barang</td>
                            <td>Display Name</td>
                            <td style="width: 80px;">Stok</td>
                            <td style="width: 80px;">Satuan</td>
                            <td style="width: 80px;">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (25 * ($currentPage - 1));
                        foreach ($barang as $data) : ?>
                            <tr align="center">
                                <td><?= $i++ ?></td>
                                <td><?= $data['id_barang'] ?></td>
                                <td align="left"><?= $data['nm_barang'] ?></td>
                                <td>Rp. <?= number_format($data['hrg_barang'], 2, ',', '.'); ?></td>
                                <td><?= $data['display_name'] ?></td>
                                <td><?= $data['stok'] ?></td>
                                <td><?= $data['satuan'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#lihat<?= $data['id_barang']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="<?= base_url('item/edit/' . $data['id_barang']) ?>" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="<?= base_url('item/delete/' . $data['id_barang']) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    <a href="<?= base_url('item/cetak_qr/' . $data['id_barang']) ?>" class="btn btn-primary btn-sm"><i class="fas fa-qrcode"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <i>Menampilkan 25 data per halaman.</i>
                <div class="float-right">
                    <?= $pager->links('barang', 'paging'); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Form edit barang  -->

<?php foreach ($barang as $b) : ?>
    <div class="modal fade" id="lihat<?= $b['id_barang']; ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="float-right">
                        <a href="<?= base_url('item/' . $b['id_barang']) ?>" class="btn btn-info"><i class="fas fa-eye"></i> Detail</a>
                        <a href="<?= base_url('item/edit/' . $b['id_barang']) ?>" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                    </p>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 25%;">ID Barang</th>
                            <td><?= $b['id_barang']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td><?= $b['nm_barang']; ?></td>
                        </tr>
                        <tr>
                            <th>Harga Barang</th>
                            <td>Rp. <?= number_format($b['hrg_barang'], 2, ',', '.'); ?></td>
                        </tr>
                      <tr>
                        <td>Display Name</td>
                        <td><?= $b['display_name'] ?></td>
                    </tr>
                            <th>Stok</th>
                            <td><?= ribuan($b['stok']) . ' ' . $b['satuan']; ?></td>
                        </tr>
                        <tr>
                            <th>Spesifikasi</th>
                            <td><?= nl2br($b['spek']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

<?php endforeach; ?>
<?= $this->endSection(); ?>