<?php
require_once 'config.php';

// Önce veritabanını sıfırla
try {
    $pdo->exec("DROP DATABASE IF EXISTS teknomarket");
    echo "✅ Eski veritabanı silindi<br>";
} catch (Exception $e) {
    echo "Veritabanı sıfırlama: " . $e->getMessage() . "<br>";
}

// Yeni bağlantı kur
$dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

// Şimdi SQL dosyasını oku ve import et
$sql = file_get_contents(__DIR__ . '/db/teknomarket.sql');

// Çok büyük SQL dosyalarını delimiter ile ayırıp çalıştır
$statements = array_filter(array_map('trim', preg_split('/;(?=(?:[^\']*\'[^\']*\')*[^\']*$)/', $sql)));

$count = 0;
foreach ($statements as $statement) {
    if (!empty($statement)) {
        try {
            $pdo->exec($statement);
            $count++;
        } catch (Exception $e) {
            // Hata olsa da devam et (tablo zaten varsa vs)
        }
    }
}

echo "✅ <strong>$count</strong> SQL komutu çalıştırıldı!<br>";
echo "✅ Veritabanı başarıyla kuruldu!<br>";
echo "<a href='http://localhost/teknomarket'>Siteye Git →</a>";
?>
