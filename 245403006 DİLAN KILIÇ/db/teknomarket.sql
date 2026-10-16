-- TechNova Yazılım - Veritabanı Yapısı
-- phpMyAdmin üzerinden import edilecek

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `teknomarket` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `teknomarket`;

-- --------------------------------------------------------
-- Tablo: kullanicilar
-- --------------------------------------------------------
CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(100) NOT NULL,
  `soyad` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` enum('admin','kullanici') NOT NULL DEFAULT 'kullanici',
  `olusturma_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Varsayılan admin kullanıcısı (şifre: Admin123!)
INSERT INTO `kullanicilar` (`ad`, `soyad`, `email`, `sifre`, `rol`) VALUES
('Admin', 'TechNova', 'admin@technova.com.tr', '$2y$10$ceN8IEZ4HugQyTFQt/I4gO.Oba67IrOYn8/zguoRuS3DysFgOk6.G', 'admin')
ON DUPLICATE KEY UPDATE
  `ad` = VALUES(`ad`),
  `soyad` = VALUES(`soyad`),
  `sifre` = VALUES(`sifre`),
  `rol` = 'admin';

-- --------------------------------------------------------
-- Tablo: hakkimizda_icerik
-- --------------------------------------------------------
CREATE TABLE `hakkimizda_icerik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `alt_baslik` varchar(255) NOT NULL,
  `kisa_aciklama` text NOT NULL,
  `aciklama_1` text NOT NULL,
  `aciklama_2` text NOT NULL,
  `misyon` text NOT NULL,
  `vizyon` text NOT NULL,
  `degerler` text NOT NULL,
  `kurulus_yili` varchar(20) NOT NULL DEFAULT '2016',
  `sehir` varchar(100) NOT NULL DEFAULT 'İstanbul',
  `proje_sayisi` int(11) NOT NULL DEFAULT 150,
  `aktif_musteri` int(11) NOT NULL DEFAULT 50,
  `uzman_ekip` int(11) NOT NULL DEFAULT 25,
  `memnuniyet` varchar(20) NOT NULL DEFAULT '98%',
  `hedef_kitle_baslik` varchar(255) NOT NULL,
  `hedef_kitle_aciklama` text NOT NULL,
  `hedef_kitle_json` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `hakkimizda_icerik` (`baslik`, `alt_baslik`, `kisa_aciklama`, `aciklama_1`, `aciklama_2`, `misyon`, `vizyon`, `degerler`, `kurulus_yili`, `sehir`, `proje_sayisi`, `aktif_musteri`, `uzman_ekip`, `memnuniyet`, `hedef_kitle_baslik`, `hedef_kitle_aciklama`, `hedef_kitle_json`) VALUES
('Hakkımızda', 'Teknoloji ile geleceği birlikte şekillendiriyoruz', 'TechNova Yazılım A.Ş., 2016 yılında İstanbul'da kurulan, yazılım, web geliştirme, mobil uygulama ve siber güvenlik alanlarında uzmanlaşmış bir teknoloji şirketidir.', 'Kurumsal ve KOBİ ölçeğindeki işletmelere özel, sürdürülebilir dijital çözümler üreterek 150''den fazla başarılı projeyi hayata geçirdik. Müşteri odaklı yaklaşımımız ve yenilikçi teknoloji anlayışımızla sektörde güvenilir bir referans haline geldik.', 'Her ölçekteki işletmeye özel, ölçeklenebilir ve sürdürülebilir dijital çözümler üreterek iş süreçlerini optimize etmek ve rekabet avantajı sağlamak.', 'Her ölçekteki işletmeye özel, sürdürülebilir dijital çözümler üretmek.', 'Türkiye''nin en güvenilir yazılım ve teknoloji ortağı olmak; inovatif çözümlerimizle global pazarda söz sahibi bir marka haline gelmek.', 'Yenilikçilik, Şeffaflık, Kalite, Müşteri Odaklılık, Güvenilirlik, Sürdürülebilirlik', '2016', 'İstanbul', 150, 50, 25, '98%', 'Hedef Kitlemiz', 'KOBİ''lerden holdinglere, startuplardan kamu kurumlarına kadar geniş bir yelpazede hizmet veriyoruz.', '[{"icon":"bi-building","title":"Kurumsal Şirketler","text":"Dijital dönüşüm ve kurumsal yazılım projeleri"},{"icon":"bi-lightning","title":"Startup\'lar","text":"MVP geliştirme ve hızlı ürün lansmanı"},{"icon":"bi-shop","title":"KOBİ\'ler","text":"E-ticaret ve işletme yönetim sistemleri"},{"icon":"bi-bank","title":"Kamu Kurumları","text":"Güvenli ve ölçeklenebilir devlet projeleri"}]');

-- --------------------------------------------------------
-- Tablo: blog
-- --------------------------------------------------------
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `ozet` text DEFAULT NULL,
  `icerik` longtext NOT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `yazar_id` int(11) DEFAULT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `durum` enum('yayinda','taslak') NOT NULL DEFAULT 'yayinda',
  PRIMARY KEY (`id`),
  KEY `yazar_id` (`yazar_id`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`yazar_id`) REFERENCES `kullanicilar` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog` (`baslik`, `ozet`, `icerik`, `resim`, `kategori`, `yazar_id`, `tarih`) VALUES
('Yapay Zeka ve Yazılım Geliştirmenin Geleceği', 'Yapay zekanın yazılım dünyasına etkileri ve gelecek trendler.', '<p>Yapay zeka, yazılım geliştirme süreçlerini köklü biçimde dönüştürmektedir. Kod asistanları, otomatik test araçları ve akıllı DevOps çözümleri artık standart hale geliyor.</p><p>TechNova olarak bu dönüşümün öncüsü olmak için AR-GE çalışmalarımızı sürdürüyoruz.</p>', 'blog1.jpg', 'Teknoloji', 1, NOW()),
('Mobil Uygulama Geliştirmede En İyi Pratikler', 'iOS ve Android geliştirme için kritik ipuçları.', '<p>Başarılı bir mobil uygulama için kullanıcı deneyimi, performans ve güvenlik üçgenini iyi yönetmek gerekir. Bu yazıda pratik önerilerimizi paylaşıyoruz.</p>', 'blog2.jpg', 'Mobil', 1, NOW()),
('Siber Güvenlikte 2025 Tehditleri', 'Şirketleri bekleyen siber güvenlik riskleri ve çözüm yolları.', '<p>Ransomware saldırıları ve veri ihlalleri her geçen gün artmaktadır. Kurumsal güvenlik stratejinizi güncellemenin tam zamanı.</p>', 'blog3.jpg', 'Siber Güvenlik', 1, NOW());

-- --------------------------------------------------------
-- Tablo: mesajlar
-- --------------------------------------------------------
CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `konu` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `okundu` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tablo: hizmetler
-- --------------------------------------------------------
CREATE TABLE `hizmetler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hizmet_adi` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `icon` varchar(100) DEFAULT 'bi-gear',
  `resim` varchar(255) DEFAULT NULL,
  `sira` int(11) NOT NULL DEFAULT 0,
  `durum` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `hizmetler` (`hizmet_adi`, `aciklama`, `icon`, `sira`) VALUES
('Web Geliştirme', 'Modern, hızlı ve ölçeklenebilir web uygulamaları geliştiriyoruz. HTML5, CSS3, PHP ve veritabanı entegrasyonu ile kurumsal çözümler sunuyoruz.', 'bi-globe', 1),
('Mobil Uygulama', 'iOS ve Android platformları için native ve cross-platform mobil uygulamalar geliştiriyor, kullanıcı deneyimini ön planda tutuyor.', 'bi-phone', 2),
('Siber Güvenlik', 'Penetrasyon testleri, güvenlik denetimleri ve kurumsal güvenlik danışmanlığı ile verilerinizi koruma altına alıyoruz.', 'bi-shield-lock', 3),
('Bulut Çözümleri', 'AWS, Azure ve Google Cloud platformlarında altyapı kurulumu, yönetimi ve optimizasyon hizmetleri sunuyoruz.', 'bi-cloud', 4),
('Yazılım Danışmanlığı', 'Dijital dönüşüm süreçlerinizde stratejik yazılım danışmanlığı ve proje yönetimi hizmetleri veriyoruz.', 'bi-lightbulb', 5),
('Veri Analitiği', 'İş zekası, raporlama ve yapay zeka destekli veri analizi çözümleriyle kararlarınızı veriye dayandırın.', 'bi-bar-chart', 6);

COMMIT;
