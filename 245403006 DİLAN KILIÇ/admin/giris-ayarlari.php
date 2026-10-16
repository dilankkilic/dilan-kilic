<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';
$login_ayar = null;

// Mevcut ayarları çek
$stmt = $pdo->query("SELECT * FROM login_ayarlar LIMIT 1");
$login_ayar = $stmt->fetch();

// Eğer yoksa varsayılan oluştur
if (!$login_ayar) {
    $pdo->exec("INSERT INTO login_ayarlar (baslik, alt_baslik) VALUES ('Giriş Yap', 'Hesabınıza giriş yapın')");
    $stmt = $pdo->query("SELECT * FROM login_ayarlar LIMIT 1");
    $login_ayar = $stmt->fetch();
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = clean($_POST['baslik'] ?? '');
    $alt_baslik = clean($_POST['alt_baslik'] ?? '');
    $arka_renk = clean($_POST['arka_renk'] ?? '#0F172A');
    $form_arka_renk = clean($_POST['form_arka_renk'] ?? '#FFFFFF');
    $button_renk = clean($_POST['button_renk'] ?? '#1A56DB');
    $button_hover_renk = clean($_POST['button_hover_renk'] ?? '#1E40AF');
    $metin_renk = clean($_POST['metin_renk'] ?? '#0F172A');
    $etiket_renk = clean($_POST['etiket_renk'] ?? '#64748B');
    $logo_url = clean($_POST['logo_url'] ?? 'assets/img/logo.png');

    if (!$baslik || !$alt_baslik) {
        $hata = 'Başlık ve alt başlık alanları zorunludur.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE login_ayarlar SET baslik=?, alt_baslik=?, arka_renk=?, form_arka_renk=?, button_renk=?, button_hover_renk=?, metin_renk=?, etiket_renk=?, logo_url=? WHERE id=1");
            $stmt->execute([
                $baslik,
                $alt_baslik,
                $arka_renk,
                $form_arka_renk,
                $button_renk,
                $button_hover_renk,
                $metin_renk,
                $etiket_renk,
                $logo_url
            ]);
            $basari = 'Giriş sayfası ayarları güncellendi! Lütfen giriş sayfasını yenileyiniz.';
            $stmt = $pdo->query("SELECT * FROM login_ayarlar LIMIT 1");
            $login_ayar = $stmt->fetch();
        } catch (Exception $e) {
            $hata = 'Hata: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giriş Sayfası Ayarları | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/giris-ayarlari.php" class="sidebar-link active"><i class="bi bi-door-open"></i> Giriş Sayfası</a>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>
    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<div class="admin-main">
  <div class="admin-topbar">
    <span style="font-weight:600; color:#0F172A;">Giriş Sayfası Ayarları</span>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>
    <?php if ($basari): ?><div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i><?= $basari ?></div><?php endif; ?>

    <div class="row g-4">
      <!-- Form Bölümü -->
      <div class="col-lg-8">
        <form method="post">
          <div class="form-card mb-4">
            <div class="card-title">Metin İçeriği</div>
            <div class="mb-3">
              <label class="form-label">Başlık</label>
              <input type="text" name="baslik" class="form-control" value="<?= htmlspecialchars($login_ayar['baslik'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Alt Başlık</label>
              <input type="text" name="alt_baslik" class="form-control" value="<?= htmlspecialchars($login_ayar['alt_baslik'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Logo URL</label>
              <input type="text" name="logo_url" class="form-control" value="<?= htmlspecialchars($login_ayar['logo_url'] ?? '') ?>" required>
            </div>
          </div>

          <div class="form-card mb-4">
            <div class="card-title">Renkler</div>
            <div class="mb-3">
              <label class="form-label">Arka Plan Rengi</label>
              <div class="input-group">
                <input type="color" name="arka_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['arka_renk'] ?? '#0F172A') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['arka_renk'] ?? '#0F172A') ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Form Arka Plan Rengi</label>
              <div class="input-group">
                <input type="color" name="form_arka_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Buton Rengi</label>
              <div class="input-group">
                <input type="color" name="button_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Buton Hover Rengi</label>
              <div class="input-group">
                <input type="color" name="button_hover_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['button_hover_renk'] ?? '#1E40AF') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['button_hover_renk'] ?? '#1E40AF') ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Metin Rengi</label>
              <div class="input-group">
                <input type="color" name="metin_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>" readonly>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Etiket/Placeholder Rengi</label>
              <div class="input-group">
                <input type="color" name="etiket_renk" class="form-control form-control-color" value="<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>" style="width:80px;">
                <input type="text" class="form-control" value="<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>" readonly>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; padding:0.85rem; font-weight:600;">
            <i class="bi bi-check-lg me-2"></i>Kaydet
          </button>
        </form>
      </div>

      <!-- Önizleme Bölümü -->
      <div class="col-lg-4">
        <div class="form-card" style="position:sticky; top:20px;">
          <div class="card-title">Önizleme</div>
          <div style="background:<?= htmlspecialchars($login_ayar['arka_renk'] ?? '#0F172A') ?>; border-radius:16px; padding:2rem; min-height:500px; display:flex; flex-direction:column; justify-content:center; align-items:center;">
            <div style="text-align:center; width:100%;">
              <div style="margin:0 auto 1rem; display:flex; align-items:center; justify-content:center;">
                <img src="<?= htmlspecialchars($login_ayar['logo_url'] ?? 'assets/img/logo.png') ?>" alt="TechNova" style="max-width:120px; height:auto;">
              </div>
              <div style="color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>; font-size:0.88rem;"><?= htmlspecialchars($login_ayar['alt_baslik'] ?? '') ?></div>
              
              <div style="margin-top:2rem;">
                <div style="margin-bottom:1rem; text-align:left;">
                  <label style="color:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; font-size:0.85rem; font-weight:500; display:block; margin-bottom:0.5rem;">E-posta</label>
                  <input type="email" placeholder="admin@technova.com.tr" style="width:100%; border:none; border-radius:8px; padding:0.6rem 0.8rem; font-size:0.9rem; background:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>;border:1px solid #E2E8F0;" readonly>
                </div>
                <div style="margin-bottom:1.5rem; text-align:left;">
                  <label style="color:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; font-size:0.85rem; font-weight:500; display:block; margin-bottom:0.5rem;">Şifre</label>
                  <input type="password" placeholder="••••••••" style="width:100%; border:none; border-radius:8px; padding:0.6rem 0.8rem; font-size:0.9rem; background:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>;border:1px solid #E2E8F0;" readonly>
                </div>
                <button type="button" style="width:100%; background:<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>; color:white; border:none; border-radius:8px; padding:0.7rem; font-weight:600; cursor:pointer;">Giriş Yap</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
