<?php
require_once 'config.php';

// login_ayarlar tablosu oluştur
$sql = "CREATE TABLE IF NOT EXISTS login_ayarlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    baslik VARCHAR(255) NOT NULL DEFAULT 'Giriş Yap',
    alt_baslik VARCHAR(255) NOT NULL DEFAULT 'Hesabınıza giriş yapın',
    arka_renk VARCHAR(50) NOT NULL DEFAULT '#0F172A',
    form_arka_renk VARCHAR(50) NOT NULL DEFAULT '#FFFFFF',
    button_renk VARCHAR(50) NOT NULL DEFAULT '#1A56DB',
    button_hover_renk VARCHAR(50) NOT NULL DEFAULT '#1E40AF',
    metin_renk VARCHAR(50) NOT NULL DEFAULT '#0F172A',
    etiket_renk VARCHAR(50) NOT NULL DEFAULT '#64748B',
    logo_url VARCHAR(255) NOT NULL DEFAULT 'assets/img/logo.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

try {
    $pdo->exec($sql);
    echo "✅ Tablo oluşturuldu: login_ayarlar<br>";
    
    // Varsayılan değerleri ekle
    $check = $pdo->query("SELECT COUNT(*) FROM login_ayarlar")->fetchColumn();
    if ($check == 0) {
        $insert = $pdo->prepare("INSERT INTO login_ayarlar (baslik, alt_baslik, arka_renk, form_arka_renk, button_renk, button_hover_renk, metin_renk, etiket_renk, logo_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([
            'Giriş Yap',
            'Hesabınıza giriş yapın',
            '#0F172A',
            '#FFFFFF',
            '#1A56DB',
            '#1E40AF',
            '#0F172A',
            '#64748B',
            'assets/img/logo.png'
        ]);
        echo "✅ Varsayılan değerler eklendi<br>";
    }
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "<br>";
}
?>
