<?php
require_once '../config.php';
requireAdmin();

// Mesajı okundu işaretle
if (isset($_GET['oku']) && is_numeric($_GET['oku'])) {
    $pdo->prepare("UPDATE mesajlar SET okundu=1 WHERE id=?")->execute([(int)$_GET['oku']]);
    header("Location: mesajlar.php");
    exit;
}

// Mesajı sil
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $pdo->prepare("DELETE FROM mesajlar WHERE id=?")->execute([(int)$_GET['sil']]);
    header("Location: mesajlar.php?silindi=1");
    exit;
}

// Mesaj detay
$detay = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM mesajlar WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $detay = $stmt->fetch();
    if ($detay && !$detay['okundu']) {
        $pdo->prepare("UPDATE mesajlar SET okundu=1 WHERE id=?")->execute([$detay['id']]);
    }
}

$mesajlar = $pdo->query("SELECT * FROM mesajlar ORDER BY tarih DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mesajlar | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link active"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>
    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<div class="admin-main">
  <div class="admin-topbar">
    <span style="font-weight:600; color:#0F172A;">Gelen Mesajlar</span>
  </div>
  <div class="admin-content">
    <?php if (isset($_GET['silindi'])): ?><div class="alert alert-success mb-3">Mesaj silindi.</div><?php endif; ?>

    <?php if ($detay): ?>
    <!-- Mesaj Detay -->
    <div class="form-card mb-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <h5 style="margin:0;"><?= htmlspecialchars($detay['konu']) ?></h5>
          <div style="font-size:0.85rem; color:#64748B; margin-top:0.25rem;">
            <strong><?= htmlspecialchars($detay['ad']) ?></strong> — <?= htmlspecialchars($detay['email']) ?>
            &nbsp;&bull;&nbsp; <?= date('d.m.Y H:i', strtotime($detay['tarih'])) ?>
          </div>
        </div>
        <a href="mesajlar.php" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">← Geri</a>
      </div>
      <div style="background:#F8FAFC; border-radius:10px; padding:1.5rem; line-height:1.8; color:#334155;">
        <?= nl2br(htmlspecialchars($detay['mesaj'])) ?>
      </div>
      <div class="mt-3 d-flex gap-2">
        <a href="mailto:<?= htmlspecialchars($detay['email']) ?>?subject=Re: <?= urlencode($detay['konu']) ?>" class="btn btn-primary btn-sm" style="border-radius:8px;"><i class="bi bi-reply me-1"></i>Yanıtla</a>
        <a href="mesajlar.php?sil=<?= $detay['id'] ?>" class="btn btn-outline-danger btn-sm" style="border-radius:8px;" onclick="return confirm('Bu mesajı silmek istediğinize emin misiniz?')"><i class="bi bi-trash me-1"></i>Sil</a>
      </div>
    </div>
    <?php endif; ?>

    <div class="admin-table-card">
      <div class="card-header">
        <h5><i class="bi bi-envelope me-2" style="color:#06B6D4;"></i>Tüm Mesajlar</h5>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead><tr><th>Gönderen</th><th>Konu</th><th>Tarih</th><th>Durum</th><th>İşlemler</th></tr></thead>
          <tbody>
            <?php if (empty($mesajlar)): ?>
            <tr><td colspan="5" class="text-center py-4 text-muted">Henüz mesaj yok.</td></tr>
            <?php endif; ?>
            <?php foreach($mesajlar as $m): ?>
            <tr style="<?= !$m['okundu'] ? 'background:#F0F7FF; font-weight:600;' : '' ?>">
              <td>
                <div style="font-size:0.9rem;"><?= htmlspecialchars($m['ad']) ?></div>
                <div style="font-size:0.78rem; color:#94A3B8;"><?= htmlspecialchars($m['email']) ?></div>
              </td>
              <td style="max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($m['konu']) ?></td>
              <td style="font-size:0.85rem; color:#64748B;"><?= date('d.m.Y H:i', strtotime($m['tarih'])) ?></td>
              <td>
                <?php if (!$m['okundu']): ?>
                <span class="badge-status" style="background:#DBEAFE; color:#1D4ED8;">Yeni</span>
                <?php else: ?>
                <span class="badge-status" style="background:#F1F5F9; color:#64748B;">Okundu</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="mesajlar.php?id=<?= $m['id'] ?>" class="btn-action view" title="Görüntüle"><i class="bi bi-eye"></i></a>
                  <a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="btn-action edit" title="Yanıtla"><i class="bi bi-reply"></i></a>
                  <a href="mesajlar.php?sil=<?= $m['id'] ?>" class="btn-action delete" title="Sil" onclick="return confirm('Silmek istediğinize emin misiniz?')"><i class="bi bi-trash"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
