<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blog | TechNova Yazılım</title>
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

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>">Ana Sayfa</a></li>
        <li class="breadcrumb-item active">Blog</li>
      </ol>
    </nav>
    <h1>Blog & Haberler</h1>
    <p>Teknoloji, yazılım ve dijital dünyadan güncel içerikler</p>
  </div>
</div>

<!-- BLOG LİSTESİ -->
<section class="section-pad">
  <div class="container">
    <!-- Kategori Filtre -->
    <?php
    $kategoriler = $pdo->query("SELECT DISTINCT kategori FROM blog WHERE durum='yayinda' AND kategori IS NOT NULL AND kategori != '' ORDER BY kategori")->fetchAll();
    ?>
    <?php if ($kategoriler): ?>
    <div class="mb-4 d-flex flex-wrap gap-2">
      <a href="<?= SITE_URL ?>/blog.php" class="btn btn-sm <?= !isset($_GET['kategori']) ? 'btn-primary' : 'btn-outline-secondary' ?>" style="border-radius:20px;">Tümü</a>
      <?php foreach($kategoriler as $kat): ?>
      <a href="?kategori=<?= urlencode($kat['kategori']) ?>" class="btn btn-sm <?= (isset($_GET['kategori']) && $_GET['kategori']==$kat['kategori']) ? 'btn-primary' : 'btn-outline-secondary' ?>" style="border-radius:20px;"><?= htmlspecialchars($kat['kategori']) ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php
    $where = "WHERE b.durum='yayinda'";
    $params = [];
    if (!empty($_GET['kategori'])) {
        $where .= " AND b.kategori = :kat";
        $params[':kat'] = $_GET['kategori'];
    }
    if (!empty($_GET['ara'])) {
        $where .= " AND (b.baslik LIKE :ara OR b.ozet LIKE :ara2)";
        $params[':ara'] = '%'.$_GET['ara'].'%';
        $params[':ara2'] = '%'.$_GET['ara'].'%';
    }

    $page = max(1, (int)($_GET['sayfa'] ?? 1));
    $perPage = 9;
    $offset = ($page - 1) * $perPage;

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM blog b $where");
    $countStmt->execute($params);
    $total = $countStmt->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("SELECT b.*, k.ad, k.soyad FROM blog b LEFT JOIN kullanicilar k ON b.yazar_id=k.id $where ORDER BY b.tarih DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);
    $posts = $stmt->fetchAll();
    ?>

    <!-- Arama -->
    <form method="get" class="mb-4">
      <?php if(!empty($_GET['kategori'])): ?>
      <input type="hidden" name="kategori" value="<?= htmlspecialchars($_GET['kategori']) ?>">
      <?php endif; ?>
      <div class="input-group" style="max-width:400px;">
        <input type="text" name="ara" class="form-control" placeholder="Blog yazılarında ara..." value="<?= htmlspecialchars($_GET['ara'] ?? '') ?>">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>

    <div class="row g-4">
      <?php if (empty($posts)): ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-journal-x" style="font-size:3rem; color:#CBD5E1;"></i>
        <p class="mt-3 text-muted">Henüz blog yazısı bulunmuyor.</p>
      </div>
      <?php endif; ?>
      <?php foreach($posts as $blog): ?>
      <div class="col-lg-4 col-md-6">
        <div class="blog-card h-100">
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
            <p style="font-size:0.88rem; color:#64748B; margin:0.5rem 0;"><?= htmlspecialchars(mb_substr($blog['ozet'],0,120)) ?>...</p>
            <?php endif; ?>
            <div class="blog-meta mt-2">
              <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($blog['tarih'])) ?>
              <?php if($blog['ad']): ?> &bull; <i class="bi bi-person"></i> <?= htmlspecialchars($blog['ad'].' '.$blog['soyad']) ?><?php endif; ?>
            </div>
            <a href="<?= SITE_URL ?>/blog-detay.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-outline-primary mt-3" style="border-radius:20px; font-size:0.82rem;">Devamını Oku <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav class="mt-5">
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?sayfa=<?= $page-1 ?><?= !empty($_GET['kategori'])? '&kategori='.urlencode($_GET['kategori']) : '' ?>"><i class="bi bi-chevron-left"></i></a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i==$page ? 'active' : '' ?>">
          <a class="page-link" href="?sayfa=<?= $i ?><?= !empty($_GET['kategori'])? '&kategori='.urlencode($_GET['kategori']) : '' ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
        <li class="page-item"><a class="page-link" href="?sayfa=<?= $page+1 ?><?= !empty($_GET['kategori'])? '&kategori='.urlencode($_GET['kategori']) : '' ?>"><i class="bi bi-chevron-right"></i></a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>
  </div>
</section>

<!-- FOOTER -->
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
