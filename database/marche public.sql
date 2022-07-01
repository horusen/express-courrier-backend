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

-- Listage de la structure de la table express-courrier. mp_affectation_etape_type_procedure
DROP TABLE IF EXISTS `mp_affectation_etape_type_procedure`;
CREATE TABLE IF NOT EXISTS `mp_affectation_etape_type_procedure` (
  `id_pivot` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `etape` bigint(20) unsigned NOT NULL,
  `type` bigint(20) unsigned NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pivot`),
  KEY `mp_affectation_etape_type_procedure_etape_foreign` (`etape`),
  KEY `mp_affectation_etape_type_procedure_inscription_id_foreign` (`inscription_id`),
  KEY `mp_affectation_etape_type_procedure_type_foreign` (`type`),
  CONSTRAINT `mp_affectation_etape_type_procedure_etape_foreign` FOREIGN KEY (`etape`) REFERENCES `mp_etape` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_affectation_etape_type_procedure_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_affectation_etape_type_procedure_type_foreign` FOREIGN KEY (`type`) REFERENCES `mp_type_procedure` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table express-courrier. mp_affectation_marche_fichier
DROP TABLE IF EXISTS `mp_affectation_marche_fichier`;
CREATE TABLE IF NOT EXISTS `mp_affectation_marche_fichier` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `marche` bigint(20) unsigned NOT NULL,
  `fichier` bigint(20) unsigned NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_affectation_marche_fichier_fichier_foreign` (`fichier`),
  KEY `mp_affectation_marche_fichier_inscription_id_foreign` (`inscription_id`),
  KEY `mp_affectation_marche_fichier_marche_foreign` (`marche`),
  CONSTRAINT `mp_affectation_marche_fichier_fichier_foreign` FOREIGN KEY (`fichier`) REFERENCES `fichier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_affectation_marche_fichier_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_affectation_marche_fichier_marche_foreign` FOREIGN KEY (`marche`) REFERENCES `mp_marche_etape` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table express-courrier. mp_etape
DROP TABLE IF EXISTS `mp_etape`;
CREATE TABLE IF NOT EXISTS `mp_etape` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `description` text,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_etape_inscription_id_foreign` (`inscription_id`),
  CONSTRAINT `mp_etape_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table express-courrier. mp_marche
DROP TABLE IF EXISTS `mp_marche`;
CREATE TABLE IF NOT EXISTS `mp_marche` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `service_contractant_id` bigint(20) unsigned DEFAULT NULL,
  `type_procedure_id` bigint(20) unsigned DEFAULT NULL,
  `type_marche_id` bigint(20) unsigned DEFAULT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_marche_inscription_id_foreign` (`inscription_id`),
  KEY `mp_marche_service_contractant_id_foreign` (`service_contractant_id`),
  KEY `mp_marche_type_marche_id_foreign` (`type_marche_id`),
  KEY `mp_marche_type_procedure_id_foreign` (`type_procedure_id`),
  CONSTRAINT `mp_marche_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_marche_service_contractant_id_foreign` FOREIGN KEY (`service_contractant_id`) REFERENCES `structures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_marche_type_marche_id_foreign` FOREIGN KEY (`type_marche_id`) REFERENCES `mp_type_marche` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_marche_type_procedure_id_foreign` FOREIGN KEY (`type_procedure_id`) REFERENCES `mp_type_procedure` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table express-courrier. mp_marche_etape
DROP TABLE IF EXISTS `mp_marche_etape`;
CREATE TABLE IF NOT EXISTS `mp_marche_etape` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) NOT NULL,
  `description` text,
  `position` bigint(20) unsigned DEFAULT '0',
  `marche_id` bigint(20) unsigned NOT NULL,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_marche_etape_inscription_id_foreign` (`inscription_id`),
  KEY `mp_marche_etape_marche_id_foreign` (`marche_id`),
  CONSTRAINT `mp_marche_etape_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mp_marche_etape_marche_id_foreign` FOREIGN KEY (`marche_id`) REFERENCES `mp_marche` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

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

-- Les données exportées n'étaient pas sélectionnées.

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

-- Les données exportées n'étaient pas sélectionnées.

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

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
