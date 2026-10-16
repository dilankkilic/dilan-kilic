<?php 
require_once 'config.php'; 
$site_ayar = $pdo->query("SELECT * FROM site_ayarlar LIMIT 1")->fetch();
?>
<?php $about = getAboutContent($pdo); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TechNova Yazılım | Dijital Dönüşümde Güvenilir Ortağınız</title>
<meta name="description" content="TechNova Yazılım - Web, Mobil, Siber Güvenlik ve Bulut çözümleriyle işletmenizi dijital dünyaya taşıyoruz.">
<link rel="canonical" href="<?= SITE_URL ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="TechNova Yazılım | Dijital Dönüşümde Güvenilir Ortağınız">
<meta property="og:description" content="Web, Mobil, Siber Güvenlik ve Bulut çözümleriyle işletmenizi dijital dünyaya taşıyoruz.">
<meta property="og:url" content="<?= SITE_URL ?>">
<meta property="og:image" content="<?= SITE_URL ?>/assets/img/logo.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="TechNova Yazılım | Dijital Dönüşümde Güvenilir Ortağınız">
<meta name="twitter:description" content="Web, Mobil, Siber Güvenlik ve Bulut çözümleriyle işletmenizi dijital dünyaya taşıyoruz.">
<meta name="twitter:image" content="<?= SITE_URL ?>/assets/img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= SITE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
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
        <li class="nav-item"><a class="nav-link active" href="<?= SITE_URL ?>">Ana Sayfa</a></li>
        <?php if ($site_ayar['menu_hakkimizda']): ?><li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hakkimizda.php">Hakkımızda</a></li><?php endif; ?>
        <?php if ($site_ayar['menu_hizmetler']): ?><li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/hizmetler.php">Hizmetler</a></li><?php endif; ?>
        <?php if ($site_ayar['menu_blog']): ?><li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/blog.php">Blog</a></li><?php endif; ?>
        <?php if ($site_ayar['menu_iletisim']): ?><li class="nav-item"><a class="nav-link" href="<?= SITE_URL ?>/iletisim.php">İletişim</a></li><?php endif; ?>
        <?php if (isLoggedIn()): ?>
        <li class="nav-item"><a class="nav-link btn-nav-cta ms-2" href="<?= SITE_URL ?>/admin/index.php"><i class="bi bi-speedometer2"></i> Panel</a></li>
        <?php elseif ($site_ayar['menu_giris']): ?>
        <li class="nav-item"><a class="nav-link btn-nav-cta ms-2" href="<?= SITE_URL ?>/giris.php"><i class="bi bi-person"></i> Giriş</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero-section">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6 hero-content">
        <div class="hero-badge"><i class="bi bi-stars"></i> Türkiye'nin Öncü Yazılım Şirketi</div>
        <h1 class="hero-title">
          Dijital Geleceği<br>
          <span class="highlight">Birlikte İnşa</span><br>
          Ediyoruz
        </h1>
        <div style="background: linear-gradient(90deg, #06B6D4, #fbbf24, #06B6D4); background-size: 200% 100%; animation: gradientShift 3s ease infinite; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 1.4rem; font-weight: 700; font-style: italic; margin: 1.5rem 0; letter-spacing: 1px; text-align: left;">
          💡 "Kodun Ötesinde, Geleceğin İçinde"
        </div>
        <style>
          @keyframes gradientShift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
          }
        </style>
        <p class="hero-desc">Web, Mobil, Siber Güvenlik ve Bulut çözümleriyle işletmenizi dijital dünyaya taşıyoruz. Yenilikçi teknoloji, güvenilir partnerlik.</p>
        <div class="hero-btns">
          <?php if ($site_ayar['menu_hizmetler']): ?><a href="<?= SITE_URL ?>/hizmetler.php" class="btn-hero-primary"><i class="bi bi-arrow-right-circle"></i> Hizmetlerimiz</a><?php endif; ?>
          <?php if ($site_ayar['menu_iletisim']): ?><a href="<?= SITE_URL ?>/iletisim.php" class="btn-hero-secondary"><i class="bi bi-chat-dots"></i> Bizimle İletişime Geç</a><?php endif; ?>
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <div class="number">150+</div>
            <div class="label">Tamamlanan Proje</div>
          </div>
          <div class="hero-stat">
            <div class="number">8+</div>
            <div class="label">Yıllık Deneyim</div>
          </div>
          <div class="hero-stat">
            <div class="number">98%</div>
            <div class="label">Müşteri Memnuniyeti</div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 hero-image-wrap">
        <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">
            <?php
            $stmt = $pdo->query("SELECT * FROM hizmetler WHERE durum=1 ORDER BY sira");
            $services = $stmt->fetchAll();
            $activeSet = 0;
            
            for ($i = 0; $i < count($services); $i += 2):
              $activeClass = ($activeSet === 0) ? 'active' : '';
              $activeSet++;
            ?>
            <div class="carousel-item <?= $activeClass ?>">
              <div class="row g-3">
                <div class="col-6">
                  <a href="<?= SITE_URL ?>/hizmetler.php" style="text-decoration:none; cursor:pointer;">
                    <div style="background:linear-gradient(135deg, rgba(6,182,212,0.15) 0%, rgba(6,182,212,0.05) 100%); border:1px solid rgba(6,182,212,0.2); border-radius:12px; padding:1.5rem; text-align:center; transition:all 0.3s; hover-effect:true;"
                         onmouseover="this.style.background='linear-gradient(135deg, rgba(6,182,212,0.25) 0%, rgba(6,182,212,0.1) 100%)'; this.style.borderColor='rgba(6,182,212,0.5)'; this.style.transform='translateY(-5px)';"
                         onmouseout="this.style.background='linear-gradient(135deg, rgba(6,182,212,0.15) 0%, rgba(6,182,212,0.05) 100%)'; this.style.borderColor='rgba(6,182,212,0.2)'; this.style.transform='translateY(0)';">
                      <i class="bi <?= htmlspecialchars($services[$i]['icon']) ?>" style="font-size:2.5rem; color:#06B6D4; display:block; margin-bottom:0.75rem;"></i>
                      <div style="font-size:0.95rem; color:rgba(255,255,255,0.9); font-weight:700; letter-spacing:0.5px;"><?= htmlspecialchars($services[$i]['hizmet_adi']) ?></div>
                    </div>
                  </a>
                </div>
                <?php if (isset($services[$i+1])): ?>
                <div class="col-6">
                  <a href="<?= SITE_URL ?>/hizmetler.php" style="text-decoration:none; cursor:pointer;">
                    <div style="background:linear-gradient(135deg, rgba(6,182,212,0.15) 0%, rgba(6,182,212,0.05) 100%); border:1px solid rgba(6,182,212,0.2); border-radius:12px; padding:1.5rem; text-align:center; transition:all 0.3s; hover-effect:true;"
                         onmouseover="this.style.background='linear-gradient(135deg, rgba(6,182,212,0.25) 0%, rgba(6,182,212,0.1) 100%)'; this.style.borderColor='rgba(6,182,212,0.5)'; this.style.transform='translateY(-5px)';"
                         onmouseout="this.style.background='linear-gradient(135deg, rgba(6,182,212,0.15) 0%, rgba(6,182,212,0.05) 100%)'; this.style.borderColor='rgba(6,182,212,0.2)'; this.style.transform='translateY(0)';">
                      <i class="bi <?= htmlspecialchars($services[$i+1]['icon']) ?>" style="font-size:2.5rem; color:#06B6D4; display:block; margin-bottom:0.75rem;"></i>
                      <div style="font-size:0.95rem; color:rgba(255,255,255,0.9); font-weight:700; letter-spacing:0.5px;"><?= htmlspecialchars($services[$i+1]['hizmet_adi']) ?></div>
                    </div>
                  </a>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <?php endfor; ?>
          </div>
          
          <?php if (count($services) > 2): ?>
          <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev" style="left:-40px;">
            <span class="carousel-control-prev-icon" style="background-image:url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22%3E%3Cpath d=%22M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z%22 fill=%2306B6D4%22/%3E%3C/svg%3E');"></span>
            <span class="visually-hidden">Önceki</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next" style="right:-40px;">
            <span class="carousel-control-next-icon" style="background-image:url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22%3E%3Cpath d=%22M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z%22 fill=%2306B6D4%22/%3E%3C/svg%3E');"></span>
            <span class="visually-hidden">Sonraki</span>
          </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HİZMETLER -->
<section class="services-section section-pad">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-7">
        <div class="section-badge">Hizmetlerimiz</div>
        <h2 class="section-title">Teknoloji Çözümleri</h2>
        <p class="section-sub mx-auto">İşletmenizin dijital dönüşümü için ihtiyaç duyduğunuz tüm yazılım ve teknoloji çözümleri tek çatı altında.</p>
      </div>
    </div>
    
    <div id="servicesMainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        <?php
        $stmt = $pdo->query("SELECT * FROM hizmetler WHERE durum=1 ORDER BY sira");
        $allServices = $stmt->fetchAll();
        $serviceSetIndex = 0;
        
        for ($i = 0; $i < count($allServices); $i += 3):
          $activeClass = ($serviceSetIndex === 0) ? 'active' : '';
          $serviceSetIndex++;
        ?>
        <div class="carousel-item <?= $activeClass ?>">
          <div class="row g-4">
            <?php for ($j = 0; $j < 3; $j++): ?>
              <?php if (isset($allServices[$i + $j])): 
                $s = $allServices[$i + $j];
              ?>
              <div class="col-lg-4 col-md-6">
                <a href="<?= SITE_URL ?>/hizmetler.php" style="text-decoration:none;">
                  <div class="service-card" style="cursor:pointer; transition: all 0.3s ease;">
                    <div class="service-icon" style="transition: all 0.3s ease;"><i class="bi <?= htmlspecialchars($s['icon']) ?>"></i></div>
                    <h5><?= htmlspecialchars($s['hizmet_adi']) ?></h5>
                    <p><?= htmlspecialchars($s['aciklama']) ?></p>
                    <div class="btn-outline-custom btn btn-sm mt-3" style="border-radius:25px; font-size:0.85rem; display:inline-block;">Detaylı Bilgi <i class="bi bi-arrow-right"></i></div>
                  </div>
                </a>
              </div>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
        </div>
        <?php endfor; ?>
      </div>
      
      <?php if (count($allServices) > 3): ?>
      <button class="carousel-control-prev" type="button" data-bs-target="#servicesMainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Önceki</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#servicesMainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Sonraki</span>
      </button>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- HAKKIMIZDA KISA -->
<section class="about-section section-pad">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-5">
        <div class="about-img-wrap">
          <div style="background: linear-gradient(135deg, #1A56DB, #06B6D4); border-radius:20px; padding:3rem; text-align:center; color:white;">
            <i class="bi bi-building" style="font-size:5rem; opacity:0.8;"></i>
            <div style="font-family:'Poppins',sans-serif; font-size:1.2rem; font-weight:700; margin-top:1rem;"><?= htmlspecialchars($about['baslik'] ?? 'TechNova Yazılım A.Ş.') ?></div>
            <div style="opacity:0.7; margin-top:0.5rem;"><?= htmlspecialchars(($about['kurulus_yili'] ?? '2016') . ' · ' . ($about['sehir'] ?? 'İstanbul')) ?></div>
          </div>
          <div class="about-badge-float">
            <div class="num"><?= htmlspecialchars(($about['proje_sayisi'] ?? 150) . '+') ?></div>
            <div class="text">Başarılı Proje</div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="section-badge"><?= htmlspecialchars($about['baslik'] ?? 'Hakkımızda') ?></div>
        <h2 class="section-title"><?= htmlspecialchars($about['alt_baslik'] ?? 'Teknoloji ile Geleceği Şekillendiriyoruz') ?></h2>
        <p style="color:#64748B; font-size:1rem; margin-bottom:1.5rem;"><?= htmlspecialchars($about['aciklama_1'] ?? '') ?></p>
        <ul class="values-list">
          <li><i class="bi bi-check-circle-fill"></i><div><strong>Misyon:</strong> <?= htmlspecialchars($about['misyon'] ?? '') ?></div></li>
          <li><i class="bi bi-check-circle-fill"></i><div><strong>Vizyon:</strong> <?= htmlspecialchars($about['vizyon'] ?? '') ?></div></li>
          <li><i class="bi bi-check-circle-fill"></i><div><strong>Değerlerimiz:</strong> <?= htmlspecialchars($about['degerler'] ?? '') ?></div></li>
        </ul>
        <a href="<?= SITE_URL ?>/hakkimizda.php" class="btn-primary-custom">Daha Fazla Bilgi <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- BLOG -->
<section class="section-pad" style="background:#F8FAFC;">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-7">
        <div class="section-badge">Blog</div>
        <h2 class="section-title">Son Yazılarımız</h2>
        <p class="section-sub mx-auto">Teknoloji, yazılım ve dijital dünya hakkındaki güncel içerikler.</p>
      </div>
    </div>
    <div class="row g-4">
      <?php
      $stmt = $pdo->query("SELECT b.*, k.ad, k.soyad FROM blog b LEFT JOIN kullanicilar k ON b.yazar_id=k.id WHERE b.durum='yayinda' ORDER BY b.tarih DESC LIMIT 3");
      while($blog = $stmt->fetch()):
      ?>
      <div class="col-lg-4 col-md-6">
        <div class="blog-card">
          <?php if($blog['resim'] && file_exists(__DIR__.'/uploads/blog/'.$blog['resim'])): ?>
          <img src="<?= SITE_URL ?>/uploads/blog/<?= htmlspecialchars($blog['resim']) ?>" class="blog-card-img" alt="<?= htmlspecialchars($blog['baslik']) ?>">
          <?php else: ?>
          <div class="blog-card-img-placeholder"><i class="bi bi-image"></i></div>
          <?php endif; ?>
          <div class="blog-card-body">
            <?php if($blog['kategori']): ?>
            <span class="blog-category"><?= htmlspecialchars($blog['kategori']) ?></span>
            <?php endif; ?>
            <h5><a href="<?= SITE_URL ?>/blog-detay.php?id=<?= $blog['id'] ?>"><?= htmlspecialchars($blog['baslik']) ?></a></h5>
            <?php if($blog['ozet']): ?>
            <p style="font-size:0.88rem; color:#64748B; margin:0.5rem 0;"><?= htmlspecialchars(mb_substr($blog['ozet'],0,100)) ?>...</p>
            <?php endif; ?>
            <div class="blog-meta mt-2">
              <i class="bi bi-calendar3"></i>
              <?= date('d M Y', strtotime($blog['tarih'])) ?>
              <?php if($blog['ad']): ?>
              &bull; <?= htmlspecialchars($blog['ad'].' '.$blog['soyad']) ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-5">
      <a href="<?= SITE_URL ?>/blog.php" class="btn-primary-custom">Tüm Yazılar <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- İLETİŞİM CTA -->
<section class="section-pad" style="background:linear-gradient(135deg,#0F172A,#1e3a5f);">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <h2 style="color:white; font-size:2.2rem; margin-bottom:1rem;">Projenizi Birlikte Hayata Geçirelim</h2>
        <p style="color:rgba(255,255,255,0.7); font-size:1.05rem; margin-bottom:2rem;">Ücretsiz danışmanlık için bizimle iletişime geçin. Uzman ekibimiz en kısa sürede size geri dönecek.</p>
        <a href="<?= SITE_URL ?>/iletisim.php" class="btn-hero-primary" style="font-size:1rem; padding:1rem 2.5rem;">
          <i class="bi bi-send"></i> Hemen İletişime Geç
        </a>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="footer-brand">
          <img src="<?= SITE_URL ?>/assets/img/logo.png" alt="TechNova" class="footer-logo">
          <span>TechNova</span>
        </div>
        <p style="font-size:0.9rem; margin-bottom:1.5rem; line-height:1.7;">Dijital dönüşümde güvenilir teknoloji ortağınız. 2016'dan bu yana 150+ projeyle işletmelerin geleceğini şekillendiriyoruz.</p>
        <div class="social-links">
          <a href="<?= SOCIAL_LINKEDIN ?>" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="<?= SOCIAL_TWITTER ?>" title="Twitter"><i class="bi bi-twitter"></i></a>
          <a href="<?= SOCIAL_FACEBOOK ?>" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="<?= SOCIAL_INSTAGRAM ?>" title="Instagram"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-6">
        <h6>Hizmetler</h6>
        <ul class="footer-links">
          <li><a href="#">Web Geliştirme</a></li>
          <li><a href="#">Mobil Uygulama</a></li>
          <li><a href="#">Siber Güvenlik</a></li>
          <li><a href="#">Bulut Çözümleri</a></li>
          <li><a href="#">Veri Analitiği</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-6">
        <h6>Şirket</h6>
        <ul class="footer-links">
          <li><a href="<?= SITE_URL ?>/hakkimizda.php">Hakkımızda</a></li>
          <li><a href="<?= SITE_URL ?>/blog.php">Blog</a></li>
          <li><a href="<?= SITE_URL ?>/iletisim.php">İletişim</a></li>
          <li><a href="<?= SITE_URL ?>/giris.php">Giriş Yap</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h6>İletişim</h6>
        <div style="font-size:0.88rem; line-height:2;">
          <div><i class="bi bi-geo-alt me-2" style="color:#06B6D4;"></i>Levent, İstanbul, Türkiye</div>
          <div><i class="bi bi-telephone me-2" style="color:#06B6D4;"></i>+90 (212) 555 00 11</div>
          <div><i class="bi bi-envelope me-2" style="color:#06B6D4;"></i>info@technova.com.tr</div>
          <div><i class="bi bi-globe me-2" style="color:#06B6D4;"></i>www.technova.com.tr</div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> TechNova Yazılım A.Ş. Tüm hakları saklıdır.</span>
      <span>Slogan: <em>"Kodun Ötesinde, Geleceğin İçinde"</em></span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
