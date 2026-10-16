# TechNova Yazılım - Kurulum Kılavuzu

## Proje Hakkında
**Firma:** TechNova Yazılım A.Ş.  
**Slogan:** "Kodun Ötesinde, Geleceğin İçinde"  
**Teknolojiler:** PHP, MySQL, Bootstrap 5, HTML5, CSS3  
**Geliştirme Ortamı:** XAMPP / WAMP / Localhost

---

## Kurulum Adımları

### 1. XAMPP Kurulumu
- https://www.apachefriends.org adresinden XAMPP'ı indirin ve kurun
- Apache ve MySQL servislerini başlatın

### 2. Proje Dosyaları
```
C:\xampp\htdocs\teknomarket\  (tüm proje dosyaları buraya)
```

### 3. Veritabanı Kurulumu
1. Tarayıcıda `http://localhost/phpmyadmin` adresine gidin
2. **Yeni** veritabanı oluştur → İsim: `technova` → Sırala: `utf8mb4_unicode_ci`
3. Oluşturulan veritabanına tıklayın → **İçe Aktar** sekmesi
4. `db/technova.sql` dosyasını seçin → **Git** butonuna basın

### 4. Yapılandırma
`config.php` dosyasını açın ve gerekirse düzenleyin:
```php
define('DB_HOST', 'localhost');   // Genellikle değişmez
define('DB_USER', 'root');        // XAMPP varsayılan: root
define('DB_PASS', '');            // XAMPP varsayılan: boş
define('DB_NAME', 'technova');    // Veritabanı adı
define('SITE_URL', 'http://localhost/teknomarket');  // Proje URL'si
```

### 5. Upload Klasörleri
Upload klasörlerinin yazma iznine sahip olduğundan emin olun:
```
uploads/blog/
```
Windows'ta genellikle otomatik çalışır. Linux'ta:
```bash
chmod -R 755 uploads/
```

### 6. Siteyi Açın
- **Frontend:** http://localhost/teknomarket/
- **Admin Panel:** http://localhost/teknomarket/admin/

---

## Admin Giriş Bilgileri
```
E-posta: admin@technova.com.tr
Şifre:   Admin123!
```
⚠️ **ÖNEMLİ:** Canlıya geçmeden önce şifreyi değiştirin!

Şifre değiştirmek için phpMyAdmin'de:
```sql
UPDATE kullanicilar 
SET sifre = '$2y$10$YENI_HASH' 
WHERE email = 'admin@technova.com.tr';
```
Ya da PHP ile hash oluşturun:
```php
echo password_hash('YeniSifreniz', PASSWORD_BCRYPT);
```

---

## Proje Yapısı
```
teknomarket/
├── index.php          → Ana Sayfa
├── hakkimizda.php     → Hakkımızda
├── hizmetler.php      → Hizmetler
├── blog.php           → Blog Listesi
├── blog-detay.php     → Blog Detay
├── iletisim.php       → İletişim Formu
├── giris.php          → Giriş Sayfası
├── kayit.php          → Kayıt Sayfası
├── cikis.php          → Çıkış
├── config.php         → Veritabanı & Ayarlar
├── admin/
│   ├── index.php      → Dashboard
│   ├── blog.php       → Blog Listesi
│   ├── blog-ekle.php  → Yeni Blog
│   ├── blog-duzenle.php → Blog Düzenle
│   ├── hizmetler.php  → Hizmet Yönetimi
│   ├── mesajlar.php   → Mesaj Yönetimi
│   └── kullanicilar.php → Kullanıcı Listesi
├── assets/
│   └── css/
│       ├── style.css  → Ana Stil
│       └── admin.css  → Admin Stil
├── uploads/
│   └── blog/          → Blog Görselleri
└── db/
    └── technova.sql   → Veritabanı
```

---

## Veritabanı Tabloları

| Tablo | Açıklama |
|-------|----------|
| `kullanicilar` | Kullanıcılar (admin/normal) |
| `blog` | Blog yazıları |
| `mesajlar` | İletişim formu mesajları |
| `hizmetler` | Hizmet/Ürün listesi |

---

## Güvenlik Özellikleri
- ✅ PDO Prepared Statements (SQL Injection koruması)
- ✅ password_hash() ile BCrypt şifreleme
- ✅ htmlspecialchars() ile XSS koruması
- ✅ FILTER_VALIDATE_EMAIL ile e-posta doğrulama
- ✅ MIME type kontrolü ile güvenli dosya yükleme
- ✅ session_regenerate_id() ile oturum güvenliği
- ✅ Admin paneli yetkilendirme kontrolü

---

## Kurumsal Kimlik Bilgileri

### Renk Paleti
| Renk | HEX | RGB | Kullanım |
|------|-----|-----|---------|
| Ana Mavi | #1A56DB | rgb(26, 86, 219) | %40 - Butonlar, linkler |
| Koyu Lacivert | #0F172A | rgb(15, 23, 42) | %25 - Başlıklar, bg |
| Cyan | #06B6D4 | rgb(6, 182, 212) | %20 - Vurgu, ikonlar |
| Açık Gri | #F8FAFC | rgb(248, 250, 252) | %10 - Arka planlar |
| Metin Gri | #64748B | rgb(100, 116, 139) | %5 - Yardımcı metin |

### Tipografi
- **Başlık Fontu:** Poppins (600, 700, 800) — Google Fonts
- **İçerik Fontu:** Inter (300, 400, 500, 600) — Google Fonts
- **Web Uyumlu Fallback:** system-ui, -apple-system, sans-serif

---

## Sık Karşılaşılan Sorunlar

**Veritabanı bağlantı hatası:**
- XAMPP'ta MySQL'in çalıştığından emin olun
- config.php'deki bilgilerin doğru olduğunu kontrol edin

**Resim yüklenemiyor:**
- `uploads/blog/` klasörünün var olduğundan emin olun
- Klasörün yazma iznine sahip olduğunu kontrol edin

**Admin paneline girilemez:**
- SQL dosyasının doğru import edildiğini kontrol edin
- Şifre: `Admin123!`

**TinyMCE görünmüyor:**
- İnternete bağlı olduğunuzdan emin olun (CDN'den yüklenir)
- Offline kullanım için TinyMCE'yi indirip yerel olarak kullanın
