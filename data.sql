/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.1.36-MariaDB : Database - topali
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
  PRIMARY KEY (`id`),
  KEY `coto_id` (`coto_id`),
  KEY `users_id` (`users_id`),
  KEY `subcoto_id` (`subcoto_id`),
  CONSTRAINT `casas_ibfk_1` FOREIGN KEY (`coto_id`) REFERENCES `cotos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `casas_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `casas_ibfk_3` FOREIGN KEY (`subcoto_id`) REFERENCES `subcotos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `id_estado` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  KEY `guardia_users_id` (`guardia_users_id`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `cotos_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cotos_ibfk_2` FOREIGN KEY (`guardia_users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cotos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `cotos` */

insert  into `cotos`(`id`,`nombre`,`direccion`,`telefono_1`,`nombre_responsable`,`users_id`,`guardia_users_id`,`num_lugares`,`tipo_servicio`,`unidad_privativa`,`id_estado`,`status`,`created_at`,`updated_at`) values (1,'RAQUET CLUB','FRACC, RAQUET CLUB, RAUL RAMIREZ','3877610284','JONH MASON',3,2,100,1,'37',15,0,'2019-09-09 17:29:47','2019-09-09 22:29:47'),(2,'TORRE UNION','AV. UNION','655443332','VICTOR ARIAS',7,6,40,2,'163',15,0,'2017-12-01 10:35:41','2017-12-01 16:35:41'),(3,'Topali','Calle Juan Manuel','36182554','Lupita',13,12,10,2,'1058',15,0,'2018-04-11 12:00:38','2018-04-11 17:00:38'),(4,'TORRE UNION','AV. UNION No 163 COL. OBRERA CENTRO','3337004628','LIC. YESENIA JULISA MARTINEZ AYALA',18,17,20,2,'163',15,0,'2018-04-11 11:54:08','2018-04-11 16:54:08'),(5,'Topali','JUAN MANUEL','33317255444','Lupita',21,20,6,2,'1058',15,0,'2019-09-09 17:16:39','2019-09-09 22:16:39'),(6,'BRUNA','Lerdo de Tejada','33 20 03 09 04','ARTURO GONZALEZ',25,24,5,2,'2418',15,1,'2019-10-24 14:02:25','2019-10-24 19:02:25');

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
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `departamentos` */

/*Table structure for table `estados` */

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

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
  `main_id` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `casa_id` (`casa_id`),
  KEY `tipo_visita_id` (`tipo_visita_id`),
  KEY `personas_id` (`personas_id`),
  KEY `main_id` (`main_id`),
  KEY `sub_id` (`sub_id`),
  CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`casa_id`) REFERENCES `casas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingresos_ibfk_2` FOREIGN KEY (`tipo_visita_id`) REFERENCES `tipo_visita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingresos_ibfk_3` FOREIGN KEY (`personas_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingresos_ibfk_4` FOREIGN KEY (`main_id`) REFERENCES `cotos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingresos_ibfk_5` FOREIGN KEY (`sub_id`) REFERENCES `subcotos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `registro_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `registro_logs` */

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
  PRIMARY KEY (`id`),
  KEY `casa_id` (`casa_id`),
  KEY `persona_id` (`persona_id`),
  CONSTRAINT `solicitudes_ingreso_ibfk_1` FOREIGN KEY (`casa_id`) REFERENCES `casas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `solicitudes_ingreso_ibfk_2` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_completo` text NOT NULL,
  `correo` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contra` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(100) NOT NULL DEFAULT 'img/img_users/default.jpg',
  `privilegios_id` int(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`updated_at`),
  KEY `privilegios_id` (`privilegios_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`privilegios_id`) REFERENCES `privilegios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`nombre_completo`,`correo`,`password`,`contra`,`foto_perfil`,`privilegios_id`,`status`,`remember_token`,`created_at`,`updated_at`) values (1,'Topali Admin','admin_sistemas@topali.com.mx','$2y$10$uDFxSNYdiU7V34TWkyyyDe870fHHBUcQU7m0Jck9hFaZSDeeJRH4q','contra','img/img_users/1510364215.jpg',1,1,'pnVBwQKlCwkEp3Utsjgb0d1tppaQ2OD3Y5vDX7BpmV3X0NNhdDkqraJOTgb2','2017-07-19 10:04:17','2019-10-24 14:45:57'),(2,'RAQUET CLUB','graquet@topali.com.mx','$2y$10$6d9xYr54skVe5oGLdtVspOmvEgSO8CrWMxr0MUywDeOMaL8g5na/S','gRaquet2019','img/img_users/default.jpg',6,0,'MfYDn4MFhM22S1Ez0zDKjwSQ0rg8Ks1wN8JfXZNnvqHlb7YFyeFu9mNcmHYc','2017-08-01 20:56:39','2019-09-09 22:29:47'),(3,'JONH MASON','raquet@topali.com.mx','$2y$10$lTQNNgcYYTv20Gxzm6UYUeMLBUszSOenF47UWAYh/BkfRJ.UE04aK','Raquet2019','img/img_users/default.jpg',2,0,'nKCs1fLhepvwR2d95HI33VbMJPik7wQRSkcxaRmmUtQt4892bmLAGTfvGPQU','2017-08-01 20:56:39','2019-09-09 22:29:47'),(4,'CASA CLUB','casaclub@topali.com.mx','$2y$10$ZoIRgIWinhjbbSeMNL9QK.cSk8HCTUh2xvY5fkYs8ylcrZpUqLsbC','Casaclub','img/img_users/default.jpg',7,0,NULL,'2017-08-01 16:13:11','2019-09-09 22:29:47'),(5,'TAXI','taxi@topali.com.mx','$2y$10$vGQWQcWLdQP0VnmMQaGVOeEzSK2ygGe0.OQ0pA.qo3W8gWV2PmR3q','Taxi','img/img_users/default.jpg',7,0,NULL,'2017-08-01 16:28:07','2019-09-09 22:29:47'),(6,'LUPITA MAMA','gtorreunion@topali.com.mx','$2y$10$YfaP1MSTwJioVK1zDtPNmODrE7iF.Kf644h/bhhvt8KJtilaYaicm','gTorre','img/img_users/default.jpg',6,0,'vBJeXIWvoMAukYyt0b9pM6nCuIFDG106Rs8qEzTtya13i8E147JydWxsg4Qu','2017-08-01 21:34:36','2017-12-01 16:35:41'),(7,'TORRE UNION','torreunion@topali.com.mx','$2y$10$jb6Pzrcrcb/irR.I0MXetOMXrFlXKWEq300zQZIohenWSn.jtpTVO','TORREUNION2018!','img/img_users/default.jpg',2,0,'popdpJFPcZDKXxY6VJDFegN9so3q090PGjbSykbLS8d4mVEIo9o94MGdVAwk','2017-08-01 21:34:36','2018-04-11 16:53:48'),(8,'DR. VICTOR ARIAS','victor@topali.com.mx','$2y$10$t1NZbe5Q/1u/T.6E6OJM4.i.8jlPGM0kE2eVu7otdCouZzodEI1Hm','Victor','img/img_users/default.jpg',7,0,'H38hPxiK3KnVtUy8LhztDWqycm66gVYKGvB5JUEIPPNbnMCURjnv77XLZKm3','2017-08-01 16:37:51','2017-12-01 16:35:41'),(9,'PAQUETERIA','paqueteria@topali.com.mx','$2y$10$7/7Rk5dVFF2U530iZOIsC.yEG.CZS41SIz9/grhPaN5hfsSRTrh4G','Paqueteria','img/img_users/default.jpg',7,0,NULL,'2017-08-01 16:38:42','2017-12-01 16:35:41'),(10,'ENTREGA DE COMIDA','comida@topali.com.mx','$2y$10$nWGceAn/n478sBZ/GlEWku.OHHUJuZHxFLu6TxjqJFFC4Y8JsY.xi','Comida','img/img_users/default.jpg',7,0,NULL,'2017-08-01 17:15:12','2019-09-09 22:29:47'),(11,'MONTE COXALA','monte@topali.com.mx','$2y$10$QRJUCP8k/UMOZo9LVGGd4e5.LRC7aJPdrospNhI4ShVyvQomfptJq','Monte2017','img/img_users/default.jpg',7,0,'iDPGcdXH28iZqJhJYgGa7ekCC5smnrmlbT7wbbediwQMrko1lNMSeOZ1plYY','2017-08-01 17:23:50','2019-09-09 22:29:47'),(12,'Cesar Dominguez','c.dominguez@topali.com.mx','$2y$10$a8fBIMcgJCtAzekh8vqAHOXP78b4itqC0azxevk2oDJF8hIaAFg3u','CESAR2017','img/img_users/default.jpg',6,0,'by8ZUTS0Dq10dCb3KdTMMDIZhGfpBDxmhYRpljLmYGxCUrEbhxckMYtSLFHW','2017-09-21 23:17:24','2018-04-11 17:00:38'),(13,'Guardia','topali@topali.com.mx','$2y$10$042KhCSNV0ZtZve.oOwf/Of70ief0m4F9cWAKV4XknMw/PQKZrBBe','TOPALI2018','img/img_users/default.jpg',2,0,'I63UnVSyx4IxxrQ26TM5vRIhqy7gEwwc2FoIIPmBIp90j7T7J5rC7DsC4Nld','2017-09-21 23:17:24','2018-04-11 17:24:22'),(14,'EJEMPLO','DEMO@CORREO.COM','$2y$10$YuDu3y5RE849oHLY9I8mZ.umozr7vMCb1zMnKFqgR0QXPL8z0.l3S','1234','img/img_users/default.jpg',7,0,NULL,'2017-09-22 16:21:16','2018-04-11 17:00:38'),(15,'VICTOR ARIAS','sanfer@topali.com.mx','$2y$10$b59tOf8h7vVjIXNdT8vpx.ymihRANOVuQOaJj7EDLwrGOkwWOF7Gy','123','img/img_users/default.jpg',7,0,'Komfa7IotKjwvooZFmeji2JxJPPFmCGUXCIp6oNkf8x2GwcP5QIoNwLYFabR','2017-10-17 18:04:59','2018-04-11 17:00:38'),(16,'Alexis','alexis@gmail.com','$2y$10$4lJfiF.moPm2b4kzw.11KuuGUg9mYe9w8FGwzYP.Scj/aDPyAuyy.','123','img/img_users/default.jpg',7,0,NULL,'2017-10-24 17:36:43','2018-04-11 17:00:38'),(17,'TORRE UNION','torreunion@topali.com.mx','$2y$10$jb6Pzrcrcb/irR.I0MXetOMXrFlXKWEq300zQZIohenWSn.jtpTVO','TORREUNION2018!','img/img_users/default.jpg',6,0,NULL,'2017-12-01 17:59:28','2018-04-11 16:54:08'),(18,'LIC. YESENIA JULISA MARTINEZ AYALA','ymartinez@topali.com.mx','$2y$10$zlJKU3TzdCPvn.IZcIXpFuJhJdm68FhuZYTyD3xWvT8jnbfefxJNG','Torreunion2018','img/img_users/default.jpg',2,0,NULL,'2017-12-01 17:59:28','2018-04-11 16:54:08'),(19,'ADMINISTRACION TORRE UNION','administracion.torreunion@gmail.com','$2y$10$3EesUTQGicSc/Sk7Tbh/COGCcDQAvLkrLTDwGM1h.vF6n6Ci/zovq','37004628','img/img_users/default.jpg',7,0,NULL,'2017-12-01 12:42:03','2018-04-11 16:54:08'),(20,'Guardia','topali@topali.com.mx','$2y$10$042KhCSNV0ZtZve.oOwf/Of70ief0m4F9cWAKV4XknMw/PQKZrBBe','TOPALI2018','img/img_users/default.jpg',6,0,'u8I1Ffgh73pu49rjVLQyQLBfREJ2qJDxbu6e8rdLMdekHGVXyYVZjaFvOEJp','2018-04-11 17:02:29','2019-09-09 22:16:39'),(21,'Lupita','lupita@topali.com.mx','$2y$10$O3VjoUaniq4jZb9cE7SROufM9/lbRDQlRsAhtFgEiPlJDkx5ExKtS','TOPALI2018','img/img_users/default.jpg',2,0,'A3wU1gTBe0LkDbHk7ZsFu09f7qQq1vELETE3XmPkNKuBX4KI91gxFGWj28K7','2018-04-11 17:02:29','2019-09-09 22:16:39'),(22,'Cesar','cesar@topali.com.mx','$2y$10$tNethBUCR3F94hk1hvgi.ODY/u2rUzdfMfpw8Hs7NlRqCPvT0.34W','CESAR2018!','img/img_users/default.jpg',7,0,NULL,'2018-04-11 12:04:17','2019-09-09 22:16:39'),(23,'adalberto mendoza','topali2@topali.com.mx','$2y$10$AcGoqKnZRLlXPDjmO3T/g.xXQZltAtxhb46grtdExjQUIY13pfMue','1234','img/img_users/default.jpg',7,0,'hsC5t65cvYhUk3K6FsZiwL3dYzJDep06sE6BRvnPZIFYqPXzzIiFa2gPny9C','2018-04-14 12:27:06','2019-09-09 22:16:39'),(24,'Guardia Bruna','bruna@topali.com.mx','$2y$10$bhsl3VCod3wW/EJtU0/ufeDseHD8JGDJlf2jnromTlzPCZmIV5mzq','GBRUNA2019!','img/img_users/default.jpg',6,1,'BloBR8r5jwDRU1BshnYmtlpjXSRFrVhcNT7LDxHnlPyk2PnWtiRPL7PgLvNv','2019-09-09 23:13:56','2019-10-24 19:02:25'),(25,'ARTURO GONZALEZ','arturo@topali.com.mx','$2y$10$ve8Q.EbvYEEjgJhEuMTklOjCGTppay0ZRR0daM2gqxnwjbRkRuAAW','ARTURO2019!','img/img_users/default.jpg',2,1,NULL,'2019-09-09 23:13:56','2019-10-24 19:02:25'),(26,'cocina','gvsmedicall1@gmail.com','$2y$10$tlhCh72ephl7D8xa2AwUE.zR/VWByZwqUe4a5hLmi1..sW1qS412i','victor','img/img_users/default.jpg',7,0,NULL,'2019-09-10 17:03:42','2019-09-10 17:14:18'),(27,'Jorge Saucedo','a@gmail.com','$2y$10$CsBMuGrXWhMHZ3q7NzW3wu0LxDQ/18uRRXBhu6WUFCuPav0GOF4hi','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:09:58','2019-09-27 18:09:58'),(28,'Cesar Gallo','b@gmail.com','$2y$10$4/o6q3gIybiHBmjAiaoZHO8x6qiYtdqB0zPGrekS7A6k9EzUlyjOe','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:11:52','2019-09-27 18:11:52'),(29,'Emilio ','c@gmail.com','$2y$10$3NQwDxeiuTw3Lqif0vGn9OSNOIUoKZVdQmJoXy1nIffav56ueBplG','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:12:47','2019-09-27 18:12:47'),(30,'LUIS MANUEL MALDONADO','d@gmail.com','$2y$10$dPQ4m2EQexpFWnxyAwQF9eg5gcc1CAzcCwHYfesTpM9qKcggUM/HG','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:15:17','2019-09-27 18:15:17'),(31,'BLANCA NOEMI ARELLANO ','e@gmail.com','$2y$10$gP1pkl8BEY4vYpT1H/FwV.q2Vx8nVccyZXJGfByhJxP4MA.z9pi0u','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:16:02','2019-09-27 18:16:02'),(32,'RAFAEL GOMEZ','f@gmail.com','$2y$10$OieplWlrH6nKBdfCxf9eFOfzx4H/NOoQz1ZKKv6UJcGZiKhkt.DH6','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:16:30','2019-09-27 18:16:30'),(33,'MAITE VAZQUEZ','g@gmail.com','$2y$10$YgluZVZAFo0xzYjsT/8EX.SGG.FDTBaoJACCabGihsypnQm1yzove','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:17:06','2019-09-27 18:17:06'),(34,'PEDRO IVAN','h@gmail.com','$2y$10$41TIEmPp/MovmCv5kTguU.FCT.Q9nd74iNIz84SWVZYja/Vvu8wjy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:17:35','2019-09-27 18:17:35'),(35,'MARTIN RAMIREZ B','i@gmail.com','$2y$10$VAStCvj6LXgh2OcoX2kJwep8x980Nu5WgLR6nJGb56Ri2pTjuLueC','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:18:29','2019-09-27 18:18:29'),(36,'JUAN ANTONIO GARZA','j@gmail.com','$2y$10$s6aTsYB8rcBUd707SQyvue0ZklnX4iilkyyNeSay62EJbs4xD0d1m','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:18:58','2019-09-27 18:18:58'),(37,'MARCO SALAZAR','k@gmail.com','$2y$10$koBIu3JHaUVcbfm1lIffCOV/0pfTgzhMiyoY/Uop8KhoG6KnePXg.','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:19:39','2019-09-27 18:19:39'),(38,'Elizabeth Hernandez','l@gmail.com','$2y$10$6.PoO3GnPcWE72O.zV.tquqrDccvpdmuntiRhSKFrVbInPajFFCnC','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:20:38','2019-09-27 18:20:38'),(39,'Roberto Uribe','m@gmail.com','$2y$10$vCeXnPAz1Lawbw3RQKNw8uYSWCM2mUV8WXIg9BoOCev0auzXqC1f2','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:21:19','2019-09-27 18:21:19'),(40,'Jonhatan Hernandez','n@gmail.com','$2y$10$zxO4HNB4jg/F/Rc4U0j8KeFo91x8Dal650ASjGiJFnKCnymU9n8i2','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:21:47','2019-09-27 18:21:47'),(41,'Arturo Gonzalez','o@gmail.com','$2y$10$yaCX9kg7cJl1u2FImgh8f.kO7CbqnbAxEXggCn02DcfyBxKbd71hG','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:22:09','2019-09-27 18:22:09'),(42,'Fernando Hernandez','p@gmail.com','$2y$10$WMgY2HdqVTu1v17p655KCu5ZFLwfL9.onszvun8TXEtd624X8uKNK','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:22:35','2019-09-27 18:22:35'),(43,'Luis Hernandez','q@gmail.com','$2y$10$SBh5gZjt.OFB94KR/vh1x.q0gibKYoLTqDDBKED4370ht9AIhsgJ6','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:23:11','2019-09-27 18:23:11'),(44,'Luis Hernandez','q@gmail.com','$2y$10$Kkucak.l2Yhy1cuVzTCYTO4Mtx4xrIjJmRId2OeV13UunOv/eLWMO','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:23:11','2019-09-27 18:23:11'),(45,'Oscar Garza','r@gmail.com','$2y$10$uNHxWX6V7/8X5NHxWVei1.g2l.Lc3ueiyPkFFk.3gS3sJCpQwpL6K','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:23:51','2019-09-27 18:23:51'),(46,'Angie Alvarez ','ab@gmail.com','$2y$10$FagrrezV2/.7cbExY2LhtOxAaRte2f4EE4.6n3ktLQk977v27Clmi','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:30:17','2019-09-27 18:30:17'),(47,'oswaldo Ruvalcaba','ac@gmail.com','$2y$10$lnxVs2wsxT0N6wWXU9d7Kuv2gvypq.0lD8QfcTct/xKrd4s2JMezi','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:30:53','2019-09-27 18:30:53'),(48,'Monica Ochoa','ad@gmail.com','$2y$10$pAd7m7z478rwkU3UqWcbnursp1/QC1hoLJQsAHGQ3.c4s2oUUyFZy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:31:27','2019-09-27 18:31:27'),(49,'Luis Fernando Morales ','ah@gmail.com','$2y$10$oKda6NLg8k1vOwsxzUvSFO2vgGnIN9StfJkyhoIIb7HSXsAcZPkJK','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:32:00','2019-09-27 18:32:00'),(50,'Laura Chocoteco','ae@gmail.com','$2y$10$mnyuXItcQw1wvBHVwU/pce4MQJ/sXJnwPYp2RyUIoY2v/rqdcYrKe','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:32:34','2019-09-27 18:32:34'),(51,'Martha Elias','kj@gmail.com','$2y$10$Zia.Xl8Jo2MMFItrPv0E3.3XLdYOsgPZkMeBRQxd5FIwgLGnZxDEu','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:33:01','2019-09-27 18:33:01'),(52,'Fabiola Quezada','asa@gmail.com','$2y$10$4TDChHoKF3L49QYY1QWIv.3BX6rpm5RtlhoJ7pc/g4qFV2IIJGk..','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:33:55','2019-09-27 18:33:55'),(53,'Jose Tinoco','dsa@gmail.com','$2y$10$y9nxAcWJrLdi7szU9OYNme2EIuOc8XcuYTfS67m9ehUeehUri52Wa','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:34:26','2019-09-27 18:34:26'),(54,'Alejandro Mejia','asdas@gmail.com','$2y$10$dgRaMjnlaBrjNy.Qdlmq8uNMp8qXDu17IOx1hsEl/olOBmVFUabzu','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:34:55','2019-09-27 18:34:55'),(55,'Karen Palafox','we@gmail.com','$2y$10$duG2icbkfFQ7qL4QFKAvC.CO/aSil7uzuUf1sQx/f9Vx4LkJleQ9e','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:35:20','2019-09-27 18:35:20'),(56,'Carlos Alberto','qweii@gmail.com','$2y$10$AUq9mispJuCEQ1J865LsduFTE.cEuJuLNaqkZVh.LwGsv/o7jsz6K','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:35:51','2019-09-27 18:35:51'),(57,'Miguel Pavel','qwed@gmail.com','$2y$10$/iTC4XAkSda6aDOJf/A1JefA51zM2W09yZTAFhYFNnmYikbTs7MVy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:36:16','2019-09-27 18:36:16'),(58,'Sandra Zavala','oks@gmail.com','$2y$10$Z7LuopHJWeZK9MGft7ojjOqCsRTOox0./DxoT8ZInn0To4K3Nk/n.','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:36:44','2019-09-27 18:36:44'),(59,'Omar Israel ','ons@gmail.com','$2y$10$R.M5cxKlhBuoTY6h8TUfquZto88W2v5Cy4JrQt1YbjUy7iCSeoYQy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:37:09','2019-09-27 18:37:09'),(60,'Claudia Angel','dklans@gmail.com','$2y$10$lCxSoVDbUQ5q9ColGQkQV.37kK8y9rrZckZa/KqYHyqQxTW/yIB62','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:37:42','2019-09-27 18:37:42'),(61,'Leonardo Maldonado','fhfh@gmail.com','$2y$10$FrfVS2Y55TuiKglmGNZ1FeqDKIGEGZXBeIw9gePrVj14Hs.iz2WWO','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:38:05','2019-09-27 18:38:05'),(62,'Mario Sanchez','eska@gmail.com','$2y$10$2OI/9vgLyZ0SuQnyFTqb2OT17AZ9CVguWyP5pPACFe.noaZcqMTK2','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:38:32','2019-09-27 18:38:32'),(63,'Moises Carmona','doskj@gmail.com','$2y$10$YPUTtTjWEVrxBduKZLF/POIt/Q2NmlUkH.mPVaTrq.Rgz3IN61TsK','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:38:55','2019-09-27 18:38:55'),(64,'Ricardo','dskjn@gmail.com','$2y$10$CADy5/j47hfmuDBd7XNRyeaGSjeZhZ6pzU128I3abJGd1tG2SJnr.','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:39:24','2019-09-27 18:39:24'),(65,'Christopher','dlkjdsa@gmail.com','$2y$10$q7FHMf4Of5IXkGHylAPAv.ity5mbo8eyB1ps7.ny6Y09wpUpTBH9u','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:39:48','2019-09-27 18:39:48'),(66,'Dylan ','dalskjl2@gmail.com','$2y$10$TRLu8Bp6In8IAX4boH//6.YqUy2adsd2S77wWw4V3svDFQhWynGC6','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:40:15','2019-09-27 18:40:15'),(67,'Andres Garrotero','dsssl@gmail.com','$2y$10$Dy9gf6RPpBnc9YW/4kcaWeNNjk4QciE5Wbmdzi6rO3V207uSxEwVC','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:41:13','2019-09-27 18:41:13'),(68,'Andres Garrotero','dsl@gmail.com','$2y$10$O0UL.epZLDcFb.VqXOG/euFux882jXfwu1tmsmQziWIWTxQkUQKm2','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:41:13','2019-09-27 18:41:13'),(69,'Armando Mesero','das8@gmail.com','$2y$10$ikC8jR61aV3z/x5lFgTJOeL475fSlpfzJvD4P5bPSyZ2LkthkP0Ga','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:41:45','2019-09-27 18:41:45'),(70,'Brian Jimenez','21edsk@gmail.com','$2y$10$hiTMvSdaHsOEdaBImP2hTeBFNNbGolSuOlie5FuMeECS2zDNQJo2.','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:42:10','2019-09-27 18:42:10'),(71,'Cecilia Garrotero','dsafn8@gmail.com','$2y$10$j30TkUGWeftn901l8daewuoEgfNYsXWY5QNelvyqXVBaw7Z6j83cm','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:42:36','2019-09-27 18:42:36'),(72,'Daniel Mora','fdsj7@gmail.com','$2y$10$wfHuhMOBFZRrh75jdvGybegZDQBg2MwOSF8BJYT5bqV2fYbaO62pq','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:43:02','2019-09-27 18:43:02'),(73,'Diego Mesero','dakh344@gmail.com','$2y$10$gYnHtS1Rw2xeOYrCY3TM2eTLXQmWfzJ66CwL4fmVEOsSdGZfTfnGy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:43:25','2019-09-27 18:43:25'),(74,'Eduardo Mesero','12334@gmail.com','$2y$10$z56/bSdQSWohduOfZexqD.T4rx2GBWkyxDzQk0Z3qlfbIMJeo127e','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:43:48','2019-09-27 18:43:48'),(75,'Fernanda ','djasl@gmail.com','$2y$10$5Q.2wmzVIiG3FA0HUnjAMOMBI/R0czFFaKYZVlN9JNQePpDUc2TOi','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:44:09','2019-09-27 18:44:09'),(76,'Fernanda Losa','3dskjba@gmail.com','$2y$10$j11PXOcvnPmbwgeH4bIdVuD.uYmSocdFXjOVY2UbxU9u5bDsNrtBa','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:45:41','2019-09-27 18:45:41'),(77,'Karely Mesera','dslkjas@gmail.com','$2y$10$nVX0fnodf3LUieovBVXgc.Xpa01Kz1/amFCxPJFFPfqc7T8rr9beS','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:46:06','2019-09-27 18:46:06'),(78,'Mario Carranza','dqlkj4@gmail.com','$2y$10$e7Kr2pLAVbsndtGY9WKeXuHtMjnMz.BvwLxs0DnyEMtki8CZaC9Qi','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:46:32','2019-09-27 18:46:32'),(79,'Misael Garrotero','123dfkds@gmail.com','$2y$10$ApHQyFeAT9gnIkNRJtu2FO9TBlJ2sZaJMbUJtsVzV2VcZSegf2amS','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:46:57','2019-09-27 18:46:57'),(80,'Paola Mesera','edlsaj@gmail.com','$2y$10$f8zwVD7r8TR8fPfPm7pSkeU4cHrOpoBU5C074Y7xOT3iqxVXBmBPy','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:47:21','2019-09-27 18:47:21'),(81,'Ruben Garrotero','sdklna@gmail.com','$2y$10$gLJ0xtCxzykElpbUu8ZyqeaqqSTXqQOJ3ujSc3Wsg943.56tb2ZIa','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:47:44','2019-09-27 18:47:44'),(82,'Seferino Hernandez','r90odash@gmail.com','$2y$10$IXv15qa5e7Ln/Q.WmOndl.fMwqqkKr937QldhXsSO.DOBfxkW1UxO','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:48:27','2019-09-27 18:48:27'),(83,'Sofia Garrotera','123kdsn@gmail.com','$2y$10$RfTfOrgrWoIHHGtl9Xm2JudiGH78L7YT89ZBnD3iYbZ8xUWYkVYNO','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:48:49','2019-09-27 18:48:49'),(84,'Victor Garrotero','opdssn@gmail.com','$2y$10$TihSGUS2Gy5t.MK.2AnP9ubhe9nY.rczwIsefsu1cOLZWCWA7XkAO','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:49:11','2019-09-27 18:49:11'),(85,'Rodolfo Losa','ejkbna@gmail.com','$2y$10$LkP5V6CjaqUS6MEhubjK.O6adX1CtyrEZYrBzE.xSuSz93GKioj5W','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:49:33','2019-09-27 18:49:33'),(86,'Vicente Mesero','dlakna@gmail.com','$2y$10$9K6MQK5sALaW7FUzJKstCuZOdLrKrgZ8yMOOz4VT5eihMZlZgR452','1234','img/img_users/default.jpg',7,1,NULL,'2019-09-27 18:50:18','2019-10-09 17:28:54');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
