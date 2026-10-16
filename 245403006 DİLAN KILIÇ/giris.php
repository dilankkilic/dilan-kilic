<?php
require_once 'config.php';

$hata = '';

// Giriş sayfası ayarlarını çek
$login_ayar = null;
try {
    $stmt = $pdo->query("SELECT * FROM login_ayarlar LIMIT 1");
    $login_ayar = $stmt->fetch();
} catch (Exception $e) {
    // Tablo yoksa varsayılan değerleri kullan
    $login_ayar = [
        'baslik' => 'Giriş Yap',
        'alt_baslik' => 'Hesabınıza giriş yapın',
        'arka_renk' => '#0F172A',
        'form_arka_renk' => '#FFFFFF',
        'button_renk' => '#1A56DB',
        'button_hover_renk' => '#1E40AF',
        'metin_renk' => '#0F172A',
        'etiket_renk' => '#64748B',
        'logo_url' => 'assets/img/logo.png'
    ];
}

if (isLoggedIn()) { redirect('/admin/index.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $sifre = $_POST['sifre'] ?? '';

    if (!$email || !$sifre) {
        $hata = 'E-posta ve şifre alanları zorunludur.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $kullanici = $stmt->fetch();

        if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['ad']           = $kullanici['ad'];
            $_SESSION['soyad']        = $kullanici['soyad'];
            $_SESSION['email']        = $kullanici['email'];
            $_SESSION['rol']          = $kullanici['rol'];
            session_regenerate_id(true);

            if ($kullanici['rol'] === 'admin') {
                redirect('/admin/index.php');
            } else {
                redirect('/');
            }
        } else {
            $hata = 'E-posta veya şifre hatalı.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giriş Yap | TechNova</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body style="background:<?= htmlspecialchars($login_ayar['arka_renk'] ?? '#0F172A') ?>; min-height:100vh; display:flex; align-items:center; justify-content:center;">
<div class="auth-section" style="background:transparent;">
  <div class="auth-card" style="background:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>;">
    <div class="auth-logo" style="text-align:center;">
      <div style="margin-bottom:1rem;"><img src="<?= SITE_URL ?>/<?= htmlspecialchars($login_ayar['logo_url'] ?? 'assets/img/logo.png') ?>" alt="TechNova" style="max-width:120px; height:auto;"></div>
      <div style="color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>; font-size:0.88rem;"><?= htmlspecialchars($login_ayar['alt_baslik'] ?? 'Hesabınıza giriş yapın') ?></div>
    </div>

    <?php if ($hata): ?>
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label" style="color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>; font-weight:500;">E-posta</label>
        <div class="input-group">
          <span class="input-group-text" style="background:#F8FAFC; border-radius:10px 0 0 10px;"><i class="bi bi-envelope" style="color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>;"></i></span>
          <input type="email" name="email" class="form-control" style="border-left:none; border-radius:0 10px 10px 0; background:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>;" placeholder="admin@technova.com.tr" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label" style="color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>; font-weight:500;">Şifre</label>
        <div class="input-group">
          <span class="input-group-text" style="background:#F8FAFC; border-radius:10px 0 0 10px;"><i class="bi bi-lock" style="color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>;"></i></span>
          <input type="password" name="sifre" id="sifre" class="form-control" style="border-left:none; border-radius:0 10px 10px 0; background:<?= htmlspecialchars($login_ayar['form_arka_renk'] ?? '#FFFFFF') ?>; color:<?= htmlspecialchars($login_ayar['metin_renk'] ?? '#0F172A') ?>;" placeholder="••••••••" required>
          <span class="input-group-text" style="cursor:pointer; background:#F8FAFC; border-radius:0 10px 10px 0; border-left:none;" onclick="togglePwd()"><i class="bi bi-eye" id="eyeIcon" style="color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>;"></i></span>
        </div>
      </div>
      <button type="submit" class="btn w-100" style="background:<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>; color:white; border:none; border-radius:10px; padding:0.85rem; font-weight:600; cursor:pointer; transition:background 0.3s ease;" onmouseover="this.style.background='<?= htmlspecialchars($login_ayar['button_hover_renk'] ?? '#1E40AF') ?>'" onmouseout="this.style.background='<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>'">
        <i class="bi bi-box-arrow-in-right"></i> Giriş Yap
      </button>
    </form>

    <div class="text-center mt-3" style="font-size:0.88rem;">
      Hesabınız yok mu? <a href="<?= SITE_URL ?>/kayit.php" style="color:<?= htmlspecialchars($login_ayar['button_renk'] ?? '#1A56DB') ?>;">Kayıt Ol</a>
    </div>
    <div class="text-center mt-2">
      <a href="<?= SITE_URL ?>" style="font-size:0.85rem; color:<?= htmlspecialchars($login_ayar['etiket_renk'] ?? '#64748B') ?>;"><i class="bi bi-arrow-left me-1"></i>Ana Sayfaya Dön</a>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
    const f = document.getElementById('sifre');
    const e = document.getElementById('eyeIcon');
    f.type = f.type === 'password' ? 'text' : 'password';
    e.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
