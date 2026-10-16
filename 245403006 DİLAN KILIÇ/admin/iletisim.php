<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';
$settings = getSiteSettings($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefon = clean($_POST['telefon'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $adres = clean($_POST['adres'] ?? '');
    $calisma = clean($_POST['calisma_saatleri'] ?? '');
    $maps = trim($_POST['google_maps_src'] ?? '');
  $hero_badge = clean($_POST['hero_badge'] ?? '');
  $hero_title_line1 = clean($_POST['hero_title_line1'] ?? '');
  $hero_title_highlight = clean($_POST['hero_title_highlight'] ?? '');
  $hero_title_line3 = clean($_POST['hero_title_line3'] ?? '');
  $hero_desc = clean($_POST['hero_desc'] ?? '');
  $hero_cta_1_text = clean($_POST['hero_cta_1_text'] ?? '');
  $hero_cta_2_text = clean($_POST['hero_cta_2_text'] ?? '');
  $hero_stat1_num = clean($_POST['hero_stat1_num'] ?? '');
  $hero_stat1_label = clean($_POST['hero_stat1_label'] ?? '');
  $hero_stat2_num = clean($_POST['hero_stat2_num'] ?? '');
  $hero_stat2_label = clean($_POST['hero_stat2_label'] ?? '');
  $hero_stat3_num = clean($_POST['hero_stat3_num'] ?? '');
  $hero_stat3_label = clean($_POST['hero_stat3_label'] ?? '');

    if (!$telefon || !$email || !$adres) {
        $hata = 'Telefon, e-posta ve adres alanları zorunludur.';
    } else {
        $stmt = $pdo->prepare("UPDATE site_ayarlar SET telefon=?, email=?, adres=?, calisma_saatleri=?, google_maps_src=?, hero_badge=?, hero_title_line1=?, hero_title_highlight=?, hero_title_line3=?, hero_desc=?, hero_cta_1_text=?, hero_cta_2_text=?, hero_stat1_num=?, hero_stat1_label=?, hero_stat2_num=?, hero_stat2_label=?, hero_stat3_num=?, hero_stat3_label=? WHERE id=(SELECT id FROM site_ayarlar ORDER BY id ASC LIMIT 1)");
        $stmt->execute([$telefon, $email, $adres, $calisma, $maps, $hero_badge, $hero_title_line1, $hero_title_highlight, $hero_title_line3, $hero_desc, $hero_cta_1_text, $hero_cta_2_text, $hero_stat1_num, $hero_stat1_label, $hero_stat2_num, $hero_stat2_label, $hero_stat3_num, $hero_stat3_label]);
        $basari = 'İletişim bilgileri güncellendi.';
        $settings = getSiteSettings($pdo);
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>İletişim Ayarları | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
    <span style="font-weight:600; color:#0F172A;">İletişim Ayarları</span>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><?= $hata ?></div><?php endif; ?>
    <?php if ($basari): ?><div class="alert alert-success mb-3"><?= $basari ?></div><?php endif; ?>

    <form method="post">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="form-card mb-4">
            <div class="card-title">Genel Bilgiler</div>
            <div class="mb-3">
              <label class="form-label">Telefon</label>
              <input type="text" name="telefon" class="form-control" required value="<?= htmlspecialchars($settings['telefon'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">E-posta</label>
              <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($settings['email'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Adres</label>
              <textarea name="adres" class="form-control" rows="4" required><?= htmlspecialchars($settings['adres'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Çalışma Saatleri</label>
              <input type="text" name="calisma_saatleri" class="form-control" value="<?= htmlspecialchars($settings['calisma_saatleri'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Google Maps iFrame src (opsiyonel)</label>
              <textarea name="google_maps_src" class="form-control" rows="4"><?= htmlspecialchars($settings['google_maps_src'] ?? '') ?></textarea>
            </div>
            <hr>
            <div class="mb-3">
              <label class="form-label">Hero Badge (üst küçük yazı)</label>
              <input type="text" name="hero_badge" class="form-control" value="<?= htmlspecialchars($settings['hero_badge'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Başlık - Satır 1</label>
              <input type="text" name="hero_title_line1" class="form-control" value="<?= htmlspecialchars($settings['hero_title_line1'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Başlık - Vurgulu Satır</label>
              <input type="text" name="hero_title_highlight" class="form-control" value="<?= htmlspecialchars($settings['hero_title_highlight'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Başlık - Satır 3</label>
              <input type="text" name="hero_title_line3" class="form-control" value="<?= htmlspecialchars($settings['hero_title_line3'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Açıklama</label>
              <textarea name="hero_desc" class="form-control" rows="3"><?= htmlspecialchars($settings['hero_desc'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">CTA 1 Metni</label>
              <input type="text" name="hero_cta_1_text" class="form-control" value="<?= htmlspecialchars($settings['hero_cta_1_text'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">CTA 2 Metni</label>
              <input type="text" name="hero_cta_2_text" class="form-control" value="<?= htmlspecialchars($settings['hero_cta_2_text'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 1 (num)</label>
              <input type="text" name="hero_stat1_num" class="form-control" value="<?= htmlspecialchars($settings['hero_stat1_num'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 1 (label)</label>
              <input type="text" name="hero_stat1_label" class="form-control" value="<?= htmlspecialchars($settings['hero_stat1_label'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 2 (num)</label>
              <input type="text" name="hero_stat2_num" class="form-control" value="<?= htmlspecialchars($settings['hero_stat2_num'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 2 (label)</label>
              <input type="text" name="hero_stat2_label" class="form-control" value="<?= htmlspecialchars($settings['hero_stat2_label'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 3 (num)</label>
              <input type="text" name="hero_stat3_num" class="form-control" value="<?= htmlspecialchars($settings['hero_stat3_num'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Hero Stat 3 (label)</label>
              <input type="text" name="hero_stat3_label" class="form-control" value="<?= htmlspecialchars($settings['hero_stat3_label'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; padding:0.85rem; font-weight:600;">Kaydet</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
