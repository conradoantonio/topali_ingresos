/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.1.21-MariaDB : Database - topali
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`topali` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `topali`;

/*Table structure for table `casas` */

DROP TABLE IF EXISTS `casas`;

CREATE TABLE `casas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio_casa` varchar(20) DEFAULT NULL,
  `coto_id` int(11) DEFAULT NULL,
  `subcoto_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `dirección` text,
  `calle_manzana` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `casas` */

/*Table structure for table `cotos` */

DROP TABLE IF EXISTS `cotos`;

CREATE TABLE `cotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `direccion` text,
  `telefono_1` varchar(18) DEFAULT NULL,
  `nombre_responsable` varchar(255) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `guardia_users_id` int(11) DEFAULT NULL,
  `num_lugares` int(11) DEFAULT NULL,
  `tipo_servicio` int(11) DEFAULT NULL,
  `unidad_privativa` varchar(255) DEFAULT NULL,
  `id_estado` int(3) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cotos` */

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(200) DEFAULT NULL,
  `direccion` text,
  `telefono_1` varchar(18) DEFAULT NULL,
  `extension_tel_1` varchar(7) DEFAULT NULL,
  `telefono_2` varchar(18) DEFAULT NULL,
  `extension_tel_2` varchar(7) DEFAULT NULL,
  `nombre_responsable` varchar(255) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `negocios_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `departamentos` */

/*Table structure for table `estados` */

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `estados` */

insert  into `estados`(`id_estado`,`estado`) values (1,'Aguascalientes'),(2,'Baja California'),(3,'Baja California Sur'),(4,'Campeche'),(5,'Chiapas'),(6,'Chihuahua'),(7,'Coahuila'),(8,'Colima'),(9,'Distrito Federal'),(10,'Durango'),(11,'Estado de México'),(12,'Guanajuato'),(13,'Guerrero'),(14,'Hidalgo'),(15,'Jalisco'),(16,'Michoacán'),(17,'Morelos'),(18,'Nayarit'),(19,'Nuevo León'),(20,'Oaxaca'),(21,'Puebla'),(22,'Querétaro'),(23,'Quintana Roo'),(24,'San Luis Potosí'),(25,'Sinaloa'),(26,'Sonora'),(27,'Tabasco'),(28,'Tamaulipas'),(29,'Tlaxcala'),(30,'Veracruz'),(31,'Yucatán'),(32,'Zacatecas');

/*Table structure for table `guardias` */

DROP TABLE IF EXISTS `guardias`;

CREATE TABLE `guardias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coto_id` int(11) DEFAULT NULL,
  `subcoto_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `guardias` */

/*Table structure for table `ingresos` */

DROP TABLE IF EXISTS `ingresos`;

CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ingreso` int(11) DEFAULT NULL COMMENT 'Determina si es coto o negocio (1 => coto, 2 => negocio)',
  `main_id` int(11) unsigned DEFAULT NULL,
  `sub_id` int(11) DEFAULT NULL,
  `casa_id` int(11) DEFAULT NULL,
  `tipo_visita_id` int(11) DEFAULT NULL,
  `comentarios` text,
  `personas_id` int(11) DEFAULT NULL,
  `va_con` varchar(255) DEFAULT NULL COMMENT 'Es la persona con la que va, no necesariamente es el responsable de la casa.',
  `egreso` tinyint(4) NOT NULL DEFAULT '0',
  `hora_egreso` timestamp NULL DEFAULT NULL COMMENT 'Hora a la que sale la persona',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ingresos` */

/*Table structure for table `negocios` */

DROP TABLE IF EXISTS `negocios`;

CREATE TABLE `negocios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `nombre_comercial` varchar(255) DEFAULT NULL,
  `direccion` text,
  `telefono_1` varchar(18) DEFAULT NULL,
  `extension_tel_1` varchar(7) DEFAULT NULL,
  `telefono_2` varchar(18) DEFAULT NULL,
  `extension_tel_2` varchar(7) DEFAULT NULL,
  `nombre_responsable` varchar(255) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `negocios` */

/*Table structure for table `personas` */

DROP TABLE IF EXISTS `personas`;

CREATE TABLE `personas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_persona` varchar(255) DEFAULT NULL,
  `foto_identificacion` varchar(200) DEFAULT NULL,
  `foto_personal` varchar(200) DEFAULT NULL,
  `texto_placa` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `personas` */

/*Table structure for table `privilegios` */

DROP TABLE IF EXISTS `privilegios`;

CREATE TABLE `privilegios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `privilegios` */

insert  into `privilegios`(`id`,`tipo`,`created_at`,`updated_at`) values (1,'Super Administrador','2017-05-24 11:17:58','0000-00-00 00:00:00'),(2,'Administrador Coto','2017-05-24 11:20:38','0000-00-00 00:00:00'),(3,'Administrador Negocio','2017-06-05 09:22:15','0000-00-00 00:00:00'),(4,'Administrador subcoto','2017-06-05 09:22:25','0000-00-00 00:00:00'),(5,'Administrador departamento','2017-06-05 09:22:31','0000-00-00 00:00:00'),(6,'Guardia','2017-06-22 00:06:51','0000-00-00 00:00:00'),(7,'Casa','2017-06-22 00:07:03','0000-00-00 00:00:00');

/*Table structure for table `registro_logs` */

DROP TABLE IF EXISTS `registro_logs`;

CREATE TABLE `registro_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fechaLogin` date DEFAULT NULL,
  `realTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

/*Data for the table `registro_logs` */

insert  into `registro_logs`(`id`,`user_id`,`fechaLogin`,`realTime`) values (25,4,'2017-05-18',NULL),(26,4,'2017-05-18','2017-05-18 14:05:53'),(27,4,'2017-05-18','2017-05-18 14:06:13'),(28,5,'2017-05-18',NULL),(29,4,'2017-05-18','2017-05-18 14:17:44'),(30,4,'2017-05-18',NULL),(31,4,'2017-05-18','2017-05-18 14:48:54'),(32,1,'2017-05-18','2017-05-18 14:49:12'),(33,1,'2017-05-18','2017-05-18 14:49:16'),(34,1,'2017-05-18','2017-05-18 14:50:13'),(35,4,'2017-05-18','2017-05-18 14:50:49'),(36,4,'2017-05-18','2017-05-18 14:50:56'),(37,1,'2017-05-18','2017-05-18 14:51:14'),(38,4,'2017-05-18','2017-05-18 14:52:15'),(39,9,'2017-05-19',NULL),(40,10,'2017-05-19',NULL),(41,11,'2017-05-19',NULL),(42,11,'2017-05-19','2017-05-19 15:51:27'),(43,11,'2017-05-19','2017-05-19 16:00:58'),(44,11,'2017-05-19','2017-05-19 16:01:34'),(45,1,'2017-05-19','2017-05-19 16:02:42'),(46,1,'2017-05-19','2017-05-19 16:02:51'),(47,12,'2017-05-19',NULL),(48,13,'2017-05-19',NULL),(49,14,'2017-05-19',NULL),(50,15,'2017-05-19',NULL),(51,16,'2017-05-19',NULL),(52,17,'2017-05-19',NULL),(53,18,'2017-05-19',NULL),(54,19,'2017-05-19',NULL),(55,19,'2017-05-19','2017-05-19 16:15:50'),(56,9,'2017-05-19',NULL),(57,9,'2017-05-19','2017-05-19 16:19:33'),(58,10,'2017-05-19',NULL),(59,10,'2017-05-19','2017-05-19 16:26:56'),(60,11,'2017-05-19',NULL),(61,9,'2017-05-19','2017-05-19 16:39:04'),(62,10,'2017-05-19','2017-05-19 16:39:47'),(63,10,'2017-05-19','2017-05-19 16:48:09'),(64,12,'2017-05-19',NULL),(65,10,'2017-05-19','2017-05-19 17:00:02'),(66,1,'2017-05-21','2017-05-21 12:43:26'),(67,1,'2017-05-21','2017-05-21 12:44:15'),(68,5,'2017-05-22','2017-05-22 09:01:00'),(69,5,'2017-05-22','2017-05-22 09:02:45'),(70,5,'2017-05-22','2017-05-22 09:04:05'),(71,1,'2017-05-22','2017-05-22 09:07:12'),(72,10,'2017-05-22','2017-05-22 09:16:02'),(73,1,'2017-05-22','2017-05-22 09:17:24'),(74,10,'2017-05-22','2017-05-22 09:17:35'),(75,10,'2017-05-22','2017-05-22 09:19:58'),(76,10,'2017-05-22','2017-05-22 09:41:17'),(77,10,'2017-05-22','2017-05-22 09:42:11'),(78,10,'2017-05-22','2017-05-22 09:43:24'),(79,10,'2017-05-22','2017-05-22 09:45:11'),(80,10,'2017-05-22','2017-05-22 09:51:31'),(81,10,'2017-05-22','2017-05-22 10:14:41'),(82,10,'2017-05-22','2017-05-22 10:29:35'),(83,1,'2017-05-22','2017-05-22 11:45:29'),(84,10,'2017-05-22','2017-05-22 11:55:02'),(85,10,'2017-05-22','2017-05-22 11:55:13'),(86,10,'2017-05-22','2017-05-22 11:57:29'),(87,10,'2017-05-22','2017-05-22 12:43:42'),(88,10,'2017-05-22','2017-05-22 12:44:18'),(89,10,'2017-05-22','2017-05-22 12:51:45'),(90,10,'2017-05-22','2017-05-22 12:52:49'),(91,10,'2017-05-22','2017-05-22 13:39:56'),(92,10,'2017-05-22','2017-05-22 13:44:07'),(93,10,'2017-05-23','2017-05-23 10:45:41');

/*Table structure for table `sexo` */

DROP TABLE IF EXISTS `sexo`;

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `sexo` */

insert  into `sexo`(`id`,`tipo`) values (1,'Femenino'),(2,'Masculino');

/*Table structure for table `solicitudes_ingreso` */

DROP TABLE IF EXISTS `solicitudes_ingreso`;

CREATE TABLE `solicitudes_ingreso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `casa_id` int(11) DEFAULT NULL,
  `mensaje` text,
  `status` tinyint(4) DEFAULT '0',
  `persona_id` int(11) DEFAULT NULL,
  `tipo_visita` int(11) DEFAULT NULL,
  `fecha_visita` date DEFAULT NULL,
  `hora_visita` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `solicitudes_ingreso` */

/*Table structure for table `subcotos` */

DROP TABLE IF EXISTS `subcotos`;

CREATE TABLE `subcotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_subcoto` varchar(200) DEFAULT NULL,
  `direccion` text,
  `telefono_1` varchar(18) DEFAULT NULL,
  `extension_tel_1` varchar(7) DEFAULT NULL,
  `telefono_2` varchar(18) DEFAULT NULL,
  `extension_tel_2` varchar(7) DEFAULT NULL,
  `nombre_responsable` varchar(255) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `cotos_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subcotos` */

/*Table structure for table `tipo_servicios` */

DROP TABLE IF EXISTS `tipo_servicios`;

CREATE TABLE `tipo_servicios` (
  `id` int(11) DEFAULT NULL,
  `servicio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tipo_servicios` */

insert  into `tipo_servicios`(`id`,`servicio`) values (1,'Coto');

/*Table structure for table `tipo_visita` */

DROP TABLE IF EXISTS `tipo_visita`;

CREATE TABLE `tipo_visita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tipo_visita` */

insert  into `tipo_visita`(`id`,`tipo`,`created_at`,`updated_at`) values (1,'Visita','2017-06-07 16:17:54',NULL),(2,'Proveedor','2017-06-07 16:17:59',NULL),(3,'Trabajador','2017-06-07 16:18:08',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` text NOT NULL,
  `correo` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contra` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(100) NOT NULL DEFAULT 'img/img_users/default.jpg',
  `privilegios_id` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`nombre_completo`,`correo`,`password`,`contra`,`foto_perfil`,`privilegios_id`,`status`,`remember_token`,`created_at`,`updated_at`) values (1,'Topali Admin','admin_sistemas@topali.com.mx','$2y$10$uDFxSNYdiU7V34TWkyyyDe870fHHBUcQU7m0Jck9hFaZSDeeJRH4q','contra','img/img_users/default.jpg',1,1,'poIy0a0mCXzGN5cOMK4iGmh02yc54FxVe6YtemBM2fIc3uzgqGrmxNMWT3LA','2017-07-19 10:04:17','2017-07-26 15:08:26');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
