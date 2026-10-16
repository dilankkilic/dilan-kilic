<?php
require_once 'config.php';

$to = isset($_GET['to']) ? preg_replace('/[^a-z]/', '', $_GET['to']) : '';
$map = [
    'instagram' => 'https://www.instagram.com/accounts/login/',
    'facebook'  => 'https://www.facebook.com/login/',
    'twitter'   => 'https://twitter.com/i/flow/login',
    'linkedin'  => 'https://www.linkedin.com/login',
    'whatsapp'  => 'https://wa.me/902125550011',
    'telegram'  => 'https://web.telegram.org/',
];

$target = $map[$to] ?? SITE_URL;

// Log to mesajlar for admin notification
try {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $konu = 'Sosyal Yönlendirme: ' . ucfirst($to);
    $mesaj_text = sprintf("Kullanıcı %s ikonuna tıkladı. IP: %s", ucfirst($to), $ip);
    $stmt = $pdo->prepare("INSERT INTO mesajlar (ad, email, konu, mesaj) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Sosyal', ADMIN_EMAIL, $konu, $mesaj_text]);
} catch (Exception $e) {
    // ignore logging errors
}

// Redirect to the external service, open in new tab is controlled by link target
header('Location: ' . $target);
exit;
