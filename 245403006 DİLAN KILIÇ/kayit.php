<?php
require_once 'config.php';

$hata = '';
$basari = '';

if (isLoggedIn()) { redirect('/'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad     = clean($_POST['ad'] ?? '');
    $soyad  = clean($_POST['soyad'] ?? '');
    $email  = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $sifre  = $_POST['sifre'] ?? '';
    $sifre2 = $_POST['sifre2'] ?? '';

    if (!$ad || !$soyad || !$email || !$sifre) {
        $hata = 'Tüm alanları doldurun.';
    } elseif (strlen($sifre) < 8) {
        $hata = 'Şifre en az 8 karakter olmalıdır.';
    } elseif ($sifre !== $sifre2) {
        $hata = 'Şifreler eşleşmiyor.';
    } else {
        $check = $pdo->prepare("SELECT id FROM kullanicilar WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $hata = 'Bu e-posta adresi zaten kayıtlı.';
        } else {
            $hash = password_hash($sifre, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO kullanicilar (ad, soyad, email, sifre, rol) VALUES (?, ?, ?, ?, 'kullanici')");
            $stmt->execute([$ad, $soyad, $email, $hash]);
            $basari = 'Kaydınız oluşturuldu. <a href="giris.php">Giriş yapın</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kayıt Ol | TechNova</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-section">
  <div class="auth-card" style="max-width:480px;">
    <div class="auth-logo">
      <div class="brand-icon"><i class="bi bi-cpu"></i></div>
      <div style="font-family:'Poppins',sans-serif; font-weight:800; font-size:1.4rem; color:#0F172A;">TechNova</div>
      <div style="color:#64748B; font-size:0.88rem;">Yeni hesap oluşturun</div>
    </div>

    <?php if ($hata): ?><div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>
    <?php if ($basari): ?><div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?= $basari ?></div><?php endif; ?>

    <form method="post">
      <div class="row g-3">
        <div class="col-6">
          <label class="form-label">Ad *</label>
          <input type="text" name="ad" class="form-control" placeholder="Ahmet" required maxlength="100" value="<?= htmlspecialchars($_POST['ad'] ?? '') ?>">
        </div>
        <div class="col-6">
          <label class="form-label">Soyad *</label>
          <input type="text" name="soyad" class="form-control" placeholder="Yılmaz" required maxlength="100" value="<?= htmlspecialchars($_POST['soyad'] ?? '') ?>">
        </div>
        <div class="col-12">
          <label class="form-label">E-posta *</label>
          <input type="email" name="email" class="form-control" placeholder="ahmet@ornek.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="col-12">
          <label class="form-label">Şifre * <small style="color:#94A3B8;">(En az 8 karakter)</small></label>
          <input type="password" name="sifre" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="col-12">
          <label class="form-label">Şifre Tekrar *</label>
          <input type="password" name="sifre2" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="col-12">
          <button type="submit" class="btn-primary-custom btn w-100">
            <i class="bi bi-person-plus"></i> Kayıt Ol
          </button>
        </div>
      </div>
    </form>

    <div class="text-center mt-3" style="font-size:0.88rem;">
      Zaten hesabınız var mı? <a href="<?= SITE_URL ?>/giris.php">Giriş Yap</a>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
