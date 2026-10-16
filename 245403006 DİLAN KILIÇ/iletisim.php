<?php
require_once 'config.php';

$mesaj = '';
$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad    = clean($_POST['ad'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $konu  = clean($_POST['konu'] ?? '');
    $mesaj_text = clean($_POST['mesaj'] ?? '');

    if (!$ad || !$email || !$konu || !$mesaj_text) {
        $hata = 'Lütfen tüm alanları doldurun.';
    } elseif (strlen($mesaj_text) < 10) {
        $hata = 'Mesaj en az 10 karakter olmalıdır.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO mesajlar (ad, email, konu, mesaj) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ad, $email, $konu, $mesaj_text]);
        $mesaj = 'Mesajınız başarıyla iletildi. En kısa sürede size geri döneceğiz.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>İletişim | TechNova Yazılım</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="<?= SITE_URL ?>">
      <img src="<?= SITE_URL ?>/assets/img/logo.png" alt="TechNova" class="logo-img">
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>">Ana Sayfa</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hakkimizda.php">Hakkımızda</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hizmetler.php">Hizmetler</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= SITE_URL ?>/iletisim.php">İletişim</a></li>
        <?php if (isLoggedIn()): ?>
        <li class="nav-item"><a class="nav-link btn-nav-cta ms-2" href="<?= SITE_URL ?>/admin/index.php"><i class="bi bi-speedometer2"></i> Panel</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link btn-nav-cta ms-2" href="<?= SITE_URL ?>/giris.php"><i class="bi bi-person"></i> Giriş</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="page-header">
  <div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-3">
      <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Ana Sayfa</a></li>
      <li class="breadcrumb-item active">İletişim</li>
    </ol></nav>
    <h1>İletişim</h1>
    <p>Projeleriniz için bizimle iletişime geçin</p>
  </div>
</div>

<section class="contact-section section-pad">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h2 class="section-title mb-3">Nasıl Yardımcı Olabiliriz?</h2>
        <p style="color:#64748B; margin-bottom:2rem;">Proje fikrinizi bizimle paylaşın, uzman ekibimiz ücretsiz danışmanlık sunsun.</p>

        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="bi bi-geo-alt"></i></div>
          <div>
            <div style="font-weight:600; color:#0F172A;">Adres</div>
            <div style="color:#64748B; font-size:0.9rem;">Levent Mah. Büyükdere Cad. No:85<br>Beşiktaş, İstanbul 34394</div>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="bi bi-telephone"></i></div>
          <div>
            <div style="font-weight:600; color:#0F172A;">Telefon</div>
            <div style="color:#64748B; font-size:0.9rem;">+90 (212) 555 00 11</div>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="bi bi-envelope"></i></div>
          <div>
            <div style="font-weight:600; color:#0F172A;">E-posta</div>
            <div style="color:#64748B; font-size:0.9rem;">info@technova.com.tr</div>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="bi bi-clock"></i></div>
          <div>
            <div style="font-weight:600; color:#0F172A;">Çalışma Saatleri</div>
            <div style="color:#64748B; font-size:0.9rem;">Pazartesi - Cuma: 09:00 - 18:00</div>
          </div>
        </div>

        <div class="social-links mt-3">
          <a href="<?= SOCIAL_INSTAGRAM ?>" aria-label="Instagram" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="<?= SOCIAL_FACEBOOK ?>" aria-label="Facebook" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="<?= SOCIAL_TWITTER ?>" aria-label="Twitter" title="Twitter"><i class="bi bi-twitter"></i></a>
          <a href="<?= SOCIAL_WHATSAPP ?>" aria-label="WhatsApp" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          <a href="<?= SOCIAL_TELEGRAM ?>" aria-label="Telegram" title="Telegram"><i class="bi bi-telegram"></i></a>
          <a href="<?= SOCIAL_LINKEDIN ?>" aria-label="LinkedIn" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="contact-card">
          <h4 style="margin-bottom:1.5rem; font-size:1.2rem;">Mesaj Gönder</h4>
          <?php if ($mesaj): ?><div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?= $mesaj ?></div><?php endif; ?>
          <?php if ($hata): ?><div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>

          <form method="post" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Adınız Soyadınız *</label>
                <input type="text" name="ad" class="form-control" placeholder="Ahmet Yılmaz" required maxlength="100" value="<?= htmlspecialchars($_POST['ad'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">E-posta Adresiniz *</label>
                <input type="email" name="email" class="form-control" placeholder="ahmet@ornek.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Konu *</label>
                <input type="text" name="konu" class="form-control" placeholder="Proje danışmanlığı, fiyat teklifi..." required maxlength="255" value="<?= htmlspecialchars($_POST['konu'] ?? '') ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Mesajınız *</label>
                <textarea name="mesaj" class="form-control" rows="6" placeholder="Projeniz hakkında detaylı bilgi verin..." required maxlength="2000"><?= htmlspecialchars($_POST['mesaj'] ?? '') ?></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-primary-custom btn w-100">
                  <i class="bi bi-send"></i> Mesaj Gönder
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-bottom" style="border-top:1px solid rgba(255,255,255,0.1); padding-top:25px;">
      <span>&copy; <?= date('Y') ?> TechNova Yazılım A.Ş. Tüm hakları saklıdır.</span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
