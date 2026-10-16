<?php
require_once '../config.php';
requireAdmin();

// Silme işlemi
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $bid = (int)$_GET['sil'];
    // Resmi de sil
    $r = $pdo->prepare("SELECT resim FROM blog WHERE id=?");
    $r->execute([$bid]);
    $row = $r->fetch();
    if ($row && $row['resim'] && file_exists(__DIR__.'/../uploads/blog/'.$row['resim'])) {
        unlink(__DIR__.'/../uploads/blog/'.$row['resim']);
    }
    $pdo->prepare("DELETE FROM blog WHERE id=?")->execute([$bid]);
    header("Location: blog.php?silindi=1");
    exit;
}

$arama = clean($_GET['ara'] ?? '');
$where = '';
$params = [];
if ($arama) {
    $where = "WHERE baslik LIKE :ara";
    $params[':ara'] = "%$arama%";
}

$stmt = $pdo->prepare("SELECT b.*, k.ad, k.soyad FROM blog b LEFT JOIN kullanicilar k ON b.yazar_id=k.id $where ORDER BY b.tarih DESC");
$stmt->execute($params);
$bloglar = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blog Yönetimi | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>

<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <img src="<?= SITE_URL ?>/assets/img/logo.png" alt="TechNova" class="sidebar-logo">
  </div>
  <nav class="sidebar-nav">
    <div class="sidebar-label">Genel</div>
    <a href="<?= SITE_URL ?>/admin/index.php" class="sidebar-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <div class="sidebar-label">İçerik</div>
    <a href="<?= SITE_URL ?>/admin/blog.php" class="sidebar-link active"><i class="bi bi-journal-text"></i> Blog Yazıları</a>
    <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="sidebar-link"><i class="bi bi-plus-circle"></i> Yeni Blog Ekle</a>
    <a href="<?= SITE_URL ?>/admin/hizmetler.php" class="sidebar-link"><i class="bi bi-gear"></i> Hizmetler</a>
    <a href="<?= SITE_URL ?>/admin/hakkimizda.php" class="sidebar-link"><i class="bi bi-info-circle"></i> Hakkımızda</a>
    <div class="sidebar-label">Yönetim</div>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>
    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<div class="admin-main">
  <div class="admin-topbar">
    <span style="font-weight:600; color:#0F172A;">Blog Yazıları</span>
    <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="btn btn-primary btn-sm" style="border-radius:8px;"><i class="bi bi-plus"></i> Yeni Yazı</a>
  </div>
  <div class="admin-content">
    <?php if (isset($_GET['silindi'])): ?><div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i>Blog yazısı silindi.</div><?php endif; ?>
    <?php if (isset($_GET['kaydedildi'])): ?><div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i>İşlem başarılı.</div><?php endif; ?>

    <div class="admin-table-card">
      <div class="card-header">
        <h5><i class="bi bi-journal-text me-2" style="color:#1A56DB;"></i>Tüm Blog Yazıları (<?= count($bloglar) ?>)</h5>
        <form method="get" class="d-flex gap-2">
          <input type="text" name="ara" class="form-control form-control-sm" style="border-radius:8px; width:220px;" placeholder="Başlıkta ara..." value="<?= htmlspecialchars($arama) ?>">
          <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;"><i class="bi bi-search"></i></button>
        </form>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr><th>ID</th><th>Başlık</th><th>Kategori</th><th>Yazar</th><th>Tarih</th><th>Durum</th><th>İşlemler</th></tr>
          </thead>
          <tbody>
            <?php if (empty($bloglar)): ?>
            <tr><td colspan="7" class="text-center py-4 text-muted">Henüz blog yazısı yok.</td></tr>
            <?php endif; ?>
            <?php foreach($bloglar as $b): ?>
            <tr>
              <td style="color:#94A3B8; font-size:0.8rem;">#<?= $b['id'] ?></td>
              <td style="max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500;"><?= htmlspecialchars($b['baslik']) ?></td>
              <td><?= $b['kategori'] ? '<span class="blog-category" style="background:rgba(26,86,219,0.08);color:#1A56DB;padding:0.2rem 0.6rem;border-radius:12px;font-size:0.78rem;">'.htmlspecialchars($b['kategori']).'</span>' : '—' ?></td>
              <td><?= htmlspecialchars($b['ad'].' '.$b['soyad']) ?></td>
              <td style="font-size:0.85rem;"><?= date('d.m.Y', strtotime($b['tarih'])) ?></td>
              <td><span class="badge-status <?= $b['durum']==='yayinda' ? 'published' : 'draft' ?>"><?= $b['durum']==='yayinda' ? 'Yayında' : 'Taslak' ?></span></td>
              <td>
                <div class="d-flex gap-1">
                  <a href="<?= SITE_URL ?>/blog-detay.php?id=<?= $b['id'] ?>" target="_blank" class="btn-action view" title="Görüntüle"><i class="bi bi-eye"></i></a>
                  <a href="<?= SITE_URL ?>/admin/blog-duzenle.php?id=<?= $b['id'] ?>" class="btn-action edit" title="Düzenle"><i class="bi bi-pencil"></i></a>
                  <button onclick="silOnay(<?= $b['id'] ?>, '<?= htmlspecialchars(addslashes($b['baslik'])) ?>')" class="btn-action delete" title="Sil"><i class="bi bi-trash"></i></button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Silme Onay Modal -->
<div class="modal fade" id="silModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px; border:none;">
      <div class="modal-body p-4 text-center">
        <div style="width:60px; height:60px; background:#FEE2E2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem; color:#EF4444;"><i class="bi bi-trash"></i></div>
        <h5 style="margin-bottom:0.5rem;">Blog yazısını sil</h5>
        <p id="silMesaj" style="color:#64748B; font-size:0.9rem;"></p>
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button class="btn btn-secondary btn-sm" style="border-radius:8px;" data-bs-dismiss="modal">İptal</button>
          <a id="silBtn" href="#" class="btn btn-danger btn-sm" style="border-radius:8px;">Evet, Sil</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function silOnay(id, baslik) {
    document.getElementById('silMesaj').textContent = '"' + baslik + '" yazısını silmek istediğinize emin misiniz?';
    document.getElementById('silBtn').href = 'blog.php?sil=' + id;
    new bootstrap.Modal(document.getElementById('silModal')).show();
}
</script>
</body>
</html>
