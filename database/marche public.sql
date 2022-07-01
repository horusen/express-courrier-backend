-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de la table express-courrier. mp_type_marche
DROP TABLE IF EXISTS `mp_type_marche`;
CREATE TABLE IF NOT EXISTS `mp_type_marche` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_type_marche_inscription_id_foreign` (`inscription_id`),
  CONSTRAINT `mp_type_marche_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.mp_type_marche : ~2 rows (environ)
DELETE FROM `mp_type_marche`;
/*!40000 ALTER TABLE `mp_type_marche` DISABLE KEYS */;
INSERT INTO `mp_type_marche` (`id`, `libelle`, `inscription_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Services', 1, '2022-06-23 14:09:45', '2022-06-23 14:10:32', NULL),
	(2, 'Fournitures', 1, '2022-06-23 14:10:07', '2022-06-23 14:10:26', NULL),
	(3, 'Travaux', 1, '2022-06-23 14:10:21', '2022-06-23 14:10:21', NULL);
/*!40000 ALTER TABLE `mp_type_marche` ENABLE KEYS */;

-- Listage de la structure de la table express-courrier. mp_type_procedure
DROP TABLE IF EXISTS `mp_type_procedure`;
CREATE TABLE IF NOT EXISTS `mp_type_procedure` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_type_procedure_inscription_id_foreign` (`inscription_id`),
  KEY `mp_type_procedure_type_id_foreign` (`type_id`),
  CONSTRAINT `mp_type_procedure_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_type_procedure_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `mp_type_procedure` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.mp_type_procedure : ~8 rows (environ)
DELETE FROM `mp_type_procedure`;
/*!40000 ALTER TABLE `mp_type_procedure` DISABLE KEYS */;
INSERT INTO `mp_type_procedure` (`id`, `libelle`, `inscription_id`, `type_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Appel d\'offre', 1, NULL, '2022-06-23 15:34:31', '2022-06-23 15:34:31', NULL),
	(2, 'DRP', 1, NULL, '2022-06-23 15:34:33', '2022-06-23 15:34:33', NULL),
	(3, 'Prestation Intellectuelle', 1, NULL, '2022-06-23 15:34:52', '2022-06-23 15:34:52', NULL),
	(4, 'Entente directe', 1, NULL, '2022-06-23 15:35:09', '2022-06-28 13:45:02', NULL),
	(5, 'Appel d\'offre intellectuel', 1, NULL, '2022-06-23 15:35:19', '2022-06-30 13:49:01', NULL),
	(6, 'Competition Simple', 1, 2, '2022-06-23 15:35:43', '2022-06-23 15:35:43', NULL),
	(7, 'Competition Restrainte', 1, 2, '2022-06-23 15:35:51', '2022-06-23 15:35:51', NULL),
	(8, 'Competition Ouverte', 1, 2, '2022-06-23 15:36:17', '2022-06-23 15:36:17', NULL);
/*!40000 ALTER TABLE `mp_type_procedure` ENABLE KEYS */;

-- Listage de la structure de la table express-courrier. mp_type_procedure_etape
DROP TABLE IF EXISTS `mp_type_procedure_etape`;
CREATE TABLE IF NOT EXISTS `mp_type_procedure_etape` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `description` text,
  `position` bigint(20) unsigned DEFAULT '0',
  `type_procedure_id` bigint(20) unsigned NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_type_procedure_etape_inscription_id_foreign` (`inscription_id`),
  KEY `mp_type_procedure_etape_type_procedure_id_foreign` (`type_procedure_id`),
  CONSTRAINT `mp_type_procedure_etape_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_type_procedure_etape_type_procedure_id_foreign` FOREIGN KEY (`type_procedure_id`) REFERENCES `mp_type_procedure` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.mp_type_procedure_etape : ~22 rows (environ)
DELETE FROM `mp_type_procedure_etape`;
/*!40000 ALTER TABLE `mp_type_procedure_etape` DISABLE KEYS */;
INSERT INTO `mp_type_procedure_etape` (`id`, `libelle`, `description`, `position`, `type_procedure_id`, `inscription_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'LETTRE D\'INVITATION', NULL, 0, 2, 1, '2022-06-24 11:18:37', '2022-06-24 11:18:37', NULL),
	(2, 'PROPOSITION DE PRIX SUR FACTURE PROFORMA', NULL, 1, 2, 1, '2022-06-24 11:22:08', '2022-06-24 11:22:08', NULL),
	(3, 'PV D\'OUVERTURE DES OFFRES', NULL, 2, 2, 1, '2022-06-24 11:22:19', '2022-06-24 11:22:19', NULL),
	(4, 'RAPPORT D\'EVALUATION DES OFFRES', NULL, 3, 2, 1, '2022-06-24 11:22:30', '2022-06-24 11:22:30', NULL),
	(5, 'PV D\'ATTRIBUTION DES OFFRES', NULL, 4, 2, 1, '2022-06-24 11:22:40', '2022-06-24 11:22:40', NULL),
	(6, 'PV D\'ATTRIBUTION PROVISOIRES', NULL, 5, 2, 1, '2022-06-24 11:22:52', '2022-06-24 11:22:52', NULL),
	(7, 'CONTRATS', NULL, 6, 2, 1, '2022-06-24 11:23:02', '2022-06-24 11:23:02', NULL),
	(8, 'BORDEREAU DE LIVRAISON', NULL, 7, 2, 1, '2022-06-24 11:23:12', '2022-06-24 11:23:12', NULL),
	(9, 'PV DE RECEPTIONS', NULL, 8, 2, 1, '2022-06-24 11:23:22', '2022-06-24 11:23:22', NULL),
	(10, 'FACTURE DEFINITIVE', NULL, 9, 2, 1, '2022-06-24 11:23:34', '2022-06-24 11:23:34', NULL),
	(11, 'PAIEMENT', NULL, 10, 2, 1, '2022-06-24 11:23:52', '2022-06-24 11:23:52', NULL),
	(12, 'PUBLICATION DE L\'APPEL D\'OFFRE', NULL, 0, 1, 1, '2022-06-24 11:24:13', '2022-06-28 14:33:04', NULL),
	(13, 'PV D\'OUVERTURE DES OFFRES', NULL, 1, 1, 1, '2022-06-24 11:24:24', '2022-06-24 11:24:24', NULL),
	(14, 'RAPPORT D\'EVALUATION DES OFFRES', NULL, 2, 1, 1, '2022-06-24 11:24:34', '2022-06-24 11:24:34', NULL),
	(15, 'PV D\'ATTRIBUTION DES OFFRES', NULL, 3, 1, 1, '2022-06-24 11:24:47', '2022-06-24 11:24:47', NULL),
	(16, 'PV D\'ATTRIBUTION PROVISOIRES', NULL, 4, 1, 1, '2022-06-24 11:25:00', '2022-06-24 11:25:00', NULL),
	(17, 'PUBLICATION DE L\'AVIS D\'ATTRIBUTION PROVISOIRE', NULL, 5, 1, 1, '2022-06-24 11:25:10', '2022-06-24 11:25:10', NULL),
	(18, 'CONTRATS', NULL, 6, 1, 1, '2022-06-24 11:25:19', '2022-06-24 11:25:19', NULL),
	(19, 'BORDEREAU DE LIVRAISON', NULL, 7, 1, 1, '2022-06-24 11:25:30', '2022-06-24 11:25:30', NULL),
	(20, 'PV DE RECEPTIONS', NULL, 8, 1, 1, '2022-06-24 11:25:38', '2022-06-24 11:25:38', NULL),
	(21, 'FACTURE DEFINITIVE', NULL, 9, 1, 1, '2022-06-24 11:25:49', '2022-06-24 11:25:49', NULL),
	(22, 'PAIEMENT', NULL, 10, 1, 1, '2022-06-24 11:26:02', '2022-06-24 11:26:02', NULL);
/*!40000 ALTER TABLE `mp_type_procedure_etape` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
