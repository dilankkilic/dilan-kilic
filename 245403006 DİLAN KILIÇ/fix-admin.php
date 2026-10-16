<?php
require_once 'config.php';

// Admin123! şifresi için doğru hash
$sifre = 'Admin123!';
$hash = password_hash($sifre, PASSWORD_BCRYPT);

echo "Hesaplanan hash: " . $hash . "<br><br>";

try {
    // Admin kullanıcısını güncelle
    $stmt = $pdo->prepare("UPDATE kullanicilar SET sifre = ? WHERE email = ?");
    $stmt->execute([$hash, 'admin@technova.com.tr']);
    
    echo "✅ Admin şifresi başarıyla güncellendi!<br>";
    echo "📧 E-posta: admin@technova.com.tr<br>";
    echo "🔑 Şifre: Admin123!<br><br>";
    echo "<a href='http://localhost/teknomarket/admin/giris.php'>Admin Girişine Git →</a>";
    
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage();
}
?>
