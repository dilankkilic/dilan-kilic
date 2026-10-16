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
('Admin', 'TechNova', 'admin@technova.com.tr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

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
('Mobil Uygulama', 'iOS ve Android platformları için native ve cross-platform mobil uygulamalar geliştiriyor, kullanıcı deneyimini ön planda tutuyoruz.', 'bi-phone', 2),
('Siber Güvenlik', 'Penetrasyon testleri, güvenlik denetimleri ve kurumsal güvenlik danışmanlığı ile verilerinizi koruma altına alıyoruz.', 'bi-shield-lock', 3),
('Bulut Çözümleri', 'AWS, Azure ve Google Cloud platformlarında altyapı kurulumu, yönetimi ve optimizasyon hizmetleri sunuyoruz.', 'bi-cloud', 4),
('Yazılım Danışmanlığı', 'Dijital dönüşüm süreçlerinizde stratejik yazılım danışmanlığı ve proje yönetimi hizmetleri veriyoruz.', 'bi-lightbulb', 5),
('Veri Analitiği', 'İş zekası, raporlama ve yapay zeka destekli veri analizi çözümleriyle kararlarınızı veriye dayandırın.', 'bi-bar-chart', 6);

COMMIT;
