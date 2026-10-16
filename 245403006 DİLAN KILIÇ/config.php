<?php
// TechNova - Veritabanı Bağlantı Ayarları
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'teknomarket');
define('DB_CHARSET', 'utf8mb4');

// Site Ayarları
define('SITE_URL', 'http://localhost/teknomarket');
define('SITE_NAME', 'TechNova Yazılım');
define('ADMIN_EMAIL', 'admin@technova.com.tr');

// Sosyal Medya Bağlantıları
define('SOCIAL_INSTAGRAM', SITE_URL . '/social_redirect.php?to=instagram');
define('SOCIAL_FACEBOOK', SITE_URL . '/social_redirect.php?to=facebook');
define('SOCIAL_TWITTER', SITE_URL . '/social_redirect.php?to=twitter');
define('SOCIAL_WHATSAPP', SITE_URL . '/social_redirect.php?to=whatsapp');
define('SOCIAL_TELEGRAM', SITE_URL . '/social_redirect.php?to=telegram');
define('SOCIAL_LINKEDIN', SITE_URL . '/social_redirect.php?to=linkedin');

// Oturum başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PDO Bağlantısı
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    $pdo->exec("CREATE TABLE IF NOT EXISTS site_ayarlar (
        id INT AUTO_INCREMENT PRIMARY KEY,
        menu_blog BOOLEAN DEFAULT 1,
        menu_hizmetler BOOLEAN DEFAULT 1,
        menu_hakkimizda BOOLEAN DEFAULT 1,
        menu_iletisim BOOLEAN DEFAULT 1,
        menu_giris BOOLEAN DEFAULT 1,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $siteAyarCount = (int)$pdo->query("SELECT COUNT(*) FROM site_ayarlar")->fetchColumn();
    if ($siteAyarCount === 0) {
        $pdo->exec("INSERT INTO site_ayarlar (menu_blog, menu_hizmetler, menu_hakkimizda, menu_iletisim, menu_giris) VALUES (1, 1, 1, 1, 1)");
    }

    $pdo->exec("CREATE TABLE IF NOT EXISTS hakkimizda_icerik (
        id INT AUTO_INCREMENT PRIMARY KEY,
        baslik VARCHAR(255) NOT NULL,
        alt_baslik VARCHAR(255) NOT NULL,
        kisa_aciklama TEXT NOT NULL,
        aciklama_1 TEXT NOT NULL,
        aciklama_2 TEXT NOT NULL,
        misyon TEXT NOT NULL,
        vizyon TEXT NOT NULL,
        degerler TEXT NOT NULL,
        kurulus_yili VARCHAR(20) NOT NULL DEFAULT '2016',
        sehir VARCHAR(100) NOT NULL DEFAULT 'İstanbul',
        proje_sayisi INT NOT NULL DEFAULT 150,
        aktif_musteri INT NOT NULL DEFAULT 50,
        uzman_ekip INT NOT NULL DEFAULT 25,
        memnuniyet VARCHAR(20) NOT NULL DEFAULT '98%',
        hedef_kitle_baslik VARCHAR(255) NOT NULL,
        hedef_kitle_aciklama TEXT NOT NULL,
        hedef_kitle_json LONGTEXT NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $aboutCount = (int)$pdo->query("SELECT COUNT(*) FROM hakkimizda_icerik")->fetchColumn();
    if ($aboutCount === 0) {
        $defaultHedefKitle = json_encode([
            ['icon' => 'bi-building', 'title' => 'Kurumsal Şirketler', 'text' => 'Dijital dönüşüm ve kurumsal yazılım projeleri'],
            ['icon' => 'bi-lightning', 'title' => 'Startup\'lar', 'text' => 'MVP geliştirme ve hızlı ürün lansmanı'],
            ['icon' => 'bi-shop', 'title' => 'KOBİ\'ler', 'text' => 'E-ticaret ve işletme yönetim sistemleri'],
            ['icon' => 'bi-bank', 'title' => 'Kamu Kurumları', 'text' => 'Güvenli ve ölçeklenebilir devlet projeleri'],
        ], JSON_UNESCAPED_UNICODE);

        $stmt = $pdo->prepare("INSERT INTO hakkimizda_icerik
            (baslik, alt_baslik, kisa_aciklama, aciklama_1, aciklama_2, misyon, vizyon, degerler, kurulus_yili, sehir, proje_sayisi, aktif_musteri, uzman_ekip, memnuniyet, hedef_kitle_baslik, hedef_kitle_aciklama, hedef_kitle_json)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            'Hakkımızda',
            'Teknoloji ile geleceği birlikte şekillendiriyoruz',
            "TechNova Yazılım A.Ş., 2016 yılında İstanbul'da kurulan, yazılım, web geliştirme, mobil uygulama ve siber güvenlik alanlarında uzmanlaşmış bir teknoloji şirketidir.",
            "Kurumsal ve KOBİ ölçeğindeki işletmelere özel, sürdürülebilir dijital çözümler üreterek 150'den fazla başarılı projeyi hayata geçirdik. Müşteri odaklı yaklaşımımız ve yenilikçi teknoloji anlayışımızla sektörde güvenilir bir referans haline geldik.",
            'Her ölçekteki işletmeye özel, ölçeklenebilir ve sürdürülebilir dijital çözümler üreterek iş süreçlerini optimize etmek ve rekabet avantajı sağlamak.',
            'Her ölçekteki işletmeye özel, sürdürülebilir dijital çözümler üretmek.',
            'Türkiye\'nin en güvenilir yazılım ve teknoloji ortağı olmak; inovatif çözümlerimizle global pazarda söz sahibi bir marka haline gelmek.',
            'Yenilikçilik, Şeffaflık, Kalite, Müşteri Odaklılık, Güvenilirlik, Sürdürülebilirlik',
            '2016',
            'İstanbul',
            150,
            50,
            25,
            '98%',
            'Hedef Kitlemiz',
            "KOBİ'lerden holdinglere, startuplardan kamu kurumlarına kadar geniş bir yelpazede hizmet veriyoruz.",
            $defaultHedefKitle,
        ]);
    }
} catch (PDOException $e) {
    die(json_encode(['error' => 'Veritabanı bağlantı hatası. Lütfen yapılandırmayı kontrol edin.']));
}

// Yardımcı Fonksiyonlar
function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['kullanici_id']);
}

function isAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        redirect('/admin/giris.php');
    }
}

function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if ($diff->d == 0) {
        if ($diff->h == 0) return $diff->i . ' dakika önce';
        return $diff->h . ' saat önce';
    }
    if ($diff->d < 30) return $diff->d . ' gün önce';
    if ($diff->m < 12) return $diff->m . ' ay önce';
    return $diff->y . ' yıl önce';
}

function getAboutContent(PDO $pdo) {
    $stmt = $pdo->query("SELECT * FROM hakkimizda_icerik ORDER BY id ASC LIMIT 1");
    $about = $stmt->fetch();

    if (!$about) {
        return null;
    }

    $about['degerler_listesi'] = array_values(array_filter(array_map('trim', preg_split('/,\s*/', $about['degerler']))));
    $decoded = json_decode($about['hedef_kitle_json'], true);
    $about['hedef_kitle_listesi'] = is_array($decoded) ? $decoded : [];

    return $about;
}
?>
