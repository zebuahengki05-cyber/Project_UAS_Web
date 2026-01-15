<div class="container mt-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-primary text-uppercase">Laptop Pro Store</h2>
            <p class="text-muted">User: <strong><?= $_SESSION['user']['username']; ?></strong> | Role: <span class="badge bg-secondary"><?= $_SESSION['user']['role']; ?></span></p>
        </div>
        <div class="col-md-6">
            <form action="<?= BASEURL; ?>/dashboard/cari" method="POST" class="d-flex">
                <input type="text" name="keyword" class="form-control me-2 shadow-sm" placeholder="Cari laptop...">
                <button class="btn btn-primary" type="submit">Cari</button>
            </form>
        </div>
    </div>

    <?php if($_SESSION['user']['role'] == 'admin') : ?>
        <button type="button" class="btn btn-success mb-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-plus-circle"></i> Tambah Laptop
        </button>
    <?php endif; ?>

    <div class="row">
        <?php foreach($data['laptop'] as $lp) : ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow border-0" style="border-radius: 20px; overflow: hidden;">
                <img src="<?= BASEURL; ?>/img/laptop/<?= $lp['gambar']; ?>" class="card-img-top p-3" style="height: 200px; object-fit: contain;">
                
                <div class="card-body text-center">
                    <span class="badge bg-info text-dark mb-2"><?= $lp['brand']; ?></span>
                    <h5 class="fw-bold"><?= $lp['nama']; ?></h5>
                    <h4 class="text-primary fw-bold">Rp <?= number_format($lp['harga'], 0, ',', '.'); ?></h4>
                    <p class="text-muted small">Tersedia: <?= $lp['stok']; ?> Unit</p>
                    
                    <div class="mt-3 pt-3 border-top">
                        <?php if($_SESSION['user']['role'] == 'admin') : ?>
                            <div class="btn-group w-100">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $lp['id']; ?>">Edit</button>
                                <a href="<?= BASEURL; ?>/dashboard/hapus/<?= $lp['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                            </div>
                        <?php else : ?>
                            <?php 
                                // LOGIKA TOMBOL BELI WA
                                $no_wa = "628123456789"; // GANTI DENGAN NOMOR WA KAMU
                                $text = "Halo Admin, saya tertarik beli laptop " . $lp['nama'] . " (Rp " . number_format($lp['harga'],0,',','.') . ")";
                                $link_wa = "https://wa.me/" . $no_wa . "?text=" . urlencode($text);
                            ?>
                            <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-primary w-100 fw-bold">
                                <i class="bi bi-whatsapp"></i> Beli Sekarang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal<?= $lp['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header"><h5>Edit Laptop</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
              <form action="<?= BASEURL; ?>/dashboard/ubah" method="POST" enctype="multipart/form-data">
                <div class="modal-body text-start">
                    <input type="hidden" name="id" value="<?= $lp['id']; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $lp['gambar']; ?>">
                    
                    <label class="fw-bold small">Nama Laptop</label>
                    <input type="text" name="nama" class="form-control mb-2" value="<?= $lp['nama']; ?>" required>
                    
                    <label class="fw-bold small">Brand</label>
                    <input type="text" name="brand" class="form-control mb-2" value="<?= $lp['brand']; ?>" required>
                    
                    <label class="fw-bold small">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control mb-2" value="<?= (int)$lp['harga']; ?>" step="1" required>
                    
                    <label class="fw-bold small">Stok</label>
                    <input type="number" name="stok" class="form-control mb-2" value="<?= $lp['stok']; ?>" required>
                    
                    <label class="fw-bold small">Ganti Foto (Opsional)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-warning">Update Data</button></div>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>

    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php for($i = 1; $i <= $data['pages']; $i++) : ?>
            <li class="page-item <?= ($data['curr_page'] == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="<?= BASEURL; ?>/dashboard/index/<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
      </ul>
    </nav>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5>Tambah Laptop</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <form action="<?= BASEURL; ?>/dashboard/tambah" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Laptop" required>
            <input type="text" name="brand" class="form-control mb-2" placeholder="Brand" required>
            <input type="number" name="harga" class="form-control mb-2" placeholder="Harga" required>
            <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>
            <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi Singkat"></textarea>
            <label class="small">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control mb-2">
        </div>
        <div class="modal-footer"><button type="submit" class="btn btn-success">Simpan Data</button></div>
      </form>
    </div>
  </div>
</div>