<?php
// Veritabanı Bağlantı Testi
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TechNova Veritabanı Bağlantı Testi ===\n\n";

// config.php yükle
require_once 'config.php';

try {
    echo "✓ Config dosyası başarıyla yüklendi\n";
    echo "✓ Veritabanı: " . DB_NAME . "\n";
    echo "✓ Host: " . DB_HOST . "\n";
    echo "✓ Kullanıcı: " . DB_USER . "\n";
    echo "✓ PDO Nesnesi: " . (isset($pdo) ? "Oluşturuldu" : "HATA!") . "\n\n";
    
    // Bağlantı testi
    if (isset($pdo)) {
        $test = $pdo->query("SELECT 1");
        echo "✓ Veritabanı bağlantısı başarılı!\n";
        
        // Tabloları kontrol et
        $tables = $pdo->query("SHOW TABLES")->fetchAll();
        echo "\n📊 Veritabanında " . count($tables) . " tablo bulundu:\n";
        foreach ($tables as $table) {
            echo "   - " . $table[0] . "\n";
        }
        
        // Sayfa durumunu kontrol et
        echo "\n📄 Admin Paneline erişim: http://localhost/teknomarket/admin/\n";
        echo "📄 Giriş: http://localhost/teknomarket/giris.php\n";
        echo "📄 Kayıt: http://localhost/teknomarket/kayit.php\n";
    }
    
} catch (Exception $e) {
    echo "✗ BAĞLANTI HATASI: " . $e->getMessage() . "\n";
}
?>
