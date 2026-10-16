<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hizmetler | TechNova Yazılım</title>
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
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>">Ana Sayfa</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hakkimizda.php">Hakkımızda</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= SITE_URL ?>/hizmetler.php">Hizmetler</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/iletisim.php">İletişim</a></li>
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
      <li class="breadcrumb-item active">Hizmetler</li>
    </ol></nav>
    <h1>Hizmetlerimiz</h1>
    <p>İşletmeniz için ihtiyaç duyduğunuz tüm teknoloji çözümleri</p>
  </div>
</div>

<section class="services-section section-pad">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-7">
        <div class="section-badge">Teknoloji Çözümleri</div>
        <h2 class="section-title">Ne Yapıyoruz?</h2>
        <p class="section-sub mx-auto">Uzman ekibimiz ile işinizi büyütecek dijital çözümler üretiyoruz.</p>
      </div>
    </div>
    <div class="row g-4">
      <?php
      $stmt = $pdo->query("SELECT * FROM hizmetler WHERE durum=1 ORDER BY sira");
      while($s = $stmt->fetch()):
      ?>
      <div class="col-lg-4 col-md-6">
        <div class="service-card h-100">
          <div class="service-icon"><i class="bi <?= htmlspecialchars($s['icon']) ?>"></i></div>
          <h5><?= htmlspecialchars($s['hizmet_adi']) ?></h5>
          <p><?= htmlspecialchars($s['aciklama']) ?></p>
          <a href="<?= SITE_URL ?>/iletisim.php" class="btn-outline-custom btn btn-sm mt-auto" style="border-radius:25px; font-size:0.85rem; margin-top:1rem !important; display:inline-block;">Teklif Al <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Neden Biz -->
<section class="section-pad" style="background:white;">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-6">
        <div class="section-badge">Neden TechNova?</div>
        <h2 class="section-title">Bizi Tercih Etmenizin Nedenleri</h2>
      </div>
    </div>
    <div class="row g-4">
      <?php
      $nedenler = [
          ['bi-award','Kanıtlanmış Uzmanlık','8+ yıllık sektör deneyimi ve 150+ başarılı proje ile güvenilir bir teknoloji ortağıyız.'],
          ['bi-headset','7/24 Destek','Proje tesliminden sonra da yanınızdayız. Teknik destek ekibimiz her zaman erişilebilir.'],
          ['bi-shield-check','Güvenlik Odaklı','Tüm projelerimizde OWASP standartları ve en iyi güvenlik pratiklerini uyguluyoruz.'],
          ['bi-speedometer','Hızlı Teslimat','Çevik metodoloji ile projelerinizi zamanında, bütçe dahilinde teslim ediyoruz.'],
      ];
      foreach($nedenler as $n): ?>
      <div class="col-lg-3 col-md-6">
        <div style="text-align:center; padding:1.5rem;">
          <div style="width:65px; height:65px; background:linear-gradient(135deg,rgba(26,86,219,0.1),rgba(6,182,212,0.1)); border-radius:18px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; color:#1A56DB; margin:0 auto 1.25rem;">
            <i class="bi <?= $n[0] ?>"></i>
          </div>
          <h5 style="margin-bottom:0.75rem;"><?= $n[1] ?></h5>
          <p style="color:#64748B; font-size:0.9rem;"><?= $n[2] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section-pad" style="background:linear-gradient(135deg,#0F172A,#1e3a5f);">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <h2 style="color:white; margin-bottom:1rem;">Projenizi Konuşalım</h2>
        <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">Ücretsiz ön değerlendirme için bugün iletişime geçin.</p>
        <a href="<?= SITE_URL ?>/iletisim.php" class="btn-hero-primary" style="font-size:1rem; padding:1rem 2.5rem;">
          <i class="bi bi-send"></i> İletişime Geç
        </a>
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
