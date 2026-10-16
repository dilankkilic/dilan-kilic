<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik   = clean($_POST['baslik'] ?? '');
    $ozet     = clean($_POST['ozet'] ?? '');
    $icerik   = $_POST['icerik'] ?? '';  // HTML içerik - TinyMCE'den gelir
    $kategori = clean($_POST['kategori'] ?? '');
    $durum    = in_array($_POST['durum'] ?? '', ['yayinda', 'taslak']) ? $_POST['durum'] : 'yayinda';
    $resim_adi = null;

    if (!$baslik || !$icerik) {
        $hata = 'Başlık ve içerik alanları zorunludur.';
    } else {
        // Resim yükleme
        if (!empty($_FILES['resim']['name'])) {
            $izinliTurler = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['resim']['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime, $izinliTurler)) {
                $hata = 'Yalnızca JPG, PNG, WebP ve GIF formatları kabul edilmektedir.';
            } elseif ($_FILES['resim']['size'] > 5 * 1024 * 1024) {
                $hata = 'Dosya boyutu maksimum 5MB olabilir.';
            } else {
                $uzanti = pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION);
                $resim_adi = uniqid('blog_', true) . '.' . strtolower($uzanti);
                $hedef = __DIR__ . '/../uploads/blog/' . $resim_adi;
                if (!move_uploaded_file($_FILES['resim']['tmp_name'], $hedef)) {
                    $hata = 'Resim yüklenirken hata oluştu.';
                    $resim_adi = null;
                }
            }
        }

        if (!$hata) {
            $stmt = $pdo->prepare("INSERT INTO blog (baslik, ozet, icerik, resim, kategori, yazar_id, durum) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$baslik, $ozet, $icerik, $resim_adi, $kategori, $_SESSION['kullanici_id'], $durum]);
            header("Location: blog.php?kaydedildi=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yeni Blog Ekle | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/blog-ekle.php" class="sidebar-link active"><i class="bi bi-plus-circle"></i> Yeni Blog Ekle</a>
    <a href="<?= SITE_URL ?>/admin/hizmetler.php" class="sidebar-link"><i class="bi bi-gear"></i> Hizmetler</a>
    <a href="<?= SITE_URL ?>/admin/hakkimizda.php" class="sidebar-link"><i class="bi bi-info-circle"></i> Hakkımızda</a>
    <div class="sidebar-label">Yönetim</div>
    <a href="<?= SITE_URL ?>/admin/mesajlar.php" class="sidebar-link"><i class="bi bi-envelope"></i> Mesajlar</a>
    <a href="<?= SITE_URL ?>/admin/kullanicilar.php" class="sidebar-link"><i class="bi bi-people"></i> Kullanıcılar</a>
    <div class="sidebar-label">Site</div>
    <a href="<?= SITE_URL ?>" target="_blank" class="sidebar-link"><i class="bi bi-box-arrow-up-right"></i> Siteyi Görüntüle</a>
    <a href="<?= SITE_URL ?>/cikis.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
  </nav>
</aside>

<div class="admin-main">
  <div class="admin-topbar">
    <div>
      <a href="<?= SITE_URL ?>/admin/blog.php" style="color:#64748B; font-size:0.9rem;"><i class="bi bi-arrow-left me-1"></i>Blog Yazıları</a>
      <span style="color:#CBD5E1; margin:0 8px;">/</span>
      <span style="font-weight:600; color:#0F172A;">Yeni Blog Ekle</span>
    </div>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="form-card mb-4">
            <div class="card-title">Yazı İçeriği</div>
            <div class="mb-3">
              <label class="form-label">Başlık *</label>
              <input type="text" name="baslik" class="form-control" placeholder="Blog yazısı başlığı..." required maxlength="255" value="<?= htmlspecialchars($_POST['baslik'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Özet <small style="color:#94A3B8;">(Liste sayfasında görünür)</small></label>
              <textarea name="ozet" class="form-control" rows="3" placeholder="Kısa bir özet yazın..." maxlength="500"><?= htmlspecialchars($_POST['ozet'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">İçerik *</label>
              <textarea name="icerik" id="icerik" class="form-control" rows="15" placeholder="Blog yazısı içeriği..." required><?= htmlspecialchars($_POST['icerik'] ?? '') ?></textarea>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-card mb-4">
            <div class="card-title">Yayın Ayarları</div>
            <div class="mb-3">
              <label class="form-label">Durum</label>
              <select name="durum" class="form-select">
                <option value="yayinda" <?= (($_POST['durum'] ?? 'yayinda')==='yayinda') ? 'selected' : '' ?>>Yayında</option>
                <option value="taslak" <?= (($_POST['durum'] ?? '')==='taslak') ? 'selected' : '' ?>>Taslak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <input type="text" name="kategori" class="form-control" placeholder="Teknoloji, Web, Mobil..." maxlength="100" value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>">
            </div>
          </div>

          <div class="form-card mb-4">
            <div class="card-title">Kapak Görseli</div>
            <div class="mb-2">
              <input type="file" name="resim" id="resimInput" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
              <small style="color:#94A3B8; font-size:0.78rem; display:block; margin-top:0.4rem;">Maks. 5MB · JPG, PNG, WebP, GIF</small>
            </div>
            <div id="onizleme" style="display:none; margin-top:0.75rem;">
              <img id="onizlemeImg" src="" style="width:100%; border-radius:8px; max-height:160px; object-fit:cover;" alt="Önizleme">
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; padding:0.85rem; font-weight:600;">
            <i class="bi bi-check-lg me-2"></i>Blog Yazısını Kaydet
          </button>
          <a href="<?= SITE_URL ?>/admin/blog.php" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;">İptal</a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- TinyMCE CDN (ücretsiz community edition) -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#icerik',
    language: 'tr_TR',
    height: 450,
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat | code fullscreen',
    content_style: 'body { font-family: Inter, sans-serif; font-size: 15px; color: #334155; line-height: 1.8; }',
    branding: false,
    promotion: false
});

// Resim önizleme
document.getElementById('resimInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('onizlemeImg').src = e.target.result;
            document.getElementById('onizleme').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
