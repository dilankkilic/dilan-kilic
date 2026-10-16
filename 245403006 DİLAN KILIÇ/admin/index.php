<?php
require_once '../config.php';
requireAdmin();

// İstatistikler
$blogSayisi    = $pdo->query("SELECT COUNT(*) FROM blog")->fetchColumn();
$mesajSayisi   = $pdo->query("SELECT COUNT(*) FROM mesajlar")->fetchColumn();
$okunmamis     = $pdo->query("SELECT COUNT(*) FROM mesajlar WHERE okundu=0")->fetchColumn();
$hizmetSayisi  = $pdo->query("SELECT COUNT(*) FROM hizmetler")->fetchColumn();
$kulSayisi     = $pdo->query("SELECT COUNT(*) FROM kullanicilar")->fetchColumn();

// Son blog yazıları
$sonBloglar = $pdo->query("SELECT b.id, b.baslik, b.tarih, b.durum, k.ad, k.soyad FROM blog b LEFT JOIN kullanicilar k ON b.yazar_id=k.id ORDER BY b.tarih DESC LIMIT 5")->fetchAll();

// Son mesajlar
$sonMesajlar = $pdo->query("SELECT * FROM mesajlar ORDER BY tarih DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel | TechNova</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>

<!-- SIDEBAR -->
<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <img src="<?= SITE_URL ?>/assets/img/logo.png" alt="TechNova" class="sidebar-logo">
  </div>
  <nav class="sidebar-nav">
    <div class="sidebar-label">Genel</div>
    <a href="<?= SITE_URL ?>/admin/index.php" class="sidebar-link active"><i class="bi bi-speedometer2"></i> Dashboard</a>

    <div class="sidebar-label">İçerik</div>
    <a href="<?= SITE_URL ?>/admin/blog.php" class="sidebar-link"><i class="bi bi-journal-text"></i> Blog Yazıları</a>
    <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="sidebar-link"><i class="bi bi-plus-circle"></i> Yeni Blog Ekle</a>
    <a href="<?= SITE_URL ?>/admin/hizmetler.php" class="sidebar-link"><i class="bi bi-gear"></i> Hizmetler</a>
    <a href="<?= SITE_URL ?>/admin/hakkimizda.php" class="sidebar-link"><i class="bi bi-info-circle"></i> Hakkımızda</a>

    <div class="sidebar-label">Yönetim</div>
    <a href="<?= SITE_URL ?>/admin/giris-ayarlari.php" class="sidebar-link"><i class="bi bi-door-open"></i> Giriş Sayfası</a>
    <a href="<?= SITE_URL ?>/admin/site-ayarlari.php" class="sidebar-link"><i class="bi bi-toggles2"></i> Site Ayarları</a>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link">
      <i class="bi bi-envelope"></i> Mesajlar
      <?php if($okunmamis > 0): ?><span class="badge-count"><?= $okunmamis ?></span><?php endif; ?>
    </a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>

    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<!-- MAIN -->
<div class="admin-main">
  <div class="admin-topbar">
    <div>
      <span style="font-weight:600; color:#0F172A;">Dashboard</span>
      <span style="color:#94A3B8; margin:0 8px;">—</span>
      <span style="color:#64748B; font-size:0.88rem;"><?= date('d MMMM Y') ?></span>
    </div>
    <div class="d-flex align-items-center gap-3">
      <span style="font-size:0.9rem; color:#64748B;">Hoş geldiniz, <strong style="color:#0F172A;"><?= htmlspecialchars($_SESSION['ad']) ?></strong></span>
      <a href="<?= SITE_URL ?>/cikis.php" class="btn btn-sm btn-outline-danger" style="border-radius:8px; font-size:0.82rem;"><i class="bi bi-box-arrow-right"></i> Çıkış</a>
    </div>
  </div>

  <div class="admin-content">
    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="bi bi-journal-text"></i></div>
          <div class="stat-info">
            <div class="number"><?= $blogSayisi ?></div>
            <div class="label">Blog Yazısı</div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon cyan"><i class="bi bi-envelope"></i></div>
          <div class="stat-info">
            <div class="number"><?= $mesajSayisi ?></div>
            <div class="label">Toplam Mesaj <small style="color:#EF4444;">(<?= $okunmamis ?> yeni)</small></div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon green"><i class="bi bi-gear"></i></div>
          <div class="stat-info">
            <div class="number"><?= $hizmetSayisi ?></div>
            <div class="label">Hizmet</div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon orange"><i class="bi bi-people"></i></div>
          <div class="stat-info">
            <div class="number"><?= $kulSayisi ?></div>
            <div class="label">Kullanıcı</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Son Blog / Son Mesajlar -->
    <div class="row g-4 mb-4">
      <div class="col-lg-12">
        <div class="admin-table-card" style="background:linear-gradient(135deg,#667EEA 0%,#764BA2 100%); color:white;">
          <div class="card-header" style="border-bottom:1px solid rgba(255,255,255,0.2);">
            <h5 style="color:white;"><i class="bi bi-brush me-2"></i>Giriş Sayfası Ayarları</h5>
          </div>
          <div style="padding:1.5rem;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
              <div>
                <div style="font-size:0.85rem; opacity:0.9; margin-bottom:0.5rem;">🎨 Renkler Düzenle</div>
                <p style="font-size:0.9rem; margin:0; margin-bottom:1rem;">Giriş sayfasının renklerini özelleştir</p>
              </div>
              <div>
                <div style="font-size:0.85rem; opacity:0.9; margin-bottom:0.5rem;">📝 Metinleri Değiştir</div>
                <p style="font-size:0.9rem; margin:0; margin-bottom:1rem;">Başlık, alt başlık ve logoyu özelleştir</p>
              </div>
            </div>
            <a href="<?= SITE_URL ?>/admin/giris-ayarlari.php" class="btn btn-light" style="border-radius:8px; font-weight:600;"><i class="bi bi-palette"></i> Şimdi Düzenle</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="admin-table-card">
          <div class="card-header">
            <h5><i class="bi bi-journal-text me-2" style="color:#1A56DB;"></i>Son Blog Yazıları</h5>
            <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="btn btn-primary btn-sm" style="border-radius:8px; font-size:0.82rem;"><i class="bi bi-plus"></i> Yeni Ekle</a>
          </div>
          <table class="table">
            <thead><tr>
              <th>Başlık</th><th>Yazar</th><th>Tarih</th><th>Durum</th><th></th>
            </tr></thead>
            <tbody>
              <?php foreach($sonBloglar as $b): ?>
              <tr>
                <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($b['baslik']) ?></td>
                <td><?= htmlspecialchars($b['ad'].' '.$b['soyad']) ?></td>
                <td><?= date('d.m.Y', strtotime($b['tarih'])) ?></td>
                <td><span class="badge-status <?= $b['durum']==='yayinda' ? 'published' : 'draft' ?>"><?= $b['durum']==='yayinda' ? 'Yayında' : 'Taslak' ?></span></td>
                <td>
                  <a href="<?= SITE_URL ?>/admin/blog-duzenle.php?id=<?= $b['id'] ?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div style="padding:1rem 1.5rem; border-top:1px solid #E2E8F0;">
            <a href="<?= SITE_URL ?>/admin/blog.php" style="font-size:0.85rem; color:#1A56DB;">Tümünü görüntüle <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="admin-table-card">
          <div class="card-header">
            <h5><i class="bi bi-envelope me-2" style="color:#06B6D4;"></i>Son Mesajlar</h5>
            <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="btn btn-outline-secondary btn-sm" style="border-radius:8px; font-size:0.82rem;">Tümü</a>
          </div>
          <?php if (empty($sonMesajlar)): ?>
          <div style="padding:2rem; text-align:center; color:#94A3B8;">
            <i class="bi bi-inbox" style="font-size:2rem;"></i>
            <p style="margin-top:0.5rem; font-size:0.88rem;">Henüz mesaj yok</p>
          </div>
          <?php else: ?>
          <?php foreach($sonMesajlar as $m): ?>
          <div style="padding:1rem 1.5rem; border-bottom:1px solid #E2E8F0; <?= !$m['okundu'] ? 'background:#F0F7FF;' : '' ?>">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div style="font-weight:<?= !$m['okundu'] ? '700' : '500' ?>; font-size:0.9rem; color:#0F172A;"><?= htmlspecialchars($m['ad']) ?></div>
                <div style="font-size:0.82rem; color:#64748B;"><?= htmlspecialchars(mb_substr($m['konu'],0,45)) ?></div>
              </div>
              <div style="font-size:0.75rem; color:#94A3B8;"><?= date('d.m', strtotime($m['tarih'])) ?></div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
