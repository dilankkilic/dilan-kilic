<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';

// Hizmet sil
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $pdo->prepare("DELETE FROM hizmetler WHERE id=?")->execute([(int)$_GET['sil']]);
    header("Location: hizmetler.php?silindi=1");
    exit;
}

// Hizmet ekle / güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hizmet_adi = clean($_POST['hizmet_adi'] ?? '');
    $aciklama   = clean($_POST['aciklama'] ?? '');
    $icon       = clean($_POST['icon'] ?? 'bi-gear');
    $sira       = (int)($_POST['sira'] ?? 0);
    $durum      = isset($_POST['durum']) ? 1 : 0;
    $edit_id    = filter_input(INPUT_POST, 'edit_id', FILTER_VALIDATE_INT);

    if (!$hizmet_adi || !$aciklama) {
        $hata = 'Hizmet adı ve açıklama zorunludur.';
    } elseif ($edit_id) {
        $pdo->prepare("UPDATE hizmetler SET hizmet_adi=?, aciklama=?, icon=?, sira=?, durum=? WHERE id=?")->execute([$hizmet_adi, $aciklama, $icon, $sira, $durum, $edit_id]);
        $basari = 'Hizmet güncellendi.';
    } else {
        $pdo->prepare("INSERT INTO hizmetler (hizmet_adi, aciklama, icon, sira, durum) VALUES (?,?,?,?,?)")->execute([$hizmet_adi, $aciklama, $icon, $sira, $durum]);
        $basari = 'Hizmet eklendi.';
    }
}

$duzenlenen = null;
if (isset($_GET['duzenle']) && is_numeric($_GET['duzenle'])) {
    $stmt = $pdo->prepare("SELECT * FROM hizmetler WHERE id=?");
    $stmt->execute([(int)$_GET['duzenle']]);
    $duzenlenen = $stmt->fetch();
}

$hizmetler = $pdo->query("SELECT * FROM hizmetler ORDER BY sira, id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hizmetler | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/hizmetler.php" class="sidebar-link active"><i class="bi bi-gear"></i> Hizmetler</a>
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
    <span style="font-weight:600; color:#0F172A;">Hizmet Yönetimi</span>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><?= $hata ?></div><?php endif; ?>
    <?php if ($basari): ?><div class="alert alert-success mb-3"><?= $basari ?></div><?php endif; ?>
    <?php if (isset($_GET['silindi'])): ?><div class="alert alert-success mb-3">Hizmet silindi.</div><?php endif; ?>

    <div class="row g-4">
      <div class="col-lg-5">
        <div class="form-card">
          <div class="card-title"><?= $duzenlenen ? 'Hizmet Düzenle' : 'Yeni Hizmet Ekle' ?></div>
          <form method="post">
            <?php if ($duzenlenen): ?><input type="hidden" name="edit_id" value="<?= $duzenlenen['id'] ?>"><?php endif; ?>
            <div class="mb-3">
              <label class="form-label">Hizmet Adı *</label>
              <input type="text" name="hizmet_adi" class="form-control" required maxlength="255" value="<?= htmlspecialchars($duzenlened['hizmet_adi'] ?? ($duzenlenen['hizmet_adi'] ?? '')) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Açıklama *</label>
              <textarea name="aciklama" class="form-control" rows="4" required><?= htmlspecialchars($duzenlenen['aciklama'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Bootstrap Icon Kodu</label>
              <input type="text" name="icon" class="form-control" placeholder="bi-gear" maxlength="100" value="<?= htmlspecialchars($duzenlenen['icon'] ?? 'bi-gear') ?>">
              <small style="color:#94A3B8; font-size:0.78rem;">Örn: bi-globe, bi-phone, bi-shield-lock</small>
            </div>
            <div class="mb-3">
              <label class="form-label">Sıra</label>
              <input type="number" name="sira" class="form-control" min="0" value="<?= $duzenlenen['sira'] ?? 0 ?>">
            </div>
            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" name="durum" id="durum" value="1" <?= (!$duzenlenen || $duzenlenen['durum']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="durum">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; font-weight:600;">
              <?= $duzenlenen ? '<i class="bi bi-check-lg me-2"></i>Güncelle' : '<i class="bi bi-plus me-2"></i>Ekle' ?>
            </button>
            <?php if ($duzenlenen): ?>
            <a href="hizmetler.php" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;">İptal</a>
            <?php endif; ?>
          </form>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="admin-table-card">
          <div class="card-header">
            <h5><i class="bi bi-gear me-2" style="color:#1A56DB;"></i>Hizmetler (<?= count($hizmetler) ?>)</h5>
          </div>
          <table class="table">
            <thead><tr><th>İkon</th><th>Hizmet</th><th>Sıra</th><th>Durum</th><th>İşlem</th></tr></thead>
            <tbody>
              <?php foreach($hizmetler as $h): ?>
              <tr>
                <td><i class="bi <?= htmlspecialchars($h['icon']) ?>" style="font-size:1.3rem; color:#1A56DB;"></i></td>
                <td>
                  <div style="font-weight:600; font-size:0.9rem;"><?= htmlspecialchars($h['hizmet_adi']) ?></div>
                  <div style="font-size:0.8rem; color:#94A3B8;"><?= htmlspecialchars(mb_substr($h['aciklama'],0,55)) ?>...</div>
                </td>
                <td><?= $h['sira'] ?></td>
                <td><span class="badge-status <?= $h['durum'] ? 'published' : 'draft' ?>"><?= $h['durum'] ? 'Aktif' : 'Pasif' ?></span></td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="hizmetler.php?duzenle=<?= $h['id'] ?>" class="btn-action edit"><i class="bi bi-pencil"></i></a>
                    <a href="hizmetler.php?sil=<?= $h['id'] ?>" class="btn-action delete" onclick="return confirm('Bu hizmeti silmek istediğinize emin misiniz?')"><i class="bi bi-trash"></i></a>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
