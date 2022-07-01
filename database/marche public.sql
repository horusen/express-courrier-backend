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

-- Listage de la structure de la table express-courrier. cr_form_field
DROP TABLE IF EXISTS `cr_form_field`;
CREATE TABLE IF NOT EXISTS `cr_form_field` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `label` varchar(191) NOT NULL,
  `value` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `validators_id` bigint(20) unsigned DEFAULT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cr_form_field_inscription_id_foreign` (`inscription_id`),
  KEY `cr_form_field_validators_id_foreign` (`validators_id`),
  CONSTRAINT `cr_form_field_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cr_form_field_validators_id_foreign` FOREIGN KEY (`validators_id`) REFERENCES `cr_form_field_validator` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.cr_form_field : ~0 rows (environ)
DELETE FROM `cr_form_field`;
/*!40000 ALTER TABLE `cr_form_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `cr_form_field` ENABLE KEYS */;

-- Listage de la structure de la table express-courrier. cr_form_field_validator
DROP TABLE IF EXISTS `cr_form_field_validator`;
CREATE TABLE IF NOT EXISTS `cr_form_field_validator` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `required` tinyint(1) NOT NULL,
  `requiredTrue` tinyint(1) NOT NULL,
  `email` tinyint(1) NOT NULL,
  `minLength` tinyint(1) NOT NULL,
  `maxLength` tinyint(1) NOT NULL,
  `nullValidator` tinyint(1) NOT NULL,
  `patern` varchar(191) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cr_form_field_validator_inscription_id_foreign` (`inscription_id`),
  CONSTRAINT `cr_form_field_validator_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.cr_form_field_validator : ~0 rows (environ)
DELETE FROM `cr_form_field_validator`;
/*!40000 ALTER TABLE `cr_form_field_validator` DISABLE KEYS */;
/*!40000 ALTER TABLE `cr_form_field_validator` ENABLE KEYS */;

-- Listage de la structure de la table express-courrier. cr_form_field_value
DROP TABLE IF EXISTS `cr_form_field_value`;
CREATE TABLE IF NOT EXISTS `cr_form_field_value` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `objet_type` varchar(191) NOT NULL,
  `objet_id` bigint(20) unsigned NOT NULL,
  `form_field_id` bigint(20) unsigned NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cr_form_field_value_form_field_id_foreign` (`form_field_id`),
  KEY `cr_form_field_value_inscription_id_foreign` (`inscription_id`),
  CONSTRAINT `cr_form_field_value_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `cr_form_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cr_form_field_value_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.cr_form_field_value : ~0 rows (environ)
DELETE FROM `cr_form_field_value`;
/*!40000 ALTER TABLE `cr_form_field_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `cr_form_field_value` ENABLE KEYS */;

-- Listage de la structure de la table express-courrier. cr_nature_form_field
DROP TABLE IF EXISTS `cr_nature_form_field`;
CREATE TABLE IF NOT EXISTS `cr_nature_form_field` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `label` varchar(191) NOT NULL,
  `value` varchar(191) DEFAULT NULL,
  `type` varchar(191) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `validators_id` bigint(20) unsigned DEFAULT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nature_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cr_nature_form_field_inscription_id_foreign` (`inscription_id`),
  KEY `cr_nature_form_field_nature_id_foreign` (`nature_id`),
  KEY `cr_nature_form_field_validators_id_foreign` (`validators_id`),
  CONSTRAINT `cr_nature_form_field_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cr_nature_form_field_nature_id_foreign` FOREIGN KEY (`nature_id`) REFERENCES `cr_nature` (`id`),
  CONSTRAINT `cr_nature_form_field_validators_id_foreign` FOREIGN KEY (`validators_id`) REFERENCES `cr_form_field_validator` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table express-courrier.cr_nature_form_field : ~5 rows (environ)
DELETE FROM `cr_nature_form_field`;
/*!40000 ALTER TABLE `cr_nature_form_field` DISABLE KEYS */;
INSERT INTO `cr_nature_form_field` (`id`, `libelle`, `label`, `value`, `type`, `required`, `validators_id`, `inscription_id`, `created_at`, `updated_at`, `deleted_at`, `nature_id`) VALUES
	(1, 'Numéro Facture', 'Numéro Facture', NULL, 'text', 1, NULL, 1, '2022-06-21 12:47:45', '2022-06-21 16:45:10', NULL, 2),
	(2, 'Devise', 'Devise', NULL, 'text', 1, NULL, 1, '2022-06-21 12:47:45', '2022-06-21 16:45:10', NULL, 2),
	(3, 'Montant', 'Montant', NULL, 'number', 1, NULL, 1, '2022-06-21 12:47:45', '2022-06-21 16:45:10', NULL, 2),
	(4, 'somme', 'somme', NULL, 'number', 1, NULL, 1, '2022-06-22 12:08:26', '2022-06-22 12:08:26', NULL, 1),
	(5, 'texte', 'texte', NULL, 'textarea', 1, NULL, 1, '2022-06-22 12:08:35', '2022-06-22 12:08:35', NULL, 1);
/*!40000 ALTER TABLE `cr_nature_form_field` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
