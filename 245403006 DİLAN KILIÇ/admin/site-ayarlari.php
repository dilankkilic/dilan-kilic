<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';

// Mevcut ayarları çek
$stmt = $pdo->query("SELECT * FROM site_ayarlar LIMIT 1");
$site_ayar = $stmt->fetch();

if (!$site_ayar) {
    $pdo->exec("INSERT INTO site_ayarlar (menu_blog, menu_hizmetler, menu_hakkimizda, menu_iletisim, menu_giris) VALUES (1, 1, 1, 1, 1)");
    $stmt = $pdo->query("SELECT * FROM site_ayarlar LIMIT 1");
    $site_ayar = $stmt->fetch();
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_blog = isset($_POST['menu_blog']) ? 1 : 0;
    $menu_hizmetler = isset($_POST['menu_hizmetler']) ? 1 : 0;
    $menu_hakkimizda = isset($_POST['menu_hakkimizda']) ? 1 : 0;
    $menu_iletisim = isset($_POST['menu_iletisim']) ? 1 : 0;
    $menu_giris = isset($_POST['menu_giris']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE site_ayarlar SET menu_blog=?, menu_hizmetler=?, menu_hakkimizda=?, menu_iletisim=?, menu_giris=? WHERE id=1");
        $stmt->execute([
            $menu_blog,
            $menu_hizmetler,
            $menu_hakkimizda,
            $menu_iletisim,
            $menu_giris
        ]);
        $basari = 'Site menü ayarları güncellendi!';
        $stmt = $pdo->query("SELECT * FROM site_ayarlar LIMIT 1");
        $site_ayar = $stmt->fetch();
    } catch (Exception $e) {
        $hata = 'Hata: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Site Ayarları | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/admin.css" rel="stylesheet">
<style>
.menu-switch {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    background: #F8FAFC;
    border-radius: 10px;
    margin-bottom: 1rem;
    border-left: 4px solid #1A56DB;
}
.menu-switch.disabled {
    border-left-color: #94A3B8;
    opacity: 0.7;
}
.menu-switch label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
    cursor: pointer;
    font-weight: 500;
    color: #0F172A;
}
.menu-switch input[type="checkbox"] {
    width: 50px;
    height: 28px;
    cursor: pointer;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
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
    <a href="<?= SITE_URL ?>/admin/giris-ayarlari.php" class="sidebar-link"><i class="bi bi-door-open"></i> Giriş Sayfası</a>
    <a href="<?= SITE_URL ?>/admin/site-ayarlari.php" class="sidebar-link active"><i class="bi bi-toggles2"></i> Site Ayarları</a>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>

    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<!-- MAIN -->
<div class="admin-main">
  <div class="admin-topbar">
    <span style="font-weight:600; color:#0F172A;">Site Ayarları</span>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>
    <?php if ($basari): ?><div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i><?= $basari ?></div><?php endif; ?>

    <div class="row">
      <div class="col-lg-8">
        <div style="background:white; padding:2rem; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.08);">
          <h5 style="margin-bottom:1.5rem; color:#0F172A; font-weight:700;"><i class="bi bi-menu-button-wide me-2" style="color:#1A56DB;"></i>Menü Görünürlüğü</h5>
          
          <p style="color:#64748B; font-size:0.9rem; margin-bottom:2rem;">Sitenizde hangi menülerin görünür olacağını burada kontrol edebilirsiniz.</p>

          <form method="post">
            <!-- Blog Yazıları Menüsü -->
            <div class="menu-switch <?= !$site_ayar['menu_blog'] ? 'disabled' : '' ?>">
              <label for="menu_blog">
                <i class="bi bi-journal-text" style="font-size:1.2rem; color:#1A56DB;"></i>
                <div>
                  <div style="font-weight:600; color:#0F172A;">Blog Yazıları</div>
                  <div style="font-size:0.75rem; color:#94A3B8; font-weight:400;">Blog yazılarını sitenizde göster/gizle</div>
                </div>
              </label>
              <input type="checkbox" id="menu_blog" name="menu_blog" class="form-check-input" <?= $site_ayar['menu_blog'] ? 'checked' : '' ?>>
            </div>

            <!-- Hizmetler Menüsü -->
            <div class="menu-switch <?= !$site_ayar['menu_hizmetler'] ? 'disabled' : '' ?>">
              <label for="menu_hizmetler">
                <i class="bi bi-gear" style="font-size:1.2rem; color:#06B6D4;"></i>
                <div>
                  <div style="font-weight:600; color:#0F172A;">Hizmetler</div>
                  <div style="font-size:0.75rem; color:#94A3B8; font-weight:400;">Hizmet listesini sitenizde göster/gizle</div>
                </div>
              </label>
              <input type="checkbox" id="menu_hizmetler" name="menu_hizmetler" class="form-check-input" <?= $site_ayar['menu_hizmetler'] ? 'checked' : '' ?>>
            </div>

            <!-- Hakkımızda Menüsü -->
            <div class="menu-switch <?= !$site_ayar['menu_hakkimizda'] ? 'disabled' : '' ?>">
              <label for="menu_hakkimizda">
                <i class="bi bi-info-circle" style="font-size:1.2rem; color:#8B5CF6;"></i>
                <div>
                  <div style="font-weight:600; color:#0F172A;">Hakkımızda</div>
                  <div style="font-size:0.75rem; color:#94A3B8; font-weight:400;">Hakkımızda sayfasını sitenizde göster/gizle</div>
                </div>
              </label>
              <input type="checkbox" id="menu_hakkimizda" name="menu_hakkimizda" class="form-check-input" <?= $site_ayar['menu_hakkimizda'] ? 'checked' : '' ?>>
            </div>

            <!-- İletişim Menüsü -->
            <div class="menu-switch <?= !$site_ayar['menu_iletisim'] ? 'disabled' : '' ?>">
              <label for="menu_iletisim">
                <i class="bi bi-telephone" style="font-size:1.2rem; color:#EC4899;"></i>
                <div>
                  <div style="font-weight:600; color:#0F172A;">İletişim</div>
                  <div style="font-size:0.75rem; color:#94A3B8; font-weight:400;">İletişim formunu sitenizde göster/gizle</div>
                </div>
              </label>
              <input type="checkbox" id="menu_iletisim" name="menu_iletisim" class="form-check-input" <?= $site_ayar['menu_iletisim'] ? 'checked' : '' ?>>
            </div>

            <!-- Giriş Menüsü -->
            <div class="menu-switch <?= !$site_ayar['menu_giris'] ? 'disabled' : '' ?>">
              <label for="menu_giris">
                <i class="bi bi-door-open" style="font-size:1.2rem; color:#F59E0B;"></i>
                <div>
                  <div style="font-weight:600; color:#0F172A;">Giriş (Kayıt Ol)</div>
                  <div style="font-size:0.75rem; color:#94A3B8; font-weight:400;">Giriş ve kayıt bağlantılarını sitenizde göster/gizle</div>
                </div>
              </label>
              <input type="checkbox" id="menu_giris" name="menu_giris" class="form-check-input" <?= $site_ayar['menu_giris'] ? 'checked' : '' ?>>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4" style="border-radius:10px; padding:0.85rem; font-weight:600;">
              <i class="bi bi-check-lg me-2"></i>Kaydet
            </button>
          </form>
        </div>
      </div>

      <!-- Bilgi Kartı -->
      <div class="col-lg-4">
        <div style="background:linear-gradient(135deg,#667EEA 0%,#764BA2 100%); color:white; padding:1.5rem; border-radius:12px;">
          <h6 style="margin-bottom:1rem;"><i class="bi bi-info-circle me-2"></i>Bilgi</h6>
          <p style="font-size:0.9rem; margin-bottom:1rem;">
            <strong>Gizli menüler</strong>, sitenizin menü barında görünmez, fakat doğrudan URL'den erişilebilir.
          </p>
          <p style="font-size:0.9rem; margin-bottom:1rem;">
            <strong>Açık menüler</strong>, sitenizin menü barında görünen tüm ziyaretçilere sunulur.
          </p>
          <hr style="border-color:rgba(255,255,255,0.3);">
          <p style="font-size:0.85rem; margin:0;">
            💡 Değişiklikleri kaydettiğinizde sitede anında yansır.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
