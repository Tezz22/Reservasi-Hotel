<?php
require_once __DIR__ . '/../../Model/Kamar.php';

$kamarModel = new Kamar();
$kamarList = $kamarModel->getAllKamar();
$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/Public/uploads/';
$keyword = '';
if (isset($_POST['cari'])) {
    $keyword = trim($_POST['keyword']);
    $kamarList = $kamarModel->cariKamar($keyword); // misal lo punya function ini
} else {
    $kamarList = $kamarModel->getAllKamar();
}
?>
<link rel="stylesheet" href="../../css/pencarian.css">
<form id="search-form" method="post" action="">
    <input type="text" name="keyword" placeholder="Masukkan keyword pencarian..." autocomplete="off">
    <button type="submit" name="cari">Cari</button>
</form>
<div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($kamarList as $kamar): ?>
        <div class="col">
            <div class="card h-100 flex-row">
                <img src="<?= $baseUrl . htmlspecialchars($kamar['gambar'] ?? '') ?>"
                    alt="<?= htmlspecialchars($kamar['tipe'] ?? '') ?>"
                    class="img-fluid rounded-start"
                    style="width: 40%; object-fit: cover; height: 100%;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($kamar['tipe'] ?? '-') ?> - <?= htmlspecialchars($kamar['nomor_kamar'] ?? '-') ?></h5>
                    <p class="card-text"><?= htmlspecialchars($kamar['deskripsi'] ?? '-') ?></p>
                    <p class="card-text text-success fw-bold mt-auto">
                        Rp<?= number_format($kamar['harga'] ?? 0, 0, ',', '.') ?>/malam
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <?php if ($tamu && $kamar['status'] === 'tersedia'): ?>
                            <a href="../View/reservasi_user.php?kamar_id=<?= $kamar['id'] ?>" class="btn btn-sm btn-outline-primary">
                                Pesan
                            </a>
                        <?php endif; ?>
                        <?php if ($akuAdmin): ?>
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editKamarModal<?= $kamar['id'] ?>">
                                Edit
                            </button>
                            <a href="../../Model/hapus_kamar.php?id=<?= $kamar['id'] ?>" class="btn btn-sm btn-outline-danger">Hapus</a>
                        <?php endif; ?>
                        <small class="text-body-secondary"><?= htmlspecialchars($kamar['status'] ?? '-') ?></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editKamarModal<?= $kamar['id'] ?>" tabindex="-1" aria-labelledby="editKamarModalLabel<?= $kamar['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../Model/edit_kamar.php" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKamarModalLabel<?= $kamar['id'] ?>">Edit Kamar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $kamar['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Nomor Kamar</label>
                                <input type="text" class="form-control" name="nomor_kamar" value="<?= htmlspecialchars($kamar['nomor_kamar']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <input type="text" class="form-control" name="tipe" value="<?= htmlspecialchars($kamar['tipe']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" required><?= htmlspecialchars($kamar['deskripsi']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control" name="harga" value="<?= htmlspecialchars($kamar['harga']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="tersedia" <?= $kamar['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                    <option value="dipesan" <?= $kamar['status'] === 'dipesan' ? 'selected' : '' ?>>Dipesan</option>
                                    <option value="perbaikan" <?= $kamar['status'] === 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <input type="hidden" name="gambar_lama" value="<?= $kamar['gambar'] ?>">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- <div class="modal fade" id="editKamarModal<?= $kamar['id'] ?>" tabindex="-1" aria-labelledby="editKamarModalLabel<?= $kamar['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="../../Model/edit_kamar.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKamarModalLabel<?= $kamar['id'] ?>">Edit Kamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $kamar['id'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> -->


