<?php
require_once 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('/blog.php'); }

$stmt = $pdo->prepare("SELECT b.*, k.ad, k.soyad FROM blog b LEFT JOIN kullanicilar k ON b.yazar_id=k.id WHERE b.id=? AND b.durum='yayinda'");
$stmt->execute([$id]);
$blog = $stmt->fetch();
if (!$blog) { redirect('/blog.php'); }

// Benzer yazılar
$similar = $pdo->prepare("SELECT id, baslik, tarih, resim FROM blog WHERE durum='yayinda' AND id != ? AND kategori = ? ORDER BY tarih DESC LIMIT 3");
$similar->execute([$id, $blog['kategori']]);
$similarPosts = $similar->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($blog['baslik']) ?> | TechNova Blog</title>
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
        <li class="nav-item"><a class="nav-link active" href="<?= SITE_URL ?>/blog.php">Blog</a></li>
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

<!-- BLOG HEADER -->
<div class="blog-detail-header">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/blog.php">Blog</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars(mb_substr($blog['baslik'],0,40)) ?>...</li>
      </ol>
    </nav>
    <?php if($blog['kategori']): ?>
    <span class="blog-category" style="background:rgba(6,182,212,0.2); color:#06B6D4; margin-bottom:1rem; display:inline-block;"><?= htmlspecialchars($blog['kategori']) ?></span>
    <?php endif; ?>
    <h1 style="color:white; font-size:clamp(1.6rem,3vw,2.4rem); max-width:750px; line-height:1.25;"><?= htmlspecialchars($blog['baslik']) ?></h1>
    <div class="d-flex align-items-center gap-3 mt-3" style="color:rgba(255,255,255,0.6); font-size:0.9rem;">
      <?php if($blog['ad']): ?>
      <span><i class="bi bi-person me-1"></i><?= htmlspecialchars($blog['ad'].' '.$blog['soyad']) ?></span>
      <?php endif; ?>
      <span><i class="bi bi-calendar3 me-1"></i><?= date('d MMMM Y', strtotime($blog['tarih'])) ?></span>
      <span><i class="bi bi-clock me-1"></i><?= timeAgo($blog['tarih']) ?></span>
    </div>
  </div>
</div>

<!-- BLOG İÇERİK -->
<section class="section-pad">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if($blog['resim'] && file_exists(__DIR__.'/uploads/blog/'.$blog['resim'])): ?>
        <img src="<?= SITE_URL ?>/uploads/blog/<?= htmlspecialchars($blog['resim']) ?>" class="img-fluid rounded-3 mb-4 w-100" style="max-height:450px; object-fit:cover;" alt="<?= htmlspecialchars($blog['baslik']) ?>">
        <?php endif; ?>
        
        <div class="blog-content">
          <?= $blog['icerik'] ?>
        </div>

        <div class="mt-4 pt-4" style="border-top:1px solid #E2E8F0;">
          <a href="<?= SITE_URL ?>/blog.php" class="btn-outline-custom btn">
            <i class="bi bi-arrow-left me-2"></i>Tüm Yazılar
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BENZER YAZILAR -->
<?php if ($similarPosts): ?>
<section class="section-pad-sm" style="background:#F8FAFC;">
  <div class="container">
    <h3 class="mb-4" style="font-size:1.4rem;">Benzer Yazılar</h3>
    <div class="row g-4">
      <?php foreach($similarPosts as $p): ?>
      <div class="col-md-4">
        <div class="blog-card">
          <?php if($p['resim'] && file_exists(__DIR__.'/uploads/blog/'.$p['resim'])): ?>
          <img src="<?= SITE_URL ?>/uploads/blog/<?= htmlspecialchars($p['resim']) ?>" class="blog-card-img" alt="">
          <?php else: ?>
          <div class="blog-card-img-placeholder"><i class="bi bi-image"></i></div>
          <?php endif; ?>
          <div class="blog-card-body">
            <h5><a href="<?= SITE_URL ?>/blog-detay.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['baslik']) ?></a></h5>
            <div class="blog-meta"><i class="bi bi-calendar3"></i><?= date('d M Y', strtotime($p['tarih'])) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

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
