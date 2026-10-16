<?php
require_once '../config.php';
requireAdmin();

$hata = '';
$basari = '';
$about = getAboutContent($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = clean($_POST['baslik'] ?? '');
    $alt_baslik = clean($_POST['alt_baslik'] ?? '');
    $kisa_aciklama = clean($_POST['kisa_aciklama'] ?? '');
    $aciklama_1 = clean($_POST['aciklama_1'] ?? '');
    $aciklama_2 = clean($_POST['aciklama_2'] ?? '');
    $misyon = clean($_POST['misyon'] ?? '');
    $vizyon = clean($_POST['vizyon'] ?? '');
    $degerler = clean($_POST['degerler'] ?? '');
    $kurulus_yili = clean($_POST['kurulus_yili'] ?? '2016');
    $sehir = clean($_POST['sehir'] ?? 'İstanbul');
    $proje_sayisi = (int)($_POST['proje_sayisi'] ?? 150);
    $aktif_musteri = (int)($_POST['aktif_musteri'] ?? 50);
    $uzman_ekip = (int)($_POST['uzman_ekip'] ?? 25);
    $memnuniyet = clean($_POST['memnuniyet'] ?? '98%');
    $hedef_kitle_baslik = clean($_POST['hedef_kitle_baslik'] ?? 'Hedef Kitlemiz');
    $hedef_kitle_aciklama = clean($_POST['hedef_kitle_aciklama'] ?? '');
    $hedef_kitle_json = trim($_POST['hedef_kitle_json'] ?? '');

    if (!$baslik || !$alt_baslik || !$kisa_aciklama || !$aciklama_1 || !$aciklama_2 || !$misyon || !$vizyon || !$degerler || !$hedef_kitle_baslik || !$hedef_kitle_aciklama || !$hedef_kitle_json) {
        $hata = 'Lütfen tüm alanları doldurun.';
    } else {
        $decoded = json_decode($hedef_kitle_json, true);
        if (!is_array($decoded)) {
            $hata = 'Hedef kitle JSON formatı geçersiz.';
        } else {
            $stmt = $pdo->prepare("UPDATE hakkimizda_icerik SET baslik=?, alt_baslik=?, kisa_aciklama=?, aciklama_1=?, aciklama_2=?, misyon=?, vizyon=?, degerler=?, kurulus_yili=?, sehir=?, proje_sayisi=?, aktif_musteri=?, uzman_ekip=?, memnuniyet=?, hedef_kitle_baslik=?, hedef_kitle_aciklama=?, hedef_kitle_json=? WHERE id=1");
            $stmt->execute([
                $baslik,
                $alt_baslik,
                $kisa_aciklama,
                $aciklama_1,
                $aciklama_2,
                $misyon,
                $vizyon,
                $degerler,
                $kurulus_yili,
                $sehir,
                $proje_sayisi,
                $aktif_musteri,
                $uzman_ekip,
                $memnuniyet,
                $hedef_kitle_baslik,
                $hedef_kitle_aciklama,
                json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            ]);
            header('Location: hakkimizda.php?kaydedildi=1');
            exit;
        }
    }
}

$about = getAboutContent($pdo);
$hedefKitleJson = $about['hedef_kitle_json'] ?? '[]';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hakkımızda Yönetimi | Admin</title>
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
    <a href="<?= SITE_URL ?>/admin/hakkimizda.php" class="sidebar-link active"><i class="bi bi-info-circle"></i> Hakkımızda</a>
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
    <span style="font-weight:600; color:#0F172A;">Hakkımızda Yönetimi</span>
  </div>
  <div class="admin-content">
    <?php if ($hata): ?><div class="alert alert-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i><?= $hata ?></div><?php endif; ?>
    <?php if (isset($_GET['kaydedildi'])): ?><div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i>Hakkımızda içeriği güncellendi.</div><?php endif; ?>

    <form method="post">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="form-card mb-4">
            <div class="card-title">Sayfa İçeriği</div>
            <div class="mb-3">
              <label class="form-label">Başlık</label>
              <input type="text" name="baslik" class="form-control" value="<?= htmlspecialchars($about['baslik'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Alt Başlık</label>
              <input type="text" name="alt_baslik" class="form-control" value="<?= htmlspecialchars($about['alt_baslik'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kısa Açıklama</label>
              <textarea name="kisa_aciklama" class="form-control" rows="3" required><?= htmlspecialchars($about['kisa_aciklama'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Açıklama 1</label>
              <textarea name="aciklama_1" class="form-control" rows="4" required><?= htmlspecialchars($about['aciklama_1'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Açıklama 2</label>
              <textarea name="aciklama_2" class="form-control" rows="4" required><?= htmlspecialchars($about['aciklama_2'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Misyon</label>
              <textarea name="misyon" class="form-control" rows="3" required><?= htmlspecialchars($about['misyon'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Vizyon</label>
              <textarea name="vizyon" class="form-control" rows="3" required><?= htmlspecialchars($about['vizyon'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Değerler</label>
              <input type="text" name="degerler" class="form-control" value="<?= htmlspecialchars($about['degerler'] ?? '') ?>" required>
              <small style="color:#94A3B8; font-size:0.78rem;">Virgülle ayır: Yenilikçilik, Şeffaflık, Kalite...</small>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-card mb-4">
            <div class="card-title">İstatistikler</div>
            <div class="mb-3">
              <label class="form-label">Kuruluş Yılı</label>
              <input type="text" name="kurulus_yili" class="form-control" value="<?= htmlspecialchars($about['kurulus_yili'] ?? '2016') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Şehir</label>
              <input type="text" name="sehir" class="form-control" value="<?= htmlspecialchars($about['sehir'] ?? 'İstanbul') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Başarılı Proje</label>
              <input type="number" name="proje_sayisi" class="form-control" value="<?= (int)($about['proje_sayisi'] ?? 150) ?>" min="0" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Aktif Müşteri</label>
              <input type="number" name="aktif_musteri" class="form-control" value="<?= (int)($about['aktif_musteri'] ?? 50) ?>" min="0" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Uzman Ekip</label>
              <input type="number" name="uzman_ekip" class="form-control" value="<?= (int)($about['uzman_ekip'] ?? 25) ?>" min="0" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Müşteri Memnuniyeti</label>
              <input type="text" name="memnuniyet" class="form-control" value="<?= htmlspecialchars($about['memnuniyet'] ?? '98%') ?>" required>
            </div>
          </div>

          <div class="form-card mb-4">
            <div class="card-title">Hedef Kitle</div>
            <div class="mb-3">
              <label class="form-label">Başlık</label>
              <input type="text" name="hedef_kitle_baslik" class="form-control" value="<?= htmlspecialchars($about['hedef_kitle_baslik'] ?? 'Hedef Kitlemiz') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Açıklama</label>
              <textarea name="hedef_kitle_aciklama" class="form-control" rows="3" required><?= htmlspecialchars($about['hedef_kitle_aciklama'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Kartlar JSON</label>
              <textarea name="hedef_kitle_json" class="form-control" rows="10" required><?= htmlspecialchars($hedefKitleJson) ?></textarea>
              <small style="color:#94A3B8; font-size:0.78rem; display:block; margin-top:0.4rem;">Örnek: [{"icon":"bi-building","title":"Kurumsal Şirketler","text":"Dijital dönüşüm"}]</small>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; padding:0.85rem; font-weight:600;">
            <i class="bi bi-check-lg me-2"></i>Kaydet
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
