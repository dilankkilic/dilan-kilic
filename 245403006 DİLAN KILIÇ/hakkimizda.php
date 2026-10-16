<?php require_once 'config.php'; ?>
<?php $about = getAboutContent($pdo); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hakkımızda | TechNova Yazılım</title>
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
        <li class="nav-item"><a class="nav-link active" href="<?= SITE_URL ?>/hakkimizda.php">Hakkımızda</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hizmetler.php">Hizmetler</a></li>
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
      <li class="breadcrumb-item active">Hakkımızda</li>
    </ol></nav>
    <h1>Hakkımızda</h1>
    <p><?= htmlspecialchars($about['alt_baslik'] ?? 'Teknoloji ile geleceği birlikte şekillendiriyoruz') ?></p>
  </div>
</div>

<!-- Firma Tanıtım -->
<section class="section-pad">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <div class="section-badge"><?= htmlspecialchars($about['baslik'] ?? 'TechNova Yazılım') ?></div>
        <h2 class="section-title"><?= htmlspecialchars($about['alt_baslik'] ?? 'Dijital Dönüşümde Deneyim') ?></h2>
        <p style="color:#64748B; font-size:1rem; margin-bottom:1.5rem;"><?= htmlspecialchars($about['aciklama_1'] ?? '') ?></p>
        <p style="color:#64748B; font-size:1rem; margin-bottom:1.5rem;"><?= htmlspecialchars($about['aciklama_2'] ?? '') ?></p>
        <div class="row g-3 mt-2">
          <div class="col-6">
            <div style="background:#F8FAFC; border-radius:12px; padding:1.25rem; text-align:center; border:1px solid #E2E8F0;">
              <div style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:800; color:#1A56DB;"><?= htmlspecialchars(($about['proje_sayisi'] ?? 150) . '+') ?></div>
              <div style="font-size:0.85rem; color:#64748B;">Tamamlanan Proje</div>
            </div>
          </div>
          <div class="col-6">
            <div style="background:#F8FAFC; border-radius:12px; padding:1.25rem; text-align:center; border:1px solid #E2E8F0;">
              <div style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:800; color:#1A56DB;"><?= htmlspecialchars(($about['aktif_musteri'] ?? 50) . '+') ?></div>
              <div style="font-size:0.85rem; color:#64748B;">Aktif Müşteri</div>
            </div>
          </div>
          <div class="col-6">
            <div style="background:#F8FAFC; border-radius:12px; padding:1.25rem; text-align:center; border:1px solid #E2E8F0;">
              <div style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:800; color:#1A56DB;"><?= htmlspecialchars(($about['uzman_ekip'] ?? 25) . '+') ?></div>
              <div style="font-size:0.85rem; color:#64748B;">Uzman Ekip</div>
            </div>
          </div>
          <div class="col-6">
            <div style="background:#F8FAFC; border-radius:12px; padding:1.25rem; text-align:center; border:1px solid #E2E8F0;">
              <div style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:800; color:#1A56DB;"><?= htmlspecialchars($about['memnuniyet'] ?? '98%') ?></div>
              <div style="font-size:0.85rem; color:#64748B;">Müşteri Memnuniyeti</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <!-- Misyon Kartı -->
          <div class="col-12">
            <div style="background:linear-gradient(135deg,#1A56DB 0%,#0F172A 100%); border-radius:16px; padding:2rem; color:white; border:1px solid rgba(6,182,212,0.2); transition:all 0.3s ease; box-shadow:0 10px 30px rgba(26,86,219,0.15);">
              <div style="display:flex; align-items:center; margin-bottom:1rem;">
                <div style="width:50px; height:50px; background:rgba(6,182,212,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-right:1rem;">
                  <i class="bi bi-bullseye" style="color:#06B6D4; font-size:1.5rem;"></i>
                </div>
                <h4 style="color:white; margin:0; font-size:1.25rem; font-weight:700;">Misyonumuz</h4>
              </div>
              <p style="color:rgba(255,255,255,0.85); font-size:0.95rem; line-height:1.6; margin:0;"><?= htmlspecialchars($about['misyon'] ?? '') ?></p>
            </div>
          </div>
          
          <!-- Vizyon Kartı -->
          <div class="col-12">
            <div style="background:linear-gradient(135deg,#06B6D4 0%,#0891B2 100%); border-radius:16px; padding:2rem; color:white; border:1px solid rgba(6,182,212,0.2); transition:all 0.3s ease; box-shadow:0 10px 30px rgba(6,182,212,0.15);">
              <div style="display:flex; align-items:center; margin-bottom:1rem;">
                <div style="width:50px; height:50px; background:rgba(255,255,255,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-right:1rem;">
                  <i class="bi bi-eye" style="color:#ffffff; font-size:1.5rem;"></i>
                </div>
                <h4 style="color:white; margin:0; font-size:1.25rem; font-weight:700;">Vizyonumuz</h4>
              </div>
              <p style="color:rgba(255,255,255,0.85); font-size:0.95rem; line-height:1.6; margin:0;"><?= htmlspecialchars($about['vizyon'] ?? '') ?></p>
            </div>
          </div>
          
          <!-- Değerler Kartı -->
          <div class="col-12">
            <div style="background:linear-gradient(135deg,#8B5CF6 0%,#7C3AED 100%); border-radius:16px; padding:2rem; color:white; border:1px solid rgba(6,182,212,0.2); transition:all 0.3s ease; box-shadow:0 10px 30px rgba(139,92,246,0.15);">
              <div style="display:flex; align-items:center; margin-bottom:1.5rem;">
                <div style="width:50px; height:50px; background:rgba(255,255,255,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-right:1rem;">
                  <i class="bi bi-stars" style="color:#ffffff; font-size:1.5rem;"></i>
                </div>
                <h4 style="color:white; margin:0; font-size:1.25rem; font-weight:700;">Kurumsal Değerlerimiz</h4>
              </div>
              <div style="display:flex; flex-wrap:wrap; gap:0.6rem;">
                <?php 
                  $degerler = $about['degerler'] ?? '';
                  $degerler_array = array_map('trim', explode(',', $degerler));
                  foreach($degerler_array as $val): 
                    if (!empty($val)):
                ?>
                <span style="background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.4); color:white; padding:0.4rem 0.95rem; border-radius:25px; font-size:0.85rem; font-weight:500;"><?= htmlspecialchars($val) ?></span>
                <?php 
                    endif;
                  endforeach; 
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Hedef Kitle -->
<section class="section-pad" style="background:#F8FAFC;">
  <div class="container text-center">
    <div class="section-badge"><?= htmlspecialchars($about['hedef_kitle_baslik'] ?? 'Hedef Kitlemiz') ?></div>
    <h2 class="section-title mb-2">Kimler İçin Çalışıyoruz?</h2>
    <p class="section-sub mx-auto mb-5"><?= htmlspecialchars($about['hedef_kitle_aciklama'] ?? '') ?></p>
    <div class="row g-4 justify-content-center">
      <?php foreach(($about['hedef_kitle_listesi'] ?? []) as $k): ?>
      <div class="col-lg-3 col-md-6">
        <div class="service-card text-center">
          <div class="service-icon mx-auto"><i class="bi <?= htmlspecialchars($k['icon'] ?? 'bi-people') ?>"></i></div>
          <h5><?= htmlspecialchars($k['title'] ?? '') ?></h5>
          <p><?= htmlspecialchars($k['text'] ?? '') ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-bottom" style="border-top:1px solid rgba(255,255,255,0.1); padding-top:25px;">
      <span>&copy; <?= date('Y') ?> TechNova Yazılım A.Ş. Tüm hakları saklıdır.</span>
      <span>"Kodun Ötesinde, Geleceğin İçinde"</span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
