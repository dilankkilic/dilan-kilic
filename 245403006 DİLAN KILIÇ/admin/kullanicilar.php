<?php
require_once '../config.php';
requireAdmin();

$kullanicilar = $pdo->query("SELECT id, ad, soyad, email, rol, olusturma_tarihi FROM kullanicilar ORDER BY olusturma_tarihi DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kullanıcılar | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/blog.php" class="sidebar-link"><i class="bi bi-journal-text"></i> Blog Yazıları</a>
    <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="sidebar-link"><i class="bi bi-plus-circle"></i> Yeni Blog Ekle</a>
    <a href="<?= SITE_URL ?>/admin/hizmetler.php" class="sidebar-link"><i class="bi bi-gear"></i> Hizmetler</a>
    <a href="<?= SITE_URL ?>/admin/hakkimizda.php" class="sidebar-link"><i class="bi bi-info-circle"></i> Hakkımızda</a>
    <div class="sidebar-label">Yönetim</div>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link active"><i class="bi bi-people"></i> Kullanıcılar</a>
    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<div class="admin-main">
  <div class="admin-topbar">
    <span style="font-weight:600; color:#0F172A;">Kullanıcılar</span>
  </div>
  <div class="admin-content">
    <div class="admin-table-card">
      <div class="card-header">
        <h5><i class="bi bi-people me-2" style="color:#1A56DB;"></i>Tüm Kullanıcılar (<?= count($kullanicilar) ?>)</h5>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead><tr><th>ID</th><th>Ad Soyad</th><th>E-posta</th><th>Rol</th><th>Kayıt Tarihi</th></tr></thead>
          <tbody>
            <?php foreach($kullanicilar as $k): ?>
            <tr>
              <td style="color:#94A3B8; font-size:0.8rem;">#<?= $k['id'] ?></td>
              <td>
                <div style="display:flex; align-items:center; gap:10px;">
                  <div style="width:35px; height:35px; background:linear-gradient(135deg,#1A56DB,#06B6D4); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:0.82rem; font-weight:700; flex-shrink:0;">
                    <?= mb_strtoupper(mb_substr($k['ad'],0,1).mb_substr($k['soyad'],0,1)) ?>
                  </div>
                  <?= htmlspecialchars($k['ad'].' '.$k['soyad']) ?>
                </div>
              </td>
              <td style="font-size:0.88rem;"><?= htmlspecialchars($k['email']) ?></td>
              <td><span class="badge-status <?= $k['rol']==='admin' ? 'admin' : 'user' ?>"><?= $k['rol']==='admin' ? 'Admin' : 'Kullanıcı' ?></span></td>
              <td style="font-size:0.85rem; color:#64748B;"><?= date('d.m.Y', strtotime($k['olusturma_tarihi'])) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
