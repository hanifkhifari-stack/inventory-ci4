<?= $this->extend('admin/layout/template_qrcode'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td style="width: 20%;">ID</td>
                        <td><?= $barang['id_barang'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td><?= $barang['nm_barang'] ?></td>
                    </tr>
                    <tr>
                        <td>Harga Barang</td>
                        <td><?= $barang['hrg_barang'] ?></td>
                    </tr>
                    <tr>
                        <td>Display Name</td>
                        <td><?= $barang['display_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Spesifikasi</td>
                        <td><?= nl2br($barang['spek']) ?></td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td><?= ribuan($barang['stok']) . ' ' . $barang['satuan'] ?></td>
                    </tr>
                    <tr>
                        <td>Last Update</td>
                        <td><?= datetime($barang['updated_at']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>