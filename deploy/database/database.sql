-- MySQL dump 10.13  Distrib 5.5.61, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: npk.of.by
-- ------------------------------------------------------
-- Server version	5.5.61

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bel_banner`
--

DROP TABLE IF EXISTS `bel_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_banner` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'banner',
  `name` varchar(50) NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(100) NOT NULL DEFAULT '',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `showBanner` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `custombannercode` text,
  PRIMARY KEY (`bid`),
  KEY `viewbanner` (`showBanner`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_banner`
--

LOCK TABLES `bel_banner` WRITE;
/*!40000 ALTER TABLE `bel_banner` DISABLE KEYS */;
INSERT INTO `bel_banner` VALUES (1,1,'','Joomla',0,153,1,'joomlaportal.gif','http://localhost/beldoors.msk.ru','2009-11-06 12:52:57',0,0,'0000-00-00 00:00:00','',''),(2,1,'','Joomlaforum',0,113,0,'joomlaforum.gif','http://localhost/beldoors.msk.ru','2009-11-06 12:55:57',0,0,'0000-00-00 00:00:00','',''),(3,1,'','crysis',0,384,0,'banner.gif','crysis.spb.su','2009-11-13 16:59:47',0,0,'0000-00-00 00:00:00','',''),(4,1,'','CRYSISLab.',0,1889,0,'banner_black.png','crysis.spb.su','2010-01-08 14:53:10',0,0,'0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `bel_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_bannerclient`
--

DROP TABLE IF EXISTS `bel_bannerclient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_bannerclient` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `contact` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` time DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_bannerclient`
--

LOCK TABLES `bel_bannerclient` WRITE;
/*!40000 ALTER TABLE `bel_bannerclient` DISABLE KEYS */;
INSERT INTO `bel_bannerclient` VALUES (1,'andyr.mrezha.ru','Administrator','andyr@mail.ru','',0,'00:00:00',NULL);
/*!40000 ALTER TABLE `bel_bannerclient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_bannerfinish`
--

DROP TABLE IF EXISTS `bel_bannerfinish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_bannerfinish` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `impressions` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(50) NOT NULL DEFAULT '',
  `datestart` datetime DEFAULT NULL,
  `dateend` datetime DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_bannerfinish`
--

LOCK TABLES `bel_bannerfinish` WRITE;
/*!40000 ALTER TABLE `bel_bannerfinish` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_bannerfinish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_categories`
--

DROP TABLE IF EXISTS `bel_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `section` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(10) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_categories`
--

LOCK TABLES `bel_categories` WRITE;
/*!40000 ALTER TABLE `bel_categories` DISABLE KEYS */;
INSERT INTO `bel_categories` VALUES (1,0,'Новое','Последние новости','taking_notes.jpg','1','left','Последние новости от создателей Mambo',1,0,'0000-00-00 00:00:00','',2,0,1,''),(4,0,'Mambo/Joomla','Mambo/Joomla','','com_newsfeeds','left','',1,0,'0000-00-00 00:00:00',NULL,1,0,0,''),(14,0,'Окна','Montblanc','','1','left','',1,0,'0000-00-00 00:00:00',NULL,5,0,0,'imagefolders=*2*'),(15,0,'Двери МДФ','МДФ','','1','left','',1,0,'0000-00-00 00:00:00',NULL,4,0,0,'imagefolders=*2*'),(12,0,'Контакты','Контакты','','com_contact_details','left','Подробная контактная информация',1,0,'0000-00-00 00:00:00',NULL,0,0,0,''),(13,0,'Mambo/Joomla по-русски','Mambo/Joomla по-русски','web_links.jpg','com_weblinks','left','Сайты о Mambo/Joomla на русском языке.',1,0,'0000-00-00 00:00:00',NULL,2,0,0,''),(16,0,'Двери деревянные','Массив','','1','left','',1,0,'0000-00-00 00:00:00',NULL,3,0,0,'imagefolders=*2*'),(17,0,'EstateAgents','EstateAgents','','com_contact_details','','EA Contacts',1,0,'0000-00-00 00:00:00',NULL,0,0,0,''),(18,0,'Вопросы и ответы','Вопросы и ответы','','1','left','',1,62,'2017-06-26 07:58:03',NULL,1,0,0,'imagefolders=*2*');
/*!40000 ALTER TABLE `bel_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_components`
--

DROP TABLE IF EXISTS `bel_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_menu_link` varchar(255) NOT NULL DEFAULT '',
  `admin_menu_alt` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(50) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `admin_menu_img` varchar(255) NOT NULL DEFAULT '',
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_components`
--

LOCK TABLES `bel_components` WRITE;
/*!40000 ALTER TABLE `bel_components` DISABLE KEYS */;
INSERT INTO `bel_components` VALUES (1,'Баннеры','',0,0,'','Управление баннерами','com_banners',0,'js/ThemeOffice/component.png',0,''),(2,'Управление баннерами','',0,1,'option=com_banners','Активные баннеры','com_banners',1,'js/ThemeOffice/edit.png',0,''),(3,'Управление клиентами','',0,1,'option=com_banners&task=listclients','Управление клиентами','com_banners',2,'js/ThemeOffice/categories.png',0,''),(4,'Ссылки','option=com_weblinks',0,0,'','Управление ссылками','com_weblinks',0,'js/ThemeOffice/globe2.png',0,''),(5,'Ссылки','',0,4,'option=com_weblinks','Просмотр существующих ссылок','com_weblinks',1,'js/ThemeOffice/edit.png',0,''),(6,'Категории ссылок','',0,4,'option=categories&section=com_weblinks','Управление категориями ссылок','',2,'js/ThemeOffice/categories.png',0,''),(7,'Контакты','option=com_contact',0,0,'','Управление контактами сайта','com_contact',0,'js/ThemeOffice/user.png',1,''),(8,'Контакты','',0,7,'option=com_contact','Управление контактами','com_contact',0,'js/ThemeOffice/edit.png',1,''),(9,'Категории контактов','',0,7,'option=categories&section=com_contact_details','Управление категориями контактов','',2,'js/ThemeOffice/categories.png',1,''),(10,'Главная страница','option=com_frontpage',0,0,'','Управление объектами на главной странице','com_frontpage',0,'js/ThemeOffice/component.png',1,''),(11,'Голосования','option=com_poll',0,0,'option=com_poll','Управление голосованиями','com_poll',0,'js/ThemeOffice/component.png',0,''),(12,'Импорт лент новостей (RSS)','option=com_newsfeeds',0,0,'','Управление лентами новостей (RSS)','com_newsfeeds',0,'js/ThemeOffice/component.png',0,''),(13,'Управление лентами новостей (RSS)','',0,12,'option=com_newsfeeds','Управление лентами новостей (RSS)','com_newsfeeds',1,'js/ThemeOffice/edit.png',0,''),(14,'Категории лент новостей','',0,12,'option=com_categories&section=com_newsfeeds','Управление категориями лент новостей (RSS)','',2,'js/ThemeOffice/categories.png',0,''),(15,'Авторизация','option=com_login',0,0,'','','com_login',0,'',1,''),(16,'Поиск','option=com_search',0,0,'','','com_search',0,'',1,''),(17,'Syndicate','',0,0,'option=com_syndicate','Управление экспортом RSS','com_syndicate',0,'js/ThemeOffice/component.png',0,'cache=1\ncache_time=3600\ncount=50\ntitle=Экспортировано из Joomla! Lavra Edition 2008\ndescription=Joomla! Lavra Edition 2008\r<br />RSS-экспорт\nimage_file=\nimage_alt=Joomla! Lavra Edition 2008\nlimit_text=1\ntext_length=20\norderby=front\nlive_bookmark=RSS2.0'),(18,'Массовая рассылка','',0,0,'option=com_massmail&hidemainmenu=1','Послать письмо массовой рассылкой зарегистрированным пользователям','com_massmail',0,'js/ThemeOffice/mass_email.png',0,''),(19,'joomlaXplorer','option=com_joomlaxplorer',0,0,'option=com_joomlaxplorer','joomlaXplorer','com_joomlaxplorer',0,'../administrator/components/com_joomlaxplorer/_img/joomlax_icon.png',0,''),(39,'True Gallery','option=com_true',0,0,'option=com_true','true','com_true',0,'js/ThemeOffice/true.png',0,''),(40,'Изображения','',0,39,'option=com_true&act=pictures','Pictures','com_true',0,'js/ThemeOffice/tgpics.png',0,''),(41,'Категории','',0,39,'option=com_true&act=showcatg','Categories','com_true',1,'js/ThemeOffice/tgcategory.png',0,''),(42,'Обычная загрузка','',0,39,'option=com_true&act=upload','Normal Upload','com_true',2,'js/ThemeOffice/tgupload.png',0,''),(43,'Пакетная загрузка','',0,39,'option=com_true&act=batchupload','Batch Upload','com_true',3,'js/ThemeOffice/tgzipupload.png',0,''),(44,'Пакетное извлечение','',0,39,'option=com_true&act=batchimport','Batch Import','com_true',4,'js/ThemeOffice/tgimport.png',0,''),(27,'JComments','option=com_jcomments',0,0,'option=com_jcomments','JComments','com_jcomments',0,'js/ThemeOffice/jcomments16x16.png',0,''),(28,'Комментарии','',0,27,'option=com_jcomments&task=view','Manage comments','com_jcomments',0,'js/ThemeOffice/edit.png',0,''),(29,'Настройки','',0,27,'option=com_jcomments&task=settings','Settings','com_jcomments',1,'js/ThemeOffice/settings16x16.png',0,''),(30,'Смайлы','',0,27,'option=com_jcomments&task=smiles','Smiles','com_jcomments',2,'js/ThemeOffice/smiles16x16.png',0,''),(31,'Импорт данных','',0,27,'option=com_jcomments&task=import','Import','com_jcomments',3,'js/ThemeOffice/import16x16.png',0,''),(32,'Информация о компоненте','',0,27,'option=com_jcomments&task=about','About','com_jcomments',4,'js/ThemeOffice/jcomments16x16.png',0,''),(33,'Joomap','option=com_joomap',0,0,'option=com_joomap','Joomap','com_joomap',0,'js/ThemeOffice/component.png',0,''),(45,'Настройки','',0,39,'option=com_true&act=settings','Configuration','com_true',5,'js/ThemeOffice/tgconfig.png',0,''),(46,'Сброс рейтинга','',0,39,'option=com_true&act=resetvotes','Reset Votes','com_true',6,'js/ThemeOffice/tgreset.png',0,''),(47,'Воссоздание мини-эскиза','',0,39,'option=com_true&act=rebuild','Thumb Rebuild','com_true',7,'js/ThemeOffice/tgrebuild.png',0,''),(64,'404 SEF','option=com_sef',0,0,'option=com_sef','404 SEF','com_sef',0,'js/ThemeOffice/component.png',0,'');
/*!40000 ALTER TABLE `bel_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_contact_details`
--

DROP TABLE IF EXISTS `bel_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `con_position` varchar(50) DEFAULT NULL,
  `address` text,
  `suburb` varchar(50) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `fax` varchar(25) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(100) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(100) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_contact_details`
--

LOCK TABLES `bel_contact_details` WRITE;
/*!40000 ALTER TABLE `bel_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_content`
--

DROP TABLE IF EXISTS `bel_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `title_alias` varchar(100) NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(11) unsigned NOT NULL DEFAULT '0',
  `mask` int(11) unsigned NOT NULL DEFAULT '0',
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(100) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL DEFAULT '1',
  `parentid` int(11) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_content`
--

LOCK TABLES `bel_content` WRITE;
/*!40000 ALTER TABLE `bel_content` DISABLE KEYS */;
INSERT INTO `bel_content` VALUES (10,'Рекомендации по эксплуатации дверей','doors-howto','<p align=\"justify\">Двери межкомнатные изготовлены из клееного массива сосны, предварительно высушенной до влажности 8-10%. Мягкий режим сушки древесины и жесткий контроль за процессом и результатами сушки, а также, конструкция дверей гарантируют Вам при соблюдении приведенных ниже правил транспортировки, хранения, обработки и установки дверных блоков их длительную эксплуатацию.&nbsp;</p>','<p align=\"justify\">Во избежание деформации дверных полотен их необходимо хранить в горизонтальном положении. Перемещение дверей следует производить только на весу или при помощи специальных механических средств. При обращении с дверями старайтесь избегать таких методов воздействия, которые ведут к нанесению механических повреждений.</p><p align=\"justify\">Дверные полотна, особенно некрашеные, необходимо беречь от попадания прямых солнечных лучей, так как это приведет к изменению естественного цвета древесины. К подобному результату приведет также и длительное хранение дверей без защитно-декоративного покрытия даже и в темном помещении.</p><p align=\"justify\">Основным физическим свойством древесины, влияющим на геометрические размеры изделий из нее, является гигроскопичность, т.е. способность древесины впитывать влагу из воздуха. Поэтому, чтобы обеспечить стабильные размеры дверных полотен и отдельных их элементов, мы рекомендуем хранить, обрабатывать и эксплуатировать наши изделия в помещениях с относительной влажностью воздуха от 45 до 65 % при температуре от 15 до 25 Если двери все-таки какое-либо время находились в помещении с более высокой влажностью, то перед тем как приступить к установке или, особенно, покраске, крайне важно поместить двери на срок около 7 дней в те условия, в которых двери будут эксплуатироваться. Разумеется, категорически недопустимо намокание дверей или их долгое нахождения в помещении со стопроцентной влажностью воздуха. Это может привести к порче изделия.</p><p align=\"justify\">Покраску и установку дверей должны выполнять специалисты, имеющие необходимые опыт, условия и оборудование.</p><p align=\"justify\">Установка блока должна быть последним этапом ремонта, так как все предыдущие связаны с повышенной влажностью воздуха. При монтаже блока следует использовать только монтажную пену. Запрещается использовать цементные растворы.</p><p align=\"justify\">В квартирах, где есть центральное отопление и нет, регулятора влажности воздуха, она колеблется от &laquo;очень сухо&raquo; зимой до &laquo;умеренно влажно&raquo; летом. В связи с этим вы можете столкнуться с двумя типичными проблемами. Во-первых, зимой по периметру филенок могут появиться белые, не окрашенные полоски. Это говорит не о том, что двери бракованные, а о том, что покраска производилась, когда влажность древесины была выше. Сейчас филенка подсохла и уменьшилась в размерах. Вы можете попробовать подкрасить эти полосы соответствующей краской и избавиться от этой проблемы навсегда, или можете оставить все как есть, и тогда белые полосы будут появляться периодически. Во-вторых, летом вы можете заметить, что двери стали открываться и закрываться хуже. Вполне вероятно, что при монтаже дверного блока, особенно если он проводился зимой, кому-то показалось, что зазоры между дверью и дверной коробкой слишком большие и было принято решение об их уменьшении. Ни в коем случае не следует этого делать, так как эти зазоры сделаны такими с учетом сезонных колебаний размеров дверного полотна.</p>',1,1,0,16,'2009-11-05 15:46:44',62,'','2017-05-30 13:10:29',62,0,'0000-00-00 00:00:00','2009-11-05 15:43:42','0000-00-00 00:00:00','','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',6,0,2,'','',0,2691),(8,'Достоинства MONTBLANC','montblanc-plus','<p><strong>1. Современный дизайн</strong></p><p align=\"justify\">Классическая геометрия профиля MONTBLANC termodesign, его гладкая глянцевая поверхность придаст очарование Вашему дому.</p><p><strong>2. Долговечность окон</strong></p><p align=\"justify\">Материал ПВХ, используемый для изготовления MONTBLANC termodesign был разработан специально для российского климата,т.е. окна могут быть установлены в любых климатических условиях &ndash; от регионов Крайнего севера до тропиков.</p>','<p><strong>3. Комплексность</strong></p><p align=\"justify\">Все системы оконного профиля MONTBLANC комплектуются подоконниками и пластиковыми откосами, позволяющими быстро закрыть оконный проем.</p><p><strong>4. Тепло- и шумоизоляция</strong></p><p align=\"justify\">Установив пластиковые окна системы MONTBLANC termodesign, Вы навсегда избавитесь от уличного шума. Вам никогда не придется красить новые пластиковые окна!! Идеальный белый цвет гарантировано неизменен на протяжении ШЕСТИДЕСЯТИ ЛЕТ! Пятикамерное исполнение системы профиля Monblanc исключают потери тепла, и даже в лютый мороз в Вашем доме будет тепло и уютно!</p><p><strong>5. Защита от взлома!</strong></p><p align=\"justify\">Конструкция пластиковой системы MONTBLANC termodesign позволяет устанавливать противовзломную фурнитуру ведущих европейских производителей, затрудняющую проникновение в помещение через окно.</p><p><strong>6. Проветриванию - да!</strong></p><p align=\"justify\">Пластиковые окна системы MONTBLANC termodesign могут открываться в двух плоскостях, а система зимнего проветривания позволяет в зимнее время обеспечить приток свежего воздуха без открывания окна.</p><p><strong>7. Неограниченные возможности</strong></p><p align=\"justify\">Оригинальные профильные системы MONTBLANC &ndash; eco, termo, city, grand, logic предусматривают возможность изготовления окон, отвечающих любым индивидуальным требованиям заказчика.</p><p><strong>8. Простота повседневного ухода</strong></p><div align=\"justify\">Все свойства окон системы MONTBLANC сохраняются идеальными на протяжении 60-ти лет. Благодаря глянцевой поверхности оконная рама станет чистой за считанные секунды при помощи обычного моющего средства.</div>',0,1,0,14,'2009-11-05 15:35:38',62,'','2015-12-27 15:23:35',62,0,'0000-00-00 00:00:00','2009-11-05 15:33:22','0000-00-00 00:00:00','','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',5,0,4,'','',0,1638),(9,'Двери из клеенного массива сосны','wooden-doors','<p><strong>Описание:&nbsp;</strong></p><ul><li>Дверное полотно рамочно-щитовой конструкции.</li><li>Каркас и все детали выполнены из массива сосны.</li><li>На поверхности дверного полотна отсутствуют сучки и различные другие дефектные места.</li><li>Толщина полотна 40 мм.</li></ul><p align=\"center\"><font face=\"Verdana\">{mosimage}</font></p>','<p align=\"center\"><font face=\"Verdana\">{mosimage}</font>&nbsp;</p><p><strong>Габариты дверного полотна, мм.</strong>:&nbsp;</p><ul><li>2000 х 400, 600, 700, 800, 900.</li></ul><p><strong>Отделка:&nbsp;</strong></p><ul><li>Неокрашеная, отполированная поверхность или трехслойное лакокрасочное покрытие Herberts &nbsp;или &nbsp;HELIOS.</li></ul><ul><li>Цвета окрашивания: сосна, коньяк, орех, венге, белый воск.</li></ul><p><strong>В комплект поставки межкомнатных дверей входит:&nbsp;</strong></p><ul><li>Дверное полотно.</li><li>Разборная дверная коробка.</li><li>У&nbsp;окрашеных и неокрашеных дверей предоставляется наличник на обе стороны.</li><li>Возможно дополнительное изготовление доборных планок, мм: 70 и 110.</li></ul><p><strong>В комплект поставки по согласованию может входить:&nbsp;</strong></p><ul><li>Остекление дверных полотен.</li><li>Дверные замки или защёлки.</li><li>Дверные петли.</li><li>Ригеля.</li></ul><p>&nbsp;</p>',1,1,0,16,'2009-11-05 15:43:36',62,'','2017-06-26 08:09:33',62,0,'0000-00-00 00:00:00','2009-11-05 15:37:14','0000-00-00 00:00:00','beldoors/wood_doors.jpg|center||0||bottom||\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nbeldoors/wood_doors2.jpg|center||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',16,0,1,'Дверное полотно рамочно-щитовой конструкции.\r\nКаркас и все детали выполнены из массива сосны.\r\nНа поверхности дверного полотна отсутствуют сучки и различные другие дефектные места.\r\nТолщина полотна 40 мм.','Дверное полотно рамочно-щитовой конструкции.\r\nКаркас и все детали выполнены из массива сосны.\r\nНа поверхности дверного полотна отсутствуют сучки и различные другие дефектные места.\r\nТолщина полотна 40 мм.',0,3750),(7,'Профиль MONTBLANC Thermo 60','montblank-profile','<div align=\"center\"><div align=\"justify\">{mosimage} Выпущенный в 2006 г., обновленный MONTBLANC Termo 60 с 5-ю камерами, при сохранении базовой ширины 60мм имеет пять воздушных камер, что повысит теплосберегающие функции окна. Это оправдано для большинства регионов России, Украины и Беларуси. Рассчитанная на основной потребительский сегмент, система предполагает установку наиболее востребованного стеклопакета до 32мм (двухкамерный 4x10x4x10x4). Такой стеклопакет удовлетворяет требования к теплосбережению практически во всех климатических зонах, что позволяет широко использовать систему MONTBLANC termo 60.</div></div><p align=\"justify\">Основным ключевым моментом в обновленной системе MONTBLANC termo 60 является ее полная совместимость со всеми доборными профилями. Это позволяет создавать большое количество самых разнообразных вариантов светопрозрачных конструкций и тем самым эффективно реагировать на спрос конечного потребителя.</p>','<p align=\"justify\">Размеры камер для армирующего профиля, как в рамах, так и в створках - унифицированы.</p><p align=\"justify\">Учитывая, что для обновленной системы MONTBLANC termo 60 подходит армирующий профиль системы MONTBLANC eco 60, можно говорить об оптимизации складских запасов армирования. Для переработчиков, успешно освоивших систему MONTBLANC eco 60, такая совместимость позволит расширить ассортимент и тем самым привлечь заказчика, всегда заинтересованного в разнообразии предложений.</p><div align=\"justify\">Что касается дизайна, то обновленная система MONTBLANC termo 60 имеет скругленные кромки и глянцевую поверхность, благодаря которым выглядит современно и привлекательно. Конструкцию дополняет разработанный для этой системы штапик высотой 14,5 мм для наиболее востребованного стеклопакета - 24мм.</div><p align=\"justify\">Он также имеет скругленную кромку и гармонично смотрится в комплекте с обновленной системой. Вообще, отсутствие острых граней в дизайне окна не только эстетично, но и практично. Округлые глянцевые поверхности меньше удерживают пыль, и, следовательно, легче моются.</p><div align=\"justify\">Все вышеперечисленные достоинства обновленной системы MONTBLANC termo 60 не могут не привлекать требовательного покупателя, что, закономерно, гарантирует ожидаемый спрос.</div>',0,1,0,14,'2009-11-05 15:32:46',62,'','2015-12-27 15:23:35',62,0,'0000-00-00 00:00:00','2009-11-05 15:31:42','0000-00-00 00:00:00','beldoors/banner_b2c02.jpg|left||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',16,0,2,'','',0,1626),(11,'Что такое МДФ двери?','mdf','<p align=\"justify\">На сегодняшний день МДФ стал наиболее часто используемым материалом. Из плит МДФ делают и мебель и предметы интерьера, но наибольшим успехом МДФ пользуется при производстве межкомнатных дверей. Давайте разберемся с достоинствами этого материала, для того, чтобы правильно выбрать межкомнатные двери МДФ.</p><p align=\"justify\">Давайте выделим в первую очередь преимущества плит МДФ перед остальными материалами. Самым главным плюсом является то, что это натуральный материал, он не содержит ни полиэтилены, ни пластик.</p>','<p><strong>Что такое МДФ:</strong></p><p align=\"justify\">МДФ (MDF), другими словами &mdash; древесноволокнистые плиты средней плотности &mdash; представляет собой спрессованную мелкодисперсную фракцию дерева. Для их производства высушенные древесные волокна прессуются под горячим прессом, что обеспечивает высокую плотность. Благодаря современным технологиям изготовления дверей из МДФ, эта продукция получила великолепные потребительские качества и характеристики.</p><p align=\"justify\">Так же межкомнатные двери МДФ отличаются высокой прочностью на сжатие, изгиб, сопротивлению выдергиванию шурупов, которые сравнимы с дверями из натурального дерева. </p><p align=\"justify\">Древесные плиты, которые идут на производство дверей хорошо поддаются фрезеровке и шлифовки. Это позволяет создавать различные профили и рисунки на полотне двери. Все это делает плиты МДФ удобными для изготовления как мебели, так и межкомнатных дверей МДФ. </p><p align=\"justify\">Cледует еще раз отметить высокую прочность дверей МДФ. Прочность плит МДФ в 1.5-2 раза выше прочности древесностружечных плит. Это достигается за счет связующих веществ натурального происхождения, принимающих участие в межволоконном взаимодействии во время прессования древесной массы.</p>',0,1,0,15,'2009-11-05 15:50:11',62,'','2015-12-27 15:23:35',62,0,'0000-00-00 00:00:00','2009-11-05 15:47:09','0000-00-00 00:00:00','','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',6,0,1,'МДФ (MDF), другими словами — древесноволокнистые плиты средней плотности — представляет собой спрессованную мелкодисперсную фракцию дерева. Для их производства высушенные древесные волокна прессуются под горячим прессом, что обеспечивает высокую плотность. Благодаря современным технологиям изготовления дверей из МДФ, эта продукция получила великолепные потребительские качества и характеристики.','МДФ (MDF), другими словами — древесноволокнистые плиты средней плотности — представляет собой спрессованную мелкодисперсную фракцию дерева. Для их производства высушенные древесные волокна прессуются под горячим прессом, что обеспечивает высокую плотность. Благодаря современным технологиям изготовления дверей из МДФ, эта продукция получила великолепные потребительские качества и характеристики.',0,3063),(12,'Каталог продукции (МДФ двери)','','<table border=\"0\" width=\"100%\" align=\"center\"><tbody><tr><td width=\"20%\" height=\"215\"><div align=\"center\"><img src=\"images/models/mdf-1.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td width=\"20%\"><div align=\"center\"><img src=\"images/models/mdf-2.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td width=\"20%\"><div align=\"center\"><img src=\"images/models/mdf-3.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td width=\"20%\"><div align=\"center\"><img src=\"images/models/mdf-4.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td width=\"20%\"><div align=\"center\"><img src=\"images/models/mdf-5.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td></tr><tr><td height=\"25\"><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-1</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-2</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-3</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-4</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-5</font></div></td></tr><tr><td height=\"215\"><div align=\"center\"><img src=\"images/models/mdf-6.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-7.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-8.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-9.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-10.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td></tr><tr><td height=\"25\"><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-6</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-7</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-8</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-9</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-10</font></div></td></tr><tr><td height=\"215\"><div align=\"center\"><img src=\"images/models/mdf-11.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-12.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-13.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-14.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-15.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td></tr><tr><td height=\"25\"><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-11</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-12</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-13</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-14</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-15</font></div></td></tr><tr><td height=\"215\"><div align=\"center\"><img src=\"images/models/mdf-16.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-17.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-18.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-19.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td><td><div align=\"center\"><img src=\"images/models/mdf-20.png\" alt=\"\" width=\"80\" height=\"200\" /></div></td></tr><tr><td height=\"25\"><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-16</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-17</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-18</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-19</font></div></td><td><div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\">Модель M-20</font></div></td></tr></tbody></table>','',-2,1,0,15,'2009-11-05 15:51:50',62,'','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','2009-11-05 15:50:15','0000-00-00 00:00:00','','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',1,0,1,'','',0,0),(13,'О нас и нашей деятельности','about','<p align=\"justify\">Благодаря накопленному опыту нашего слаженного коллектива, постоянному совершенствованию технологии и использованию самого лучшего сырья, мы предлагаем своим клиентам действительно качественный продукт европейского уровня.</p><p align=\"center\">{mosimage}&nbsp;</p><p align=\"justify\">Если Вы давно занимаетесь оптовой торговлей или только собираетесь заняться, - мы рассчитываем на наше долговременное и взаимовыгодное сотрудничество. Мы видим наш успех в успехе наших партнёров. Сотрудничая с нами, вы и ваши потребители получают следующие выгоды:</p><ul><li>Надежные и современные двери белорусского производства;</li><li>Доступная цена;</li><li>Соблюдение оговоренных сроков поставки;</li><li>Работа без посредников напрямую с производителем;</li><li>Качественная доставка товара прямо на склад покупателя;</li><li>Возможность получения эксклюзивного дилерства в регионе и выгодные условия сотрудничества;</li><li>Информационная и рекламная поддержка, предоставление образцов продукции.</li></ul>','<div align=\"justify\">&nbsp;</div><div align=\"justify\">Мы рады сотрудничеству с партнерами и постоянно расширяем географию продаж. Нашу продукцию знают покупатели России, Казахстана, Беларуси, Азербайджана, Кыргызстана, Литвы и Латвии. Часть наших клиентов, покупающих нашу продукцию, является эксклюзивными представителями в своем регионе.</div><p align=\"justify\">Нашими партнерами и покупателями являются крупные строительные и оптовые торгово-закупочные фирмы, сети розничных магазинов, а также частные предприниматели. Сегодня гладкие и филенчатые межкомнатные двери, выпускаемые нашей компанией, пользуются заслуженным спросом на рынках СНГ и Балтии. Ассортимент моделей и цветовая гамма расширяются в соответствии с современными требованиями рынка и вкусами покупателей, а введение новых производственных мощностей позволит предложить нашим клиентам новые виды продукции.</p><div align=\"justify\">Вся наша продукция сертифицирована и соответствует требованиям СТБ 2433-2015 &quot;Блоки дверные. ОТУ&quot;, ТР 2009/013/BY &quot;Здания и сооружения, строительные материалы и изделия. Безопасность&quot;.</div><div align=\"justify\">&nbsp;</div><div align=\"justify\">Двери универсальны по цветам и типам и могут использоваться для оформления &nbsp;жилых, офисных и производственных помещений.</div>',1,1,0,1,'2009-11-28 12:12:05',62,'','2017-06-26 08:07:10',62,0,'0000-00-00 00:00:00','2009-11-28 12:08:50','0000-00-00 00:00:00','buisness.jpg|||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',10,0,1,'Надежные и современные двери белорусского производства;\r\nДоступная цена;\r\nСоблюдение оговоренных сроков поставки;\r\nРабота без посредников напрямую с производителем;\r\nКачественная доставка товара прямо на склад покупателя;\r\nВозможность получения эксклюзивного дилерства в регионе и выгодные условия сотрудничества;\r\nИнформационная и рекламная поддержка, предоставление образцов продукции.','Надежные и современные двери белорусского производства;\r\nДоступная цена;\r\nСоблюдение оговоренных сроков поставки;\r\nРабота без посредников напрямую с производителем;\r\nКачественная доставка товара прямо на склад покупателя;\r\nВозможность получения эксклюзивного дилерства в регионе и выгодные условия сотрудничества;\r\nИнформационная и рекламная поддержка, предоставление образцов продукции.',0,2441),(14,'Как нас найти?','contacts','<table border=\"0\" cellspacing=\"5\" cellpadding=\"0\" width=\"100%\"><tbody><tr valign=\"top\"><td width=\"50%\"><p><strong><u>Мы расположены по адресу</u></strong></p><p>211440, улица Янки Купалы д.12,<br />г.Новополоцк, Витебская область,<br />Республика Беларусь.</p></td><td width=\"50%\"><p><strong><u>Режим работы</u></strong></p>Будни: 9<sup>00</sup>-18<sup>00</sup>, обед 13<sup>00</sup>-14<sup>00</sup>;<br />Суббота, воскресенье: выходной.<br /></td></tr><tr valign=\"top\"><td><p><u><strong>Контактные телефоны</strong></u></p>(+375 214) 75 47 57 - факс&nbsp;<br />(+375 29) 121 36 01&nbsp;<br /></td><td><p><strong><u>Электронная почта</u></strong></p><p><a href=\"mailto:beldoors@gmail.com\">beldoors@gmail.com</a></p></td></tr></tbody></table>','<script type=\"text/javascript\" charset=\"utf-8\" async src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=frxgBrgYfEnwixsuXBFgDG1xAnqttScw&width=670&height=400&lang=ru_RU&sourceType=constructor&scroll=true\"></script>',1,1,0,1,'2009-11-28 12:15:55',62,'','2016-02-12 06:27:03',62,62,'2017-06-08 05:38:43','2009-11-28 12:13:31','0000-00-00 00:00:00','map.jpg|||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',23,0,2,'','',0,3739),(15,'Устройство окон MANTBLANC Thermo 60','montblanc-construction','<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" align=\"center\"><tbody><tr><td width=\"55\" align=\"center\">{mosimage}</td><td><p><strong>КОРОБКА</strong><br />Cборочная единица оконного блока рамочной конструкции, предназначенная для навески створок или полотен.</p></td></tr><tr><td><div align=\"justify\"><div align=\"center\"><div align=\"center\">{mosimage}</div></div></div></td><td><strong>АРМИРОВАНИЕ КОРОБКИ</strong><br />Cтальной элемент усиления, расположенный внутри коробки необходимый для придания жесткости оконной конструкции.<br /></td></tr></tbody></table>','<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" align=\"center\"><tbody><tr><td align=\"center\">{mosimage}</td><td><strong>СТВОРКА</strong><br />Часть окна, которая крепится к раме. Может быть поворотной, поворотно-откидной, откидной.<br /></td></tr><tr><td align=\"center\">{mosimage}</td><td><strong>АРМИРОВАНИЕ СТВОРКИ</strong><br />Стальной элемент усиления, расположенный внутри створки необходимый для придания жесткости оконной конструкции.<br /></td></tr><tr><td align=\"center\">{mosimage}</td><td><strong>ШТАПИК</strong><br />Деталь, закрепляющая светопрозрачное (или глухое) заполнение в створках и дверных полотнах.<br /></td></tr><tr><td align=\"center\">{mosimage}</td><td><strong>СТЕКЛОПАКЕТ</strong><br />Изделие, состоящее из двух или трех листов стекла, соединенных между собой по контуру с помощью дистанционных рамок и герметиков.<br /></td></tr><tr><td align=\"center\">{mosimage}</td><td><strong>ПОДОКОННИК</strong><br />Элемент пластикового окна, устанавливается на оконный блок с внутренней стороны (со стороны помещения).<br /></td></tr></tbody></table>',0,1,0,14,'2009-12-24 15:43:13',62,'','2015-12-27 15:23:35',62,0,'0000-00-00 00:00:00','2009-12-24 15:33:52','0000-00-00 00:00:00','window/window01.jpg|||0||bottom||\nwindow/window02.jpg|||0||bottom||\nwindow/window03.jpg|||0||bottom||\nwindow/window04.jpg|||0||bottom||\nwindow/window05.jpg|||0||bottom||\nwindow/window08.jpg|||0||bottom||\nwindow/window09.jpg|||0||bottom||\nwindow/window010.jpg|||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',5,0,3,'Устройство окон MANTBLANC Thermo 60','Устройство окон MANTBLANC Thermo 60',0,1442),(16,'Окна из ПВХ профиля MONTBLANC Thermo 60','montblanc-windows','<p align=\"justify\">{mosimage} Предлагаемые нами окна изготавливаются из качественного пятикамерного ПВХ профиля системы &ldquo;MONTBLANC termo 60&rdquo;, разработанного при участии австрийской компанией &laquo;A+G Extrusion Technology&raquo;, адаптированной для восточно-европейской климатической зоны. Все профильные элементы окон (рамы, створки, импоста) армируются по внутренней камере оцинкованными стальными усилительными профилями толщиной 2мм., увеличивающими механическую и термомеханическую прочность изделий. В процессе производства окна оснащаются системой дренажных и вентиляционных отверстий и двумя контурами уплотнителей. Благодаря высоте наплава 20 мм, достигается оптимальная ширина прилегания наружного уплотнения, что в сочетании с эффективным прилеганием внутреннего уплотнения обеспечивает высокую степень воздухо- и водонепроницаемости притвора и конструкции в цело. Угловые соединения рамных и створных частей сварные (сила излома 3,9 KN). Окна обеспечивают звукоизоляцию со снижением воздушного шума, производимого потоком городского транспорта 28 дБА.</p>','<p align=\"justify\">Окна изготавливаются на оборудовании фирмы &laquo;YILMAZ&raquo; 2005 года выпуска. Остекленение изделий осуществляется как однокамерными стеклопакетами, так и двухкамерными стеклопакетами. Стеклопакеты изготавливаются из стекла марки М1 Гомельского стекольного завода.</p><p align=\"justify\">Окна оборудованы немецкой фурнитурой фирмы &laquo;Roto Frank AG&raquo; Благодаря модульной системе и новой конструкции соединительных узлов ROTO NT позволяет реализовать любой вид монтажа: от ручного до полной автоматизации. Отличается также необычным дизайном, благодаря новому серебристому покрытию RotoSil, где защита от коррозии многократно превышает требования RAL RG 607/3.</p><p>Стандартный комплект и целый набор дополнительных функций:<br />&nbsp;                             - ножницы с 2-мя диапазонами открывания;<br />&nbsp;                             - дополнительный средний запор;<br />&nbsp;                             - 2 типа щелевого проветривания;<br />&nbsp;                             - регулируемый блокировщик откидывания;<br />&nbsp;                             - противовзломный элемент в угловом переключателе в нижней части створки.</p><p align=\"justify\">Все ответные планки ROTO NT имеют одинаковые оси крепления шурупов, что позволяет оснастить створку противовзломными цапфами, а в последствии установить на раму противовзломные ответные планки. При этом все варианты запорных цапф комбинируются с любыми ответными планками. Возможна установка шпингалета или углового переключателя в низу по выбору заказчика.</p><p align=\"justify\">Наши изделия отличаются высоким качеством, надежностью и долговечностью. Наличие современного оборудования, достаточных производственных площадей, высококвалифицированных кадров и доступных цен позволяет коллективу изготавливать практически любые изделия и конструкции из ПВХ, учитывая потребности заказчиков. Специалисты всегда готовы предоставить технические консультации, что позволяет достигнуть желаемых результатов с наименьшими издержками.</p>',0,1,0,14,'2010-01-11 00:41:55',62,'','2015-12-27 15:23:35',62,0,'0000-00-00 00:00:00','2010-01-11 00:36:47','0000-00-00 00:00:00','beldoors/montblanc_thermo60.jpg|left||0||bottom||','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',7,0,1,'A+G Extrusion Technology MONTBLANC termo 60 YILMAZ ROTO NT RAL RG 607/3.','Предлагаемые нами окна изготавливаются из качественного пятикамерного ПВХ профиля системы “MONTBLANC termo 60”, разработанного при участии австрийской компанией «A+G Extrusion Technology», адаптированной для восточно-европейской климатической зоны.',0,2458),(17,'Вопросы и ответы','faq','<p align=\"justify\">Любые интересующие вас вопросы связанные с нашей продукцией, &nbsp;можно задать нам на электронную почту: <strong>beldoors@gmail.com</strong>&nbsp;</p><p align=\"justify\">Наши консультанты в кратчайшие сроки предоставят вам полную информацию по транспортировке, хранению, обработке и монтажу дверных блоков.</p><p align=\"justify\">Убедительная просьба оставлять ваше Ф.И.О., контактный телефон или e-mail для оперативного ответа на ваш вопрос.&nbsp;</p>','',1,1,0,18,'2010-02-02 02:03:34',62,'','2017-06-08 05:39:52',62,0,'0000-00-00 00:00:00','2010-02-02 02:02:01','0000-00-00 00:00:00','','','pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=',11,0,1,'','',0,3732),(18,'404','404','<h1>404: Not Found</h1><h4>Sorry, but the content you requested could not be found</h4>','',-2,0,0,0,'2004-11-11 12:44:38',62,'','2010-02-02 02:38:47',0,0,'0000-00-00 00:00:00','2004-10-17 00:00:00','0000-00-00 00:00:00','','','menu_image=-1\nitem_title=0\npageclass_sfx=\nback_button=\nrating=0\nauthor=0\ncreatedate=0\nmodifydate=0\npdf=0\nprint=0\nemail=0',1,0,0,'','',0,751);
/*!40000 ALTER TABLE `bel_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_content_frontpage`
--

DROP TABLE IF EXISTS `bel_content_frontpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_content_frontpage`
--

LOCK TABLES `bel_content_frontpage` WRITE;
/*!40000 ALTER TABLE `bel_content_frontpage` DISABLE KEYS */;
INSERT INTO `bel_content_frontpage` VALUES (13,1),(9,3),(11,5),(16,4),(10,2);
/*!40000 ALTER TABLE `bel_content_frontpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_content_rating`
--

DROP TABLE IF EXISTS `bel_content_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_content_rating`
--

LOCK TABLES `bel_content_rating` WRITE;
/*!40000 ALTER TABLE `bel_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_content_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_acl_aro`
--

DROP TABLE IF EXISTS `bel_core_acl_aro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_acl_aro` (
  `aro_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aro_id`),
  UNIQUE KEY `section_value_value_aro` (`section_value`,`value`),
  UNIQUE KEY `bel_gacl_section_value_value_aro` (`section_value`,`value`),
  KEY `hidden_aro` (`hidden`),
  KEY `bel_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_acl_aro`
--

LOCK TABLES `bel_core_acl_aro` WRITE;
/*!40000 ALTER TABLE `bel_core_acl_aro` DISABLE KEYS */;
INSERT INTO `bel_core_acl_aro` VALUES (10,'users','62',0,'Administrator',0),(11,'users','63',0,'Олег Клос',0),(12,'users','64',0,'александр',0),(13,'users','65',0,'Хабров А.Н.',0),(14,'users','66',0,'qwert',0),(15,'users','67',0,'Расч т стоимости рекламы на яндексе',0),(16,'users','68',0,'Игры для телефона Samsung C3300',0),(17,'users','69',0,'Юлия',0),(18,'users','70',0,'Добавить сайт в Яндекс',0),(19,'users','71',0,'Ремонт квартир в Екатеринбурге · http://rem66.ru/',0),(20,'users','72',0,'Кнопка «Бабло!»',0),(21,'users','73',0,'Game Of Thrones Genesis отзывы',0),(22,'users','74',0,'Game Boy Advance отзывы',0),(23,'users','75',0,'Ремонт квартир Екатеринбург',0),(24,'users','76',0,'Вызов сантехника Екатеринбург',0),(25,'users','77',0,'Продвижение сайта самостоятельно бесплатно',0),(26,'users','78',0,'Nuuxazhot',0),(27,'users','79',0,'RichNouh',0),(28,'users','80',0,'Chasearnes',0),(29,'users','81',0,'Worldbpaw',0),(30,'users','82',0,'JustEnfows',0),(31,'users','83',0,'Yolabapse',0),(32,'users','84',0,'Anthony',0),(33,'users','85',0,'Ellexpins',0);
/*!40000 ALTER TABLE `bel_core_acl_aro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_acl_aro_groups`
--

DROP TABLE IF EXISTS `bel_core_acl_aro_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_acl_aro_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `parent_id_aro_groups` (`parent_id`),
  KEY `bel_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `bel_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_acl_aro_groups`
--

LOCK TABLES `bel_core_acl_aro_groups` WRITE;
/*!40000 ALTER TABLE `bel_core_acl_aro_groups` DISABLE KEYS */;
INSERT INTO `bel_core_acl_aro_groups` VALUES (17,0,'ROOT',1,22),(28,17,'USERS',2,21),(29,28,'Public Frontend',3,12),(18,29,'Registered',4,11),(19,18,'Author',5,10),(20,19,'Editor',6,9),(21,20,'Publisher',7,8),(30,28,'Public Backend',13,20),(23,30,'Manager',14,19),(24,23,'Administrator',15,18),(25,24,'Super Administrator',16,17);
/*!40000 ALTER TABLE `bel_core_acl_aro_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_acl_aro_sections`
--

DROP TABLE IF EXISTS `bel_core_acl_aro_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_acl_aro_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(230) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `bel_gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `bel_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_acl_aro_sections`
--

LOCK TABLES `bel_core_acl_aro_sections` WRITE;
/*!40000 ALTER TABLE `bel_core_acl_aro_sections` DISABLE KEYS */;
INSERT INTO `bel_core_acl_aro_sections` VALUES (10,'users',1,'Users',0);
/*!40000 ALTER TABLE `bel_core_acl_aro_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_acl_groups_aro_map`
--

DROP TABLE IF EXISTS `bel_core_acl_groups_aro_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '',
  `aro_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_acl_groups_aro_map`
--

LOCK TABLES `bel_core_acl_groups_aro_map` WRITE;
/*!40000 ALTER TABLE `bel_core_acl_groups_aro_map` DISABLE KEYS */;
INSERT INTO `bel_core_acl_groups_aro_map` VALUES (18,'',11),(18,'',12),(18,'',14),(18,'',15),(18,'',16),(18,'',17),(18,'',18),(18,'',19),(18,'',20),(18,'',21),(18,'',22),(18,'',23),(18,'',24),(18,'',25),(18,'',26),(18,'',27),(18,'',28),(18,'',29),(18,'',30),(18,'',31),(18,'',32),(18,'',33),(25,'',10),(25,'',13);
/*!40000 ALTER TABLE `bel_core_acl_groups_aro_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_log_items`
--

DROP TABLE IF EXISTS `bel_core_log_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_log_items` (
  `time_stamp` date NOT NULL DEFAULT '0000-00-00',
  `item_table` varchar(50) NOT NULL DEFAULT '',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_log_items`
--

LOCK TABLES `bel_core_log_items` WRITE;
/*!40000 ALTER TABLE `bel_core_log_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_core_log_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_core_log_searches`
--

DROP TABLE IF EXISTS `bel_core_log_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_core_log_searches`
--

LOCK TABLES `bel_core_log_searches` WRITE;
/*!40000 ALTER TABLE `bel_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_core_log_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_groups`
--

DROP TABLE IF EXISTS `bel_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_groups` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_groups`
--

LOCK TABLES `bel_groups` WRITE;
/*!40000 ALTER TABLE `bel_groups` DISABLE KEYS */;
INSERT INTO `bel_groups` VALUES (0,'Public'),(1,'Registered'),(2,'Special');
/*!40000 ALTER TABLE `bel_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_jcomments`
--

DROP TABLE IF EXISTS `bel_jcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_jcomments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `object_id` int(11) unsigned NOT NULL DEFAULT '0',
  `object_group` varchar(255) NOT NULL DEFAULT '',
  `object_params` text NOT NULL,
  `lang` varchar(255) NOT NULL DEFAULT '',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isgood` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ispoor` smallint(5) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `source` varchar(255) NOT NULL DEFAULT '',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_userid` (`userid`),
  KEY `idx_source` (`source`),
  KEY `idx_email` (`email`),
  KEY `idx_lang` (`lang`),
  KEY `idx_subscribe` (`subscribe`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_object` (`object_id`,`object_group`,`published`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_jcomments`
--

LOCK TABLES `bel_jcomments` WRITE;
/*!40000 ALTER TABLE `bel_jcomments` DISABLE KEYS */;
INSERT INTO `bel_jcomments` VALUES (1,0,17,'com_content','','russian',63,'Олег Клос','alex2597','alexklos@list.ru','','','Прошу выслать прайс на Вашу продукцию','89.97.148.55','2010-04-25 12:57:36',0,0,1,0,'',0,'0000-00-00 00:00:00',''),(3,0,17,'com_content','','russian',0,'Иван Николаевич','Иван Николаевич','shikun@mail.ru','','','Заинтересованы вашей продукцией.Вышлите прайс.','178.122.204.53','2010-08-22 19:33:43',0,0,1,0,'',0,'0000-00-00 00:00:00',''),(6,0,17,'com_content','','russian',0,'Сергей','Сергей','sergei1483@yandex.ru','','','Работаете ли вы с диллерами и какие условия????','37.212.48.241','2014-04-05 18:29:04',0,0,1,0,'',0,'0000-00-00 00:00:00',''),(7,0,17,'com_content','','russian',0,'петя','петя','quattros@mail.ru','','','Спасибо за оперативность работы и отличное качество продукции!','37.212.157.248','2014-11-04 09:27:32',0,0,1,0,'',0,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `bel_jcomments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_jcomments_settings`
--

DROP TABLE IF EXISTS `bel_jcomments_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_jcomments_settings` (
  `component` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `lang` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`component`,`lang`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_jcomments_settings`
--

LOCK TABLES `bel_jcomments_settings` WRITE;
/*!40000 ALTER TABLE `bel_jcomments_settings` DISABLE KEYS */;
INSERT INTO `bel_jcomments_settings` VALUES ('','','enable_username_check','1'),('','','username_maxlength','20'),('','','forbidden_names','administrator,moderator'),('','','author_email','2'),('','','author_homepage','0'),('','','comment_maxlength','1000'),('','','word_maxlength','15'),('','','link_maxlength','30'),('','','flood_time','30'),('','','enable_notification','1'),('','','notification_email','manti.by@gmail.com'),('','','template','default'),('','','enable_smiles','0'),('','','comments_per_page','10'),('','','comments_page_limit','15'),('','','comments_pagination','both'),('','','comments_order','DESC'),('','','show_commentlength','1'),('','','enable_nested_quotes','1'),('','','enable_rss','1'),('','','censor_replace_word','[censored]'),('','','can_comment','Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','can_reply','Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','show_policy','Unregistered,Registered'),('','','enable_captcha','Unregistered'),('','','floodprotection','Unregistered,Registered,Author,Editor'),('','','enable_comment_length_check','Unregistered,Registered'),('','','autopublish','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','autolinkurls','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_subscribe','Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_gravatar',''),('','','can_view_homepage','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','can_publish','Publisher,Manager,Administrator,Super Administrator'),('','','can_view_email','Manager,Administrator,Super Administrator'),('','','can_edit','Manager,Administrator,Super Administrator'),('','','can_edit_own','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','can_delete','Manager,Administrator,Super Administrator'),('','','can_delete_own','Manager,Administrator,Super Administrator'),('','','enable_bbcode_b','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_i','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_u','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_s','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_url','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_img','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_list','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','enable_bbcode_hide','Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','can_view_ip','Administrator,Super Administrator'),('','','enable_categories','18'),('','','emailprotection','Unregistered'),('','','enable_comment_maxlength_check',''),('','','enable_autocensor','Unregistered'),('','','badwords',''),('','','smiles',':D	laugh.gif\n:lol:	lol.gif\n:-)	smile.gif\n;-)	wink.gif\n8)	cool.gif\n:-|	normal.gif\n:-*	whistling.gif\n:oops:	redface.gif\n:sad:	sad.gif\n:cry:	cry.gif\n:o	surprised.gif\n:-?	confused.gif\n:-x	sick.gif\n:eek:	shocked.gif\n:zzz	sleeping.gif\n:P	tongue.gif\n:roll:	rolleyes.gif\n:sigh:	unsure.gif'),('','','enable_mambots','1'),('','','form_show','1'),('','','display_author','name'),('','','enable_voting','0'),('','','can_vote','Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator'),('','','merge_time','30'),('','','gzip_js','0'),('','','template_view','list'),('','','message_policy_post',''),('','','message_policy_whocancomment',''),('','','message_locked','This content has been locked. You can no longer post any comment.');
/*!40000 ALTER TABLE `bel_jcomments_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_jcomments_subscriptions`
--

DROP TABLE IF EXISTS `bel_jcomments_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_jcomments_subscriptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned NOT NULL DEFAULT '0',
  `object_group` varchar(255) NOT NULL DEFAULT '',
  `lang` varchar(255) NOT NULL DEFAULT '',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `hash` varchar(255) NOT NULL DEFAULT '',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_object` (`object_id`,`object_group`),
  KEY `idx_lang` (`lang`),
  KEY `idx_hash` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_jcomments_subscriptions`
--

LOCK TABLES `bel_jcomments_subscriptions` WRITE;
/*!40000 ALTER TABLE `bel_jcomments_subscriptions` DISABLE KEYS */;
INSERT INTO `bel_jcomments_subscriptions` VALUES (1,17,'com_content','russian',62,'Administrator','mm112@mail.ru','4a4ad6bcb79fc658ebfb30e53f59bfa4',1),(2,17,'com_content','russian',0,'Matororeofe','invotiatt@mail.ru','fb3d716f3499a34fd5d1427a7bb9b3ae',1),(3,17,'com_content','russian',0,'Innoroume','cyncintotte@mail.ru','d81dc85eb10a47aa8c0b6c1f7ae65f78',1),(4,17,'com_content','',65,'Хабров А.Н.','xabroff@rambler.ru','4684f11503b9b087696b1cd1033da4d2',1);
/*!40000 ALTER TABLE `bel_jcomments_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_jcomments_version`
--

DROP TABLE IF EXISTS `bel_jcomments_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_jcomments_version` (
  `version` varchar(16) NOT NULL DEFAULT '',
  `previous` varchar(16) NOT NULL DEFAULT '',
  `installed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_jcomments_version`
--

LOCK TABLES `bel_jcomments_version` WRITE;
/*!40000 ALTER TABLE `bel_jcomments_version` DISABLE KEYS */;
INSERT INTO `bel_jcomments_version` VALUES ('2.0.0.19','','2009-11-09 16:43:56','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `bel_jcomments_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_jcomments_votes`
--

DROP TABLE IF EXISTS `bel_jcomments_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_jcomments_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `commentid` int(11) unsigned NOT NULL DEFAULT '0',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_comment` (`commentid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_jcomments_votes`
--

LOCK TABLES `bel_jcomments_votes` WRITE;
/*!40000 ALTER TABLE `bel_jcomments_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_jcomments_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_joomap`
--

DROP TABLE IF EXISTS `bel_joomap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_joomap` (
  `version` varchar(255) DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  `expand_category` int(11) DEFAULT NULL,
  `expand_section` int(11) DEFAULT NULL,
  `show_menutitle` int(11) DEFAULT NULL,
  `columns` int(11) DEFAULT NULL,
  `exlinks` int(11) DEFAULT NULL,
  `ext_image` varchar(255) DEFAULT NULL,
  `menus` text,
  `exclmenus` varchar(255) DEFAULT NULL,
  `includelink` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_joomap`
--

LOCK TABLES `bel_joomap` WRITE;
/*!40000 ALTER TABLE `bel_joomap` DISABLE KEYS */;
INSERT INTO `bel_joomap` VALUES ('2.0','sitemap',1,1,1,1,1,'img_grey.gif','mainmenu,0,1\ntopmenu,1,0\nothermenu,2,0\nusermenu,3,0','',1);
/*!40000 ALTER TABLE `bel_joomap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_mambots`
--

DROP TABLE IF EXISTS `bel_mambots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_mambots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `element` varchar(100) NOT NULL DEFAULT '',
  `folder` varchar(100) NOT NULL DEFAULT '',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `iscore` tinyint(3) NOT NULL DEFAULT '0',
  `client_id` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_mambots`
--

LOCK TABLES `bel_mambots` WRITE;
/*!40000 ALTER TABLE `bel_mambots` DISABLE KEYS */;
INSERT INTO `bel_mambots` VALUES (1,'MOS Image','mosimage','content',0,-10000,1,1,0,0,'0000-00-00 00:00:00',''),(2,'MOS пагинация','mospaging','content',0,10000,1,1,0,0,'0000-00-00 00:00:00',''),(3,'Legacy Mambot Includer','legacybots','content',0,1,0,1,0,0,'0000-00-00 00:00:00',''),(4,'SEF','mossef','content',0,3,1,0,0,0,'0000-00-00 00:00:00',''),(5,'MOS рейтинг','mosvote','content',0,4,1,1,0,0,'0000-00-00 00:00:00',''),(6,'Поиск в материалах','content.searchbot','search',0,1,1,1,0,0,'0000-00-00 00:00:00',''),(7,'Поиск в ссылках','weblinks.searchbot','search',0,2,1,1,0,0,'0000-00-00 00:00:00',''),(8,'Поддержка кода','moscode','content',0,2,0,0,0,0,'0000-00-00 00:00:00',''),(9,'Нет визуального редактора','none','editors',0,0,1,1,0,0,'0000-00-00 00:00:00',''),(10,'Редактор TinyMCE','tinymce','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','theme=advanced'),(11,'MOS Image Editor Button','mosimage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(12,'Кнопка MOS разрыв страницы','mospage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(13,'Поиск в контактах','contacts.searchbot','search',0,3,1,1,0,0,'0000-00-00 00:00:00',''),(14,'Поиск в категориях','categories.searchbot','search',0,4,1,0,0,0,'0000-00-00 00:00:00',''),(15,'Поиск в разделах','sections.searchbot','search',0,5,1,0,0,0,'0000-00-00 00:00:00',''),(16,'Защита e-mail адресов','mosemailcloak','content',0,5,1,0,0,0,'0000-00-00 00:00:00',''),(17,'Раскраска кода GeSHi','geshi','content',0,5,0,0,0,0,'0000-00-00 00:00:00',''),(18,'Поиск в RSS-лентах','newsfeeds.searchbot','search',0,6,1,0,0,0,'0000-00-00 00:00:00',''),(19,'Load Module Positions','mosloadposition','content',0,6,1,0,0,0,'0000-00-00 00:00:00',''),(20,'Content - JComments','jcomments.content','content',0,10001,1,0,0,0,'0000-00-00 00:00:00',''),(21,'Search - JComments','jcomments.search','search',0,7,1,0,0,0,'0000-00-00 00:00:00',''),(22,'System - JComments','jcomments.system','system',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(23,'Editor Button - JComments ON','jcommentson','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),(24,'Editor Button - JComments OFF','jcommentsoff','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `bel_mambots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_menu`
--

DROP TABLE IF EXISTS `bel_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(25) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `link` text,
  `type` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `componentid` int(11) unsigned NOT NULL DEFAULT '0',
  `sublevel` int(11) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL DEFAULT '0',
  `browserNav` tinyint(4) DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `utaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_menu`
--

LOCK TABLES `bel_menu` WRITE;
/*!40000 ALTER TABLE `bel_menu` DISABLE KEYS */;
INSERT INTO `bel_menu` VALUES (1,'mainmenu','Главная','index.php?option=com_frontpage','components',1,0,10,0,1,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1\npageclass_sfx=\nheader=Добро пожаловать\npage_title=0\nback_button=0\nleading=1\nintro=25\ncolumns=1\nlink=100\norderby_pri=\norderby_sec=front\npagination=2\npagination_results=1\nimage=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=1\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=0\nprint=\nemail=\nunpublished=0'),(5,'mainmenu','Поиск','index.php?option=com_search','components',-2,0,16,0,12,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=\npageclass_sfx=\nback_button=\npage_title=0\nheader='),(21,'usermenu','Ваши данные','index.php?option=com_user&task=UserDetails','url',1,0,0,0,1,0,'2000-00-00 00:00:00',0,0,1,3,''),(13,'usermenu','Добавить новость','index.php?option=com_content&task=new&sectionid=1&Itemid=0','url',1,0,0,0,2,0,'2000-00-00 00:00:00',0,0,1,2,''),(14,'usermenu','Добавить ссылку','index.php?option=com_weblinks&task=new','url',1,0,0,0,4,0,'2000-00-00 00:00:00',0,0,1,2,''),(15,'usermenu','Проверить материалы','index.php?option=com_user&task=CheckIn','url',1,0,0,0,5,0,'0000-00-00 00:00:00',0,0,1,2,''),(16,'usermenu','Выход','index.php?option=com_login','components',1,0,15,0,5,0,'0000-00-00 00:00:00',0,0,1,3,''),(17,'topmenu','Главная','index.php','url',1,0,0,0,4,0,'0000-00-00 00:00:00',0,0,0,3,''),(18,'topmenu','Пожелания','index.php?option=com_contact&Itemid=3','url',1,0,0,0,2,0,'0000-00-00 00:00:00',0,0,0,3,''),(19,'topmenu','Новости','index.php?option=com_content&task=section&id=1&Itemid=2','url',1,0,0,0,3,0,'0000-00-00 00:00:00',0,0,0,3,''),(20,'topmenu','Ссылки','index.php?option=com_weblinks&Itemid=22','url',1,0,0,0,1,0,'0000-00-00 00:00:00',0,0,0,3,'menu_image=-1'),(30,'mainmenu','Новости','index.php?option=com_content&task=blogcategory&id=1','content_blog_category',-2,0,1,0,13,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=0\nleading=1\nintro=4\ncolumns=1\nlink=100\norderby_pri=\norderby_sec=\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=0\nprint=\nemail=\ncategoryid=1'),(31,'mainmenu','Статьи','index.php?option=com_content&task=blogsection&id=2','content_blog_section',-2,0,2,0,14,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=0\nleading=10\nintro=4\ncolumns=1\nlink=100\norderby_pri=\norderby_sec=\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=0\nprint=\nemail=\nsectionid=2'),(32,'mainmenu','Ссылки','index.php?option=com_weblinks&catid=13','weblink_category_table',-2,0,13,0,15,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\npage_title=1\nheader=\nheadings=1\nhits=\nitem_description=1\nother_cat=1'),(33,'mainmenu','Поддержка JoomlaPortal.RU','index.php?option=com_wrapper','wrapper',-2,0,0,0,16,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\npage_title=0\nheader=\nscrolling=auto\nwidth=100%\nheight=1000\nheight_auto=1\nadd=1\nurl=http://joomlaforum.ru/index.php?board=120.0'),(34,'mainmenu','Поддержка Joom.RU','index.php?option=com_wrapper','wrapper',-2,0,0,0,11,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\npage_title=0\nheader=\nscrolling=auto\nwidth=100%\nheight=1000\nheight_auto=1\nadd=1\nurl=http://joomla-support.ru/forum131.html'),(35,'mainmenu','Видеочат','index.php?option=com_pentachat','components',-2,0,20,0,18,0,'0000-00-00 00:00:00',0,0,0,0,'page_title=0\nheader=\nback_button=\npageclass_sfx=\nbc=FFFFFF\npc_id=\nroom_id=1\nroom_name=Joomla\naff_id=13'),(36,'mainmenu','Галерея','index.php?option=com_rsgallery2','components',-2,0,21,0,22,0,'0000-00-00 00:00:00',0,0,0,0,''),(37,'mainmenu','Внутрь','index.php?option=com_login','components',-2,0,15,0,17,0,'0000-00-00 00:00:00',0,0,0,0,''),(38,'mainmenu','Галерея','index.php?option=com_ab_gallery','components',-2,0,35,0,21,0,'0000-00-00 00:00:00',0,0,0,0,''),(39,'mainmenu','Альбом','index.php?option=com_album','components',-2,0,36,0,20,0,'0000-00-00 00:00:00',0,0,0,0,''),(40,'mainmenu','Вакансии','index.php?option=com_jportfolio','components',-2,0,38,0,19,0,'0000-00-00 00:00:00',0,0,0,0,''),(41,'mainmenu','Галерея','index.php?option=com_true','components',1,0,39,0,4,0,'0000-00-00 00:00:00',0,0,0,0,''),(42,'mainmenu','МДФ двери','index.php?option=com_true&Itemid=41&func=viewcategory&catid=2','url',0,41,0,0,4,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(43,'mainmenu','Массив сосны','index.php?option=com_true&Itemid=41&func=viewcategory&catid=1','url',1,41,0,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(44,'mainmenu','Интерьер','index.php?option=com_true&Itemid=41&func=viewcategory&catid=4','url',0,41,0,0,6,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(45,'mainmenu','Палитра цветов','index.php?option=com_true&Itemid=41&func=viewcategory&catid=3','url',0,41,0,0,5,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(46,'mainmenu','Карта сайта','index.php?option=com_joomap','components',1,0,33,0,9,0,'0000-00-00 00:00:00',0,0,0,0,''),(47,'mainmenu','Технологии','index.php?option=com_true&Itemid=41&func=viewcategory&catid=5','url',0,41,0,0,7,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(48,'mainmenu','Описание','index.php?option=com_content&task=blogcategory&id=0','content_blog_category',1,0,0,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=0\nleading=1\nintro=4\ncolumns=1\nlink=10\norderby_pri=\norderby_sec=order\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nunpublished=0\ncategoryid=14,16,15'),(49,'mainmenu','Работа','index.php?option=com_jobline','components',-2,0,48,0,2,0,'0000-00-00 00:00:00',0,0,0,0,''),(50,'mainmenu','Объявления','index.php?option=com_marketplace','components',-2,0,54,0,6,0,'0000-00-00 00:00:00',0,0,0,0,''),(51,'mainmenu','Окна MONTBLANC','index.php?option=com_content&task=blogcategory&id=14','content_blog_category',0,48,14,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=1\nleading=1\nintro=4\ncolumns=1\nlink=4\norderby_pri=\norderby_sec=order\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nunpublished=0\ncategoryid=14'),(52,'mainmenu','Деревянные двери','index.php?option=com_content&task=blogcategory&id=16','content_blog_category',1,48,16,0,1,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=1\nleading=1\nintro=4\ncolumns=1\nlink=4\norderby_pri=\norderby_sec=order\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nunpublished=1\ncategoryid=16'),(53,'mainmenu','Двери МДФ','index.php?option=com_content&task=blogcategory&id=15','content_blog_category',0,48,15,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\npageclass_sfx=\nback_button=\nheader=\npage_title=1\nleading=1\nintro=4\ncolumns=1\nlink=4\norderby_pri=\norderby_sec=\npagination=2\npagination_results=1\nimage=1\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nunpublished=1\ncategoryid=15'),(54,'mainmenu','Контакты','index.php?option=com_content&task=view&id=14','content_item_link',1,0,14,0,10,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\nunique_itemid=0'),(55,'mainmenu','Документы','undefined','components',-2,41,45,0,1,0,'0000-00-00 00:00:00',0,0,0,0,''),(56,'mainmenu','Документы','undefined','components',-2,41,45,0,2,0,'0000-00-00 00:00:00',0,0,0,0,''),(57,'mainmenu','Документы','index.php?option=com_true&Itemid=41&func=viewcategory&catid=6','url',0,41,0,0,8,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(58,'mainmenu','Авторизация','index.php?option=com_login','components',1,0,15,0,8,0,'0000-00-00 00:00:00',0,0,0,0,''),(59,'mainmenu','Разное','index.php?option=com_true&Itemid=41&func=viewcategory&catid=7','url',1,41,0,0,9,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1'),(60,'mainmenu','Вопросы и ответы','index.php?option=com_content&task=view&id=17','content_item_link',1,0,17,0,5,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1\nunique_itemid=0'),(61,'mainmenu','Старый сайт','http://beldoors.msk.ru','url',-2,0,0,0,0,0,'0000-00-00 00:00:00',0,0,0,0,'menu_image=-1');
/*!40000 ALTER TABLE `bel_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_messages`
--

DROP TABLE IF EXISTS `bel_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` int(11) NOT NULL DEFAULT '0',
  `priority` int(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(230) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_messages`
--

LOCK TABLES `bel_messages` WRITE;
/*!40000 ALTER TABLE `bel_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_messages_cfg`
--

DROP TABLE IF EXISTS `bel_messages_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_messages_cfg`
--

LOCK TABLES `bel_messages_cfg` WRITE;
/*!40000 ALTER TABLE `bel_messages_cfg` DISABLE KEYS */;
INSERT INTO `bel_messages_cfg` VALUES (62,'lock','0'),(62,'mail_on_new','1'),(62,'auto_purge','7');
/*!40000 ALTER TABLE `bel_messages_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_modules`
--

DROP TABLE IF EXISTS `bel_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(10) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_modules`
--

LOCK TABLES `bel_modules` WRITE;
/*!40000 ALTER TABLE `bel_modules` DISABLE KEYS */;
INSERT INTO `bel_modules` VALUES (1,'Голосования','',1,'right',0,'0000-00-00 00:00:00',0,'mod_poll',0,0,1,'cache=1\nmoduleclass_sfx=',0,0),(2,'Меню пользователя','',3,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,1,1,'menutype=usermenu',1,0),(3,'Главное меню','',3,'right',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,1,'class_sfx=\nmoduleclass_sfx=\nmenutype=mainmenu\nmenu_style=vert_indent\nfull_active_id=0\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=1\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=',1,0),(4,'Авторизация','',7,'right',0,'0000-00-00 00:00:00',0,'mod_login',0,0,1,'moduleclass_sfx=\npretext=\nposttext=\nlogin=\nlogout=\nlogin_message=0\nlogout_message=0\ngreeting=1\nname=0',1,0),(5,'Syndicate','',6,'left',0,'0000-00-00 00:00:00',1,'mod_rssfeed',0,0,0,'text=\ncache=1\nmoduleclass_sfx=\nrss091=0\nrss10=0\nrss20=1\natom=0\nopml=0\nrss091_image=\nrss10_image=\nrss20_image=\natom_image=\nopml_image=',1,0),(6,'Последние новости','',4,'user1',0,'0000-00-00 00:00:00',0,'mod_latestnews',0,0,1,'',1,0),(7,'Статистика','',2,'right',62,'2017-02-06 12:57:49',0,'mod_stats',0,0,1,'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=',0,0),(8,'Курсы валют','',4,'right',0,'0000-00-00 00:00:00',0,'mod_kurspb',0,0,1,'moduleclass_sfx=',0,0),(9,'Популярное','',6,'user2',0,'0000-00-00 00:00:00',0,'mod_mostread',0,0,1,'',0,0),(10,'Выбор шаблона','',5,'right',0,'0000-00-00 00:00:00',0,'mod_templatechooser',0,0,1,'title_length=20\nshow_preview=1\npreview_width=140\npreview_height=90\nmoduleclass_sfx=',0,0),(11,'Архивы','',7,'left',0,'0000-00-00 00:00:00',0,'mod_archive',0,0,1,'',1,0),(12,'Разделы','',8,'left',0,'0000-00-00 00:00:00',0,'mod_sections',0,0,1,'',1,0),(13,'Случайная новость','',6,'right',0,'0000-00-00 00:00:00',0,'mod_newsflash',0,0,1,'catid=3\nstyle=random\nimage=0\nlink_titles=\nreadmore=0\nitem_title=0\nitems=\ncache=0\nmoduleclass_sfx=',0,0),(14,'Связанные ссылки','',10,'left',0,'0000-00-00 00:00:00',0,'mod_related_items',0,0,1,'',0,0),(15,'Поиск','',1,'left',0,'0000-00-00 00:00:00',1,'mod_search',0,0,0,'moduleclass_sfx=\ncache=1\nwidth=26\ntext=\nbutton=\nbutton_pos=right\nbutton_text=',0,0),(16,'Случайная картинка','',8,'right',0,'0000-00-00 00:00:00',0,'mod_random_image',0,0,1,'',0,0),(17,'Верхнее меню','',1,'user3',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,0,'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0',1,0),(18,'Банеры','',1,'banner',0,'0000-00-00 00:00:00',1,'mod_banners',0,0,0,'banner_cids=\nmoduleclass_sfx=',1,0),(19,'Компоненты','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_components',0,99,1,'',1,1),(20,'Популярное','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,99,1,'',0,1),(21,'Новинки','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,99,1,'',0,1),(22,'Меню','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,99,1,'',0,1),(23,'Непрочитанные сообщения','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,99,1,'',1,1),(24,'Пользователи он-лайн','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,99,1,'',1,1),(25,'Полное меню','',1,'top',0,'0000-00-00 00:00:00',1,'mod_fullmenu',0,99,1,'',1,1),(26,'Pathway','',1,'pathway',0,'0000-00-00 00:00:00',1,'mod_pathway',0,99,1,'',1,1),(27,'Толл-бар','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,99,1,'',1,1),(28,'Системные сообщения','',1,'inset',0,'0000-00-00 00:00:00',1,'mod_mosmsg',0,99,1,'',1,1),(29,'Quick Icons','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,99,1,'',1,1),(31,'Другое меню','',4,'left',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,0,'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=',0,0),(32,'Враппер (Wrapper)','',12,'left',0,'0000-00-00 00:00:00',0,'mod_wrapper',0,0,1,'',0,0),(33,'Вошли','',0,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,99,1,'',0,1),(34,'__Кнопка - Главная -','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=main.gif\nlink=index.php\ntitle=Главная\nalign=left',0,0),(37,'__Кнопка - Статьи -','',3,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=notes.gif\nlink=index.php?option=com_content&task=blogsection&id=2&Itemid=31\ntitle=Статьи\nalign=left',0,0),(36,'__Кнопка - Новости -','',2,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=news.gif\nlink=index.php?option=com_content&task=blogcategory&id=1&Itemid=30\ntitle=Новости\nalign=left',0,0),(38,'__Кнопка - Ссылки -','',4,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=news_world.gif\nlink=index.php?option=com_weblinks&catid=13&Itemid=32 \ntitle=Ссылки\nalign=left',0,0),(39,'__Кнопка - Поиск -','',5,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=find.gif\nlink=index.php?option=com_search\ntitle=Поиск\nalign=left',0,0),(40,'__Кнопка - Контакт -','',6,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=contacts.gif\nlink=index.php?option=com_contact&Itemid=3 \ntitle=Контакты\nalign=left',0,0),(41,'__Кнопка - Войти -','',7,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=key.gif\nlink=index.php?option=com_login&Itemid=41\ntitle=Регистрация\nalign=left',0,0),(42,'__Кнопка - AndyR форум -','',8,'icon',0,'0000-00-00 00:00:00',1,'mod_andyr_button',0,0,0,'border=0\ntext=\nimage=forum.gif\nlink=index.php?option=com_wrapper&Itemid=33 \ntitle=Форум\nalign=left',0,0),(44,'__Скроллинг баннеров','<marquee onmouseover=\"this.stop()\" onmouseout=\"this.start()\" scrollamount=\"1\" scrolldelay=\"40\"><a title=\"RU-MAMBO.RU\" href=\"http://ru-mambo.ru/\" target=\"_blank\"><img alt=\"\" src=\"images/banners/ru-mambo.gif\" border=\"0\" /></a><a title=\"Support.Gorsk.NET\" href=\"http://support.gorsk.net/\" target=\"_blank\"><img alt=\"\" src=\"images/banners/gorsk.gif\" border=\"0\" /></a><a title=\"ForMabo.COM\" href=\"http://formambo.com/\" target=\"_blank\"><img alt=\"\" src=\"images/banners/formambo.gif\" border=\"0\" /></a><a title=\"MamboTeam.RU\" href=\"http://mamboteam.ru/\" target=\"_blank\"><img alt=\"\" src=\"images/banners/mamboteam.gif\" border=\"0\" /> </a></marquee>',9,'icon',0,'0000-00-00 00:00:00',1,'',0,0,0,'moduleclass_sfx=\nrssurl=\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\ncache=0',0,0);
/*!40000 ALTER TABLE `bel_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_modules_menu`
--

DROP TABLE IF EXISTS `bel_modules_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_modules_menu`
--

LOCK TABLES `bel_modules_menu` WRITE;
/*!40000 ALTER TABLE `bel_modules_menu` DISABLE KEYS */;
INSERT INTO `bel_modules_menu` VALUES (1,1),(2,0),(3,0),(4,0),(5,1),(6,1),(6,2),(6,4),(6,27),(6,36),(7,0),(8,0),(9,1),(9,2),(9,4),(9,27),(9,36),(10,1),(13,1),(15,0),(17,0),(18,0),(31,0),(34,0),(36,0),(37,0),(38,0),(39,0),(40,0),(41,0),(42,0),(44,0),(45,0);
/*!40000 ALTER TABLE `bel_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_newsfeeds`
--

DROP TABLE IF EXISTS `bel_newsfeeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(11) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(11) unsigned NOT NULL DEFAULT '3600',
  `checked_out` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_newsfeeds`
--

LOCK TABLES `bel_newsfeeds` WRITE;
/*!40000 ALTER TABLE `bel_newsfeeds` DISABLE KEYS */;
INSERT INTO `bel_newsfeeds` VALUES (4,11,'AndyR - сайт','http://andyr.mrezha.ru/index2.php?option=com_rss&feed=RSS2.0&no_html=1',NULL,1,50,86400,0,'0000-00-00 00:00:00',2),(4,12,'JoomlaPortal','http://joomlaportal.ru/index2.php?option=com_rss&feed=RSS2.0&no_html=1',NULL,1,50,86400,0,'0000-00-00 00:00:00',2);
/*!40000 ALTER TABLE `bel_newsfeeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_poll_data`
--

DROP TABLE IF EXISTS `bel_poll_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_poll_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(4) NOT NULL DEFAULT '0',
  `text` varchar(254) NOT NULL DEFAULT '',
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_poll_data`
--

LOCK TABLES `bel_poll_data` WRITE;
/*!40000 ALTER TABLE `bel_poll_data` DISABLE KEYS */;
INSERT INTO `bel_poll_data` VALUES (1,14,':))',1),(2,14,':)',0),(3,14,':|',0),(4,14,':(',0),(5,14,':x',0),(6,14,'',0),(7,14,'',0),(8,14,'',0),(9,14,'',0),(10,14,'',0),(11,14,'',0),(12,14,'',0);
/*!40000 ALTER TABLE `bel_poll_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_poll_date`
--

DROP TABLE IF EXISTS `bel_poll_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_poll_date` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_poll_date`
--

LOCK TABLES `bel_poll_date` WRITE;
/*!40000 ALTER TABLE `bel_poll_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_poll_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_poll_menu`
--

DROP TABLE IF EXISTS `bel_poll_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_poll_menu` (
  `pollid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_poll_menu`
--

LOCK TABLES `bel_poll_menu` WRITE;
/*!40000 ALTER TABLE `bel_poll_menu` DISABLE KEYS */;
INSERT INTO `bel_poll_menu` VALUES (14,1);
/*!40000 ALTER TABLE `bel_poll_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_polls`
--

DROP TABLE IF EXISTS `bel_polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_polls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `voters` int(9) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `lag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_polls`
--

LOCK TABLES `bel_polls` WRITE;
/*!40000 ALTER TABLE `bel_polls` DISABLE KEYS */;
INSERT INTO `bel_polls` VALUES (14,'Ну как Joomla?',0,0,'0000-00-00 00:00:00',1,0,86400);
/*!40000 ALTER TABLE `bel_polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_redirection`
--

DROP TABLE IF EXISTS `bel_redirection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_redirection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpt` int(11) NOT NULL DEFAULT '0',
  `oldurl` varchar(100) NOT NULL DEFAULT '',
  `newurl` varchar(150) NOT NULL DEFAULT '',
  `dateadd` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `newurl` (`newurl`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_redirection`
--

LOCK TABLES `bel_redirection` WRITE;
/*!40000 ALTER TABLE `bel_redirection` DISABLE KEYS */;
/*!40000 ALTER TABLE `bel_redirection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_sections`
--

DROP TABLE IF EXISTS `bel_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `scope` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(10) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_sections`
--

LOCK TABLES `bel_sections` WRITE;
/*!40000 ALTER TABLE `bel_sections` DISABLE KEYS */;
INSERT INTO `bel_sections` VALUES (1,'Новости','Новости','articles.jpg','content','right','Выберите раздел новостей из списка ниже, затем выберите новость для чтения.',1,0,'0000-00-00 00:00:00',3,0,5,'');
/*!40000 ALTER TABLE `bel_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_session`
--

DROP TABLE IF EXISTS `bel_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_session` (
  `username` varchar(50) DEFAULT '',
  `time` varchar(14) DEFAULT '',
  `session_id` varchar(200) NOT NULL DEFAULT '0',
  `guest` tinyint(4) DEFAULT '1',
  `userid` int(11) DEFAULT '0',
  `usertype` varchar(50) DEFAULT '',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_session`
--

LOCK TABLES `bel_session` WRITE;
/*!40000 ALTER TABLE `bel_session` DISABLE KEYS */;
INSERT INTO `bel_session` VALUES ('admin','1543936691','ead44b3cc6d500146d8cf25bf7941a1d',1,62,'Super Administrator',0),('','1544697284','5d74c04dfcf6d4000f42aa7d2dd2b962',1,0,'',0);
/*!40000 ALTER TABLE `bel_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_stats_agents`
--

DROP TABLE IF EXISTS `bel_stats_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_stats_agents` (
  `agent` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_stats_agents`
--

LOCK TABLES `bel_stats_agents` WRITE;
/*!40000 ALTER TABLE `bel_stats_agents` DISABLE KEYS */;
INSERT INTO `bel_stats_agents` VALUES ('Opera 9.02',0,75),('Windows XP',1,8404),('localhost',2,77),('MS Internet Explorer 6.0',0,2301),('Opera 9.63',0,14),('MARCO-MANTI',2,14),('Safari 532.0',0,7),('CRYSIS',2,2),('Opera 9.52',0,5),('by',2,393),('Unknown',2,23388),('MS Internet Explorer 7.0',0,912),('it',2,121),('Неизвестный',0,33453),('Неизвестный',1,232225),('ru',2,17428),('Opera 9.80',0,1830),('Opera 9.64',0,11),('ee',2,7),('Mozilla 5.0',0,197361),('net',2,7499),('com',2,38181),('MS Internet Explorer 8.0',0,709),('Safari 533.1',0,25),('MS Internet Explorer ',0,263),('Windows Longhorn',1,235),('Mozilla Firefox 3.5.8',0,4),('Mozilla Firefox 3.0.7',0,3),('Netscape 5.0',0,726),('Safari 532.5',0,10),('Windows 98',1,139),('Opera 9.62',0,5),('Mozilla Firefox 2.0.0.12',0,4),('Opera 9.01',0,2),('Mozilla Firefox 3.6',0,272),('org',2,238),('MS Internet Explorer 5.0',0,8),('Netscape 0.91',0,2),('de',2,706),('MS Internet Explorer 2.0',0,3),('Windows 95',1,8),('Mozilla Firefox 3.6.3',0,13),('Opera 9.27',0,7),('Netscape 4.0',0,12),('th',2,11),('Opera 9.00',0,4),('',2,7),('Opera 7.11',0,2),('Mozilla Firefox 3.0.8',0,1),('Opera 7.54',0,1),('Mozilla Firefox 2.0.0.8',0,3),('Windows 2000',1,181),('Mozilla Firefox 2.0.0.7',0,2),('Opera 9.10',0,2),('Mozilla Firefox 3.5.5',0,10),('Opera 9.51',0,9),('Mozilla Firefox 3.0.19',0,12),('Safari 531.21.10',0,3),('Windows 2003',1,72),('Mozilla 4.0',0,166),('Mozilla Firefox 3.5.7',0,45),('Mozilla Firefox 3.6.6',0,9),('Safari 534.3',0,5),('MS Internet Explorer 5.01',0,14),('ua',2,2773),('Mozilla Firefox 3.6.7',0,2),('Safari 533.4',0,5),('Mozilla Firefox 3.6.8',0,30),('Mozilla Firefox 3.0.3',0,1),('Mozilla Firefox 3.5',0,5),('sk',2,5),('Linux',1,10162),('Mozilla Firefox 1.5.0.4',0,1),('Mozilla Firefox 3.0.17',0,1),('Mozilla Firefox 3.5.11',0,2),('Mozilla Firefox 3.0.10',0,2),('Opera 9.50',0,2),('Opera 9.20',0,4),('Mozilla Firefox 3.5.13',0,4),('Mozilla Firefox 3.0.6',0,10),('MS Internet Explorer 4.01',0,2),('Macintosh',1,4),('Mozilla Firefox 3.6.10',0,16),('Mozilla Firefox 3.5.1',0,3),('aero',2,1),('Opera 9.25',0,3),('Mozilla Firefox 3.5.14',0,1),('Safari 525.19',0,1),('Mozilla Firefox 3.6.12',0,53),('Mozilla Firefox 3.6.4',0,2),('Mozilla Firefox 3.0.4',0,2),('se',2,22),('Opera 9.24',0,2),('Safari 534.7',0,11),('Mac OS X',1,2524),('Mozilla Firefox 3.5.15',0,2),('Safari 534.10',0,8),('Mozilla Firefox 3.6.13',0,17),('FreeBSD',1,1),('Mozilla Firefox 3.6.11',0,3),('Mozilla Firefox 3.6.2',0,2),('my',2,2),('Mozilla Firefox 3.5.16',0,3),('Opera 9.60',0,5),('Safari 534.13',0,4),('am',2,4),('Mozilla Firefox 3.5.10',0,1),('Opera 9.23',0,2),('su',2,7),('Mozilla Firefox 3.5.6',0,9),('Mozilla Firefox 3.5.2',0,89),('Opera 9.61',0,1),('Safari 534.16',0,20),('Mozilla Firefox 3.6.15',0,1),('Safari 525.13',0,2),('Safari 531.9',0,1),('Mozilla Firefox 4.0',0,31),('Mozilla Firefox 3.6.16',0,5),('Mozilla Firefox 3.6.9',0,1),('Mozilla Firefox 3.6.14',0,1),('MS Internet Explorer 5.5',0,15),('Mozilla Firefox 4.0.1',0,78),('Safari 534.24',0,13),('Safari 530.17',0,1),('Mozilla Firefox 2.0.0.11',0,2),('Mozilla Firefox 3.5.19',0,5),('Mozilla Firefox 3.6.17',0,5),('MS Internet Explorer 3.02',0,3),('Dillo 0.7.3',0,2),('Dillo 0.6.4',0,1),('Unknown Unix system',1,1),('Lynx 2.8.8',0,1),('Lynx 2.8.6',0,1),('w3m 0.52',0,2),('w3m 0.5.2',0,1),('Dillo 0.8.5',0,1),('Mozilla Firefox 3.0.1',0,5),('Safari 534.30',0,29),('Safari 533.21.1',0,1),('Mozilla Firefox 7.0',0,4),('tv',2,7),('Mozilla Firefox 5.0',0,39),('Mozilla Firefox 3.5.18',0,1),('Mozilla Firefox 3.6.18',0,10),('Safari 413',0,2),('Opera 8.01',0,1),('Safari 535.1',0,46),('MS Internet Explorer 9.0',0,439),('arpa',2,1191),('Mozilla Firefox 3.6.20',0,3),('Mozilla Firefox 6.0',0,14),('Safari 534.5',0,1),('Mozilla Firefox 6.0.1',0,3),('Mozilla Firefox 3.6.22',0,6),('Mozilla Firefox 6.0.2',0,24),('local',2,3),('Mozilla Firefox 3.6.23',0,2),('Mozilla Firefox 7.0.1',0,22),('Safari 535.2',0,26),('Safari 534.51',0,4),('Opera 8.00',0,1),('Mozilla 7.0',0,1),('kz',2,14),('Mozilla Firefox 8.0',0,19),('Mozilla Firefox 3.5.3',0,3),('Mozilla Firefox 3.6.24',0,3),('Mozilla Firefox 9.0',0,2),('Mozilla Firefox 8.0.1',0,22),('Safari 535.7',0,68),('tr',2,32),('Mozilla Firefox 3.6.25',0,17),('ro',2,15),('Mozilla Firefox 9.0.1',0,1328),('Netscape 4.61',0,1),('Safari 7534.48.3',0,24),('Mozilla Firefox 10.0',0,17),('sjdc',2,3),('Mozilla Firefox 3.0',0,3),('Safari 6531.22.7',0,219),('Mozilla Firefox 10.0.1',0,18),('Safari 535.11',0,36),('Mozilla Firefox 3.6.26',0,3),('Mozilla Firefox 10.0.2',0,20),('iad1',2,3),('kg',2,1),('Mozilla Firefox 3.6.27',0,2),('Mozilla Firefox 11.0',0,32),('Opera 9.26',0,1),('Windows NT 4.0',1,1),('Mozilla Firefox 12.0',0,165),('Opera 10.00',0,1),('Safari 535.19',0,45),('Mozilla Firefox 3.6.28',0,19),('Safari 536.5',0,19),('Mozilla Firefox 13.0',0,4),('Mozilla Firefox 14.0',0,6),('Mozilla Firefox 13.0.1',0,10),('md',2,11),('Safari 536.11',0,24),('Safari 534.32',0,1),('W3C HTML Validator 1.3',0,1),('Mozilla Firefox 14.0.1',0,258),('Safari 537.1',0,49),('uz',2,3),('uk',2,492),('Mozilla Firefox 15.0.1',0,14),('Safari 537.4',0,44),('Mozilla Firefox 16.0',0,35),('Safari 537.11',0,47),('Mozilla Firefox 17.0',0,35),('tc',2,16),('Mozilla Firefox 5.0.1',0,3),('Safari 536.26.17',0,3),('Mozilla Firefox 18.0',0,381),('Safari 537.17',0,13),('Safari 534.57.2',0,6),('Mozilla Firefox 19.0',0,18),('MS Internet Explorer 10.0',0,294),('Safari 537.22',0,43),('Safari 8536.25',0,599),('Safari 6533.18.5',0,1),('Mozilla Firefox 10.0.6',0,4),('Safari 535.12',0,3),('Safari 537.31',0,27),('Mozilla Firefox 20.0',0,8),('Safari 537.36',0,7284),('Mozilla Firefox 21.0',0,62),('Mozilla Firefox 22.0',0,57),('Mozilla Firefox 23.0',0,33),('Safari 535.5',0,2),('pt',2,18),('Mozilla Firefox 3.0.5',0,2),('lv',2,4),('edu',2,38),('Mozilla Firefox 24.0',0,28),('ch',2,67),('Safari 9537.53',0,175),('Mozilla Firefox 25.0',0,218),('Safari 537.71',0,5),('ge',2,5),('Debian',1,2),('info',2,33),('Mozilla Firefox 26.0',0,25),('Safari 534.34',0,3),('Mozilla Firefox 27.0',0,21),('cz',2,12),('Mozilla Firefox 28.0',0,21),('mx',2,215),('cl',2,6),('ar',2,43),('co',2,50),('gt',2,1),('Mozilla Firefox 29.0',0,34),('Mozilla Firefox 30.0',0,27),('eu',2,160),('Mozilla Firefox 31.0',0,223),('Mozilla Firefox 32.0',0,15),('Safari 534.18',0,1),('Mozilla Firefox 3.0.14',0,1),('Mozilla Firefox 33.0',0,10),('sc',2,3),('lb',2,6),('Mozilla Firefox 3.0.16',0,2),('es',2,9),('???????????',1,1),('localdomain',2,156517),('???????????',0,1),('???????????',1,1),('io',2,177),('adsl',2,19),('hu',2,11),('at',2,25),('be',2,21),('jp',2,88),('pl',2,43),('au',2,25),('fr',2,47),('nl',2,74),('fo',2,1),('tw',2,18),('hk',2,5),('lu',2,2),('ca',2,17),('dk',2,7),('br',2,2460),('nz',2,9),('cy',2,2),('sg',2,13),('gr',2,9),('Mozilla Firefox 34.0',0,32),('no',2,9),('is',2,1),('fi',2,3),('il',2,663),('in',2,7),('rs',2,5),('bm',2,1),('py',2,2),('id',2,14),('bg',2,146),('za',2,10),('cn',2,30),('Mozilla Firefox 35.0',0,63),('Safari 600.1.4',0,663),('hr',2,2),('no-data',2,1),('Mozilla Firefox 0.9.3',0,3),('lt',2,1),('vn',2,8),('Mozilla Firefox 36.0',0,24),('Safari 600.3.18',0,1),('Safari 600.4.10',0,6),('Mozilla Firefox 2.0.0.2',0,2),('Safari 600.5.17',0,7),('Mozilla Firefox 37.0',0,12),('Mozilla Firefox 0.9',0,2),('vodka',2,3),('Safari 600.6.3',0,15),('Safari 600.6.3',0,15),('Mozilla 3.0',0,2),('Mozilla Firefox 0.9.1',0,6),('Mozilla Firefox 39.0',0,4),('bd',2,5),('Safari 600.7.12',0,6),('AmigaVoyager 2.95',0,1),('Mozilla Firefox 38.0',0,19),('Safari 600.8.9',0,13),('Safari 534.20',0,1),('Mozilla Firefox 40.0',0,8),('Mozilla Firefox 41.0',0,15),('set',2,3),('Safari 601.1',0,84),('host',2,7),('Mozilla Firefox 42.0',0,18),('us',2,14),('Safari 533.20.27',0,2),('link',2,1),('Mozilla Firefox 43.0',0,36),('Mozilla Firefox 44.0',0,25),('Netscape ',0,10),('Wget 1.16.3',0,1),('Mozilla Firefox 2.0',0,2),('Mozilla Firefox 45.0',0,60),('Safari 537',0,11),('Safari 600.2.5',0,1),('Safari 534.48.3',0,4),('Safari 534.58.2',0,1),('Safari 533.18.5',0,5),('Safari 534.35',0,4),('Mozilla Firefox 46.0',0,22),('Mozilla Firefox 47.0',0,223),('Safari 537.85.12',0,7),('biz',2,2),('Safari 536.28.10',0,3),('expert',2,7),('Mozilla Firefox 2.0.0.1',0,1),('Wget 1.15',0,39),('Mozilla Firefox 49.0',0,9),('ninja',2,19),('Safari 602.1',0,13),('Safari 536.25',0,4),('Mozilla Firefox 40',0,2),('ovh',2,1),('IBrowse 2.1.1',0,1),('Mozilla Firefox 48.0',0,70),('Mozilla Firefox 50.0',0,17),('bn',2,2),('Mozilla Firefox 12.0.1',0,1),('Mozilla Firefox 51.0',0,16),('online',2,2),('kh',2,3),('do',2,2),('Mozilla Firefox 52.0',0,94),('3-622',2,4),('Mozilla Firefox 53.0',0,22),('MS Internet Explorer 10.6',0,5),('Safari 534.17',0,4),('Safari 536.29.13',0,2),('Safari 534.59.8',0,1),('Safari 533.22.3',0,2),('Konqueror 4.3',0,8),('Safari 534.15',0,11),('Mozilla Firefox 54.0',0,11),('sh',2,5),('camp',2,1),('Safari 603.2.4',0,2),('Mozilla Firefox 55.0',0,3),('ir',2,1),('eg',2,1),('IBrowse 9.1.3',0,1),('Safari 530.60',0,1),('Mozilla Firefox 40.1',0,15),('Safari 537.32',0,1),('Mozilla Firefox 56.0',0,6),('IBrowse 8.9.3',0,1),('Wget 1.19.2',0,2),('Safari 600.1.25',0,10),('Mozilla Firefox 57.0',0,68),('network',2,1),('Mozilla Firefox 3.0.11',0,1),('Safari 604.1',0,5),('GNU/Linux',1,3),('science',2,1),('uy',2,3),('Netscape 5',0,2),('space',2,5),('Safari 533.36',0,1),('Mozilla Firefox 33.1',0,14),('np',2,11),('Mozilla Firefox 58.0',0,13),('Mozilla Firefox 59.0',0,2),('Mozilla Firefox 30.1',0,7),('Mozilla Firefox 44.1',0,5),('Mozilla Firefox 37.1',0,5),('Mozilla Firefox 39.1',0,3),('Mozilla Firefox 43.1',0,3),('Mozilla Firefox 34.1',0,2),('Mozilla Firefox 32.1',0,9),('mu',2,1),('li',2,2),('vm',2,1),('Safari 601.7.7',0,152),('ec',2,4),('pd',2,1),('al',2,1),('top',2,1),('ae',2,1),('ba',2,1),('ni',2,1),('bo',2,1),('ly',2,1),('Safari 532.07',0,1),('ma',2,1),('Mozilla Firefox 51.0.1',0,2),('Safari 604.3.5',0,1),('Mozilla Firefox 60.0',0,41),('Safari 532.11',0,1),('Mozilla Firefox 62.0',0,16),('Mozilla Firefox 61.0',0,20),('Opera 12.0',0,1),('me',2,1),('nu',2,1),('Mozilla Firefox 63.0',0,3),('Mozilla Firefox 64.0',0,2),('Safari 530.72',0,1),('Mozilla Firefox 52.44.91',0,1),('Safari 532.02',0,1);
/*!40000 ALTER TABLE `bel_stats_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_template_positions`
--

DROP TABLE IF EXISTS `bel_template_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_template_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(10) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_template_positions`
--

LOCK TABLES `bel_template_positions` WRITE;
/*!40000 ALTER TABLE `bel_template_positions` DISABLE KEYS */;
INSERT INTO `bel_template_positions` VALUES (1,'left',''),(2,'right',''),(3,'top',''),(4,'bottom',''),(5,'inset',''),(6,'banner',''),(7,'header',''),(8,'footer',''),(9,'newsflash',''),(10,'legals',''),(11,'pathway',''),(12,'toolbar',''),(13,'cpanel',''),(14,'user1',''),(15,'user2',''),(16,'user3',''),(17,'user4',''),(18,'user5',''),(19,'user6',''),(20,'user7',''),(21,'user8',''),(22,'user9',''),(23,'advert1',''),(24,'advert2',''),(25,'advert3',''),(26,'icon',''),(27,'debug','');
/*!40000 ALTER TABLE `bel_template_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_templates_menu`
--

DROP TABLE IF EXISTS `bel_templates_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_templates_menu` (
  `template` varchar(50) NOT NULL DEFAULT '',
  `menuid` int(11) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`template`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_templates_menu`
--

LOCK TABLES `bel_templates_menu` WRITE;
/*!40000 ALTER TABLE `bel_templates_menu` DISABLE KEYS */;
INSERT INTO `bel_templates_menu` VALUES ('breeze',0,1),('beldoors',0,0);
/*!40000 ALTER TABLE `bel_templates_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_true`
--

DROP TABLE IF EXISTS `bel_true`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_true` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `imgtitle` text NOT NULL,
  `imgauthor` varchar(50) DEFAULT NULL,
  `imgtext` text NOT NULL,
  `imgdate` varchar(20) DEFAULT NULL,
  `imgvotes` int(11) NOT NULL DEFAULT '0',
  `imgvotesum` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `imgoriginalname` varchar(50) NOT NULL DEFAULT '',
  `imgfilename` varchar(50) NOT NULL DEFAULT '',
  `imgthumbname` varchar(50) NOT NULL DEFAULT '',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '62',
  `approved` int(1) NOT NULL DEFAULT '0',
  `useruploaded` int(1) NOT NULL DEFAULT '0',
  `field1` varchar(250) NOT NULL,
  `field2` varchar(250) NOT NULL,
  `field3` varchar(250) NOT NULL,
  `field4` varchar(250) NOT NULL,
  `field5` varchar(250) NOT NULL,
  `metadesc` varchar(250) NOT NULL,
  `metakey` varchar(250) NOT NULL,
  `tags` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_true`
--

LOCK TABLES `bel_true` WRITE;
/*!40000 ALTER TABLE `bel_true` DISABLE KEYS */;
INSERT INTO `bel_true` VALUES (44,1,'Модель М-13','','','1259334681',0,0,1,21,'7FED2A411C03-1.jpg','7FED2A411C03-1.jpg','7FED2A411C03-1.jpg',0,62,1,0,'','','','','','','',''),(43,1,'Модель М-11-1a','','','1259334428',0,0,1,13,'FCB56CACF8DE-1.png','FCB56CACF8DE-1.png','FCB56CACF8DE-1.png',0,62,1,0,'','','','','','','',''),(42,1,'Модель М-11-6','','','1259164570',0,0,1,20,'B841B8070E5E-1.jpg','B841B8070E5E-1.jpg','B841B8070E5E-1.jpg',0,62,1,0,'','','','','','','',''),(41,1,'Модель М-11-5','','','1259164587',0,0,1,19,'0040BE7C8D20-1.jpg','0040BE7C8D20-1.jpg','0040BE7C8D20-1.jpg',0,62,1,0,'','','','','','','',''),(40,1,'Модель М-11-4','','','1259333716',0,0,1,18,'1238D20457E4-1.jpg','1238D20457E4-1.jpg','1238D20457E4-1.jpg',0,62,1,0,'','','','','','','',''),(39,1,'Модель М-11-3','','','1259333727',0,0,1,17,'B421BF38D95D-1.jpg','B421BF38D95D-1.jpg','B421BF38D95D-1.jpg',0,62,1,0,'','','','','','','',''),(38,1,'Модель М-11-2b','','','1259333769',0,0,1,16,'77787CDAC24A-1.jpg','77787CDAC24A-1.jpg','77787CDAC24A-1.jpg',0,62,1,0,'','','','','','','',''),(37,1,'Модель М-11-2a','','','1259333760',0,0,1,15,'AB638C6A1291-1.jpg','AB638C6A1291-1.jpg','AB638C6A1291-1.jpg',0,62,1,0,'','','','','','','',''),(36,1,'Модель М-11-1b','','','1259333783',0,0,1,14,'137ED6028FC5-1.jpg','137ED6028FC5-1.jpg','137ED6028FC5-1.jpg',0,62,1,0,'','','','','','','',''),(35,1,'Модель М-9-2','','','1259333794',0,0,1,12,'E5AD5306475A-1.jpg','E5AD5306475A-1.jpg','E5AD5306475A-1.jpg',0,62,1,0,'','','','','','','',''),(34,1,'Модель М-9','','','1259333805',0,0,1,11,'7EDF764ECAD0-1.jpg','7EDF764ECAD0-1.jpg','7EDF764ECAD0-1.jpg',0,62,1,0,'','','','','','','',''),(110,7,'Модель M-4-2','','','1445608501',0,0,1,18,'E88BD2EDD97E-7.jpg','E88BD2EDD97E-7.jpg','E88BD2EDD97E-7.jpg',0,62,1,0,'','','','','','','',''),(109,1,'Модель M-17-2','','','1444729555',0,0,1,27,'CEBFD42ED8B6-1.jpg','CEBFD42ED8B6-1.jpg','CEBFD42ED8B6-1.jpg',0,62,1,0,'','','','','','','',''),(31,1,'Модель М-6','','','1259333846',0,0,1,8,'25E0ED518428-1.jpg','25E0ED518428-1.jpg','25E0ED518428-1.jpg',0,62,1,0,'','','','','','','',''),(30,1,'Модель М-4-2','','','1259333861',0,0,1,5,'F5E7E2E8D85F-1.jpg','F5E7E2E8D85F-1.jpg','F5E7E2E8D85F-1.jpg',0,62,1,0,'','','','','','','',''),(29,1,'Модель М-4','','','1259333871',0,0,1,4,'641D7C5A2C5C-1.jpg','641D7C5A2C5C-1.jpg','641D7C5A2C5C-1.jpg',0,62,1,0,'','','','','','','',''),(28,1,'Модель М-7-2','','','1468584506',0,0,1,10,'D71E8DAFC1AC-1.jpg','D71E8DAFC1AC-1.jpg','D71E8DAFC1AC-1.jpg',0,62,1,0,'','','','','','','',''),(27,1,'Модель М-7','','','1468584494',0,0,1,9,'056FF4D94B52-1.jpg','056FF4D94B52-1.jpg','056FF4D94B52-1.jpg',0,62,1,0,'','','','','','','',''),(26,1,'Модель М-1-3','','','1259333915',0,0,0,3,'75035A2616CC-1.jpg','75035A2616CC-1.jpg','75035A2616CC-1.jpg',0,62,1,0,'','','','','','','',''),(25,1,'Модель М-1-2','','','1259164551',0,0,1,2,'10A174DF4852-1.jpg','10A174DF4852-1.jpg','10A174DF4852-1.jpg',0,62,1,0,'','','','','','','',''),(24,1,'Модель М-1','','','1259164523',0,0,1,1,'9EC0457C04AD-1.jpg','9EC0457C04AD-1.jpg','9EC0457C04AD-1.jpg',0,62,1,0,'','','','','','','',''),(45,1,'Модель М-16','','','1259334705',0,0,1,24,'982DF730463A-1.jpg','982DF730463A-1.jpg','982DF730463A-1.jpg',0,62,1,0,'','','','','','','',''),(46,1,'Модель М-18','','','1259334727',0,0,1,28,'CC5AFCB25CB9-1.jpg','CC5AFCB25CB9-1.jpg','CC5AFCB25CB9-1.jpg',0,62,1,0,'','','','','','','',''),(47,1,'Модель М-19','','','1259334748',0,0,1,29,'A4E35DD284E6-1.jpg','A4E35DD284E6-1.jpg','A4E35DD284E6-1.jpg',0,62,1,0,'','','','','','','',''),(49,1,'Модель М-20','','','1259334834',0,0,0,30,'6353189AE862-1.jpg','6353189AE862-1.jpg','6353189AE862-1.jpg',0,62,1,0,'','','','','','','',''),(50,2,'МДФ-20','','','1259335626',0,0,0,20,'62B551750A52-2.png','62B551750A52-2.png','62B551750A52-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(51,2,'МДФ-1','','','1259335635',0,0,0,1,'5533DF97D299-2.png','5533DF97D299-2.png','5533DF97D299-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(52,2,'МДФ-2','','','1259335650',0,0,0,2,'3655EE78DADD-2.png','3655EE78DADD-2.png','3655EE78DADD-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(53,2,'МДФ-3','','','1259335661',0,0,0,3,'9A9CB8E13DE2-2.png','9A9CB8E13DE2-2.png','9A9CB8E13DE2-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(54,2,'МДФ-4','','','1259335674',0,0,0,4,'0577BDA92584-2.png','0577BDA92584-2.png','0577BDA92584-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(55,2,'МДФ-5','','','1259335688',0,0,0,5,'4B72480BBDC8-2.png','4B72480BBDC8-2.png','4B72480BBDC8-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(56,2,'МДФ-6','','','1259335702',0,0,0,6,'C6D202F2DB7E-2.png','C6D202F2DB7E-2.png','C6D202F2DB7E-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(57,2,'МДФ-7','','','1259335748',0,0,0,7,'ACCB3B3ACC4D-2.png','ACCB3B3ACC4D-2.png','ACCB3B3ACC4D-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(58,2,'МДФ-8','','','1259335524',0,0,0,8,'3817801A49A7-2.png','3817801A49A7-2.png','3817801A49A7-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(59,2,'МДФ-9','','','1259335524',0,0,0,9,'80524382B264-2.png','80524382B264-2.png','80524382B264-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(60,2,'МДФ-10','','','1259335525',0,0,0,10,'E0E21A2C2808-2.png','E0E21A2C2808-2.png','E0E21A2C2808-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(61,2,'МДФ-11','','','1259335526',0,0,0,11,'F8243B629DE7-2.png','F8243B629DE7-2.png','F8243B629DE7-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(62,2,'МДФ-12','','','1259335527',0,0,0,12,'A646B5BB6AC8-2.png','A646B5BB6AC8-2.png','A646B5BB6AC8-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(63,2,'МДФ-13','','','1259335528',0,0,0,13,'A1CD1AF6DC08-2.png','A1CD1AF6DC08-2.png','A1CD1AF6DC08-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(64,2,'МДФ-14','','','1259335529',0,0,0,14,'2D32A11BDDF0-2.png','2D32A11BDDF0-2.png','2D32A11BDDF0-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(65,2,'МДФ-15','','','1259335530',0,0,0,15,'CBDE7E4C89FD-2.png','CBDE7E4C89FD-2.png','CBDE7E4C89FD-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(66,2,'МДФ-16','','','1259335531',0,0,0,16,'5BF19177F7F8-2.png','5BF19177F7F8-2.png','5BF19177F7F8-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(67,2,'МДФ-17','','','1259335532',0,0,0,17,'36CCE6DF9FD9-2.png','36CCE6DF9FD9-2.png','36CCE6DF9FD9-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(68,2,'МДФ-18','','','1259335533',0,0,0,18,'26FD08089514-2.png','26FD08089514-2.png','26FD08089514-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(69,2,'МДФ-19','','','1259335533',0,0,0,19,'954648FCC06A-2.png','954648FCC06A-2.png','954648FCC06A-2.png',0,62,1,0,'','','','','','','','МДФ, двери'),(70,7,'Модель М-18','','','1259397312',0,0,1,1,'C72C338C888F-4.jpg','C72C338C888F-4.jpg','C72C338C888F-4.jpg',0,62,1,0,'','','','','','','',''),(71,7,'Модель М-19','','','1259397341',0,0,1,2,'6881524B7931-4.jpg','6881524B7931-4.jpg','6881524B7931-4.jpg',0,62,1,0,'','','','','','','',''),(72,7,'Модель М-20','','','1259397367',0,0,1,3,'01843461863F-4.jpg','01843461863F-4.jpg','01843461863F-4.jpg',0,62,1,0,'','','','','','','',''),(77,1,'Каталог массив','','','1259400082',0,0,0,27,'2D93DBA0FE49-1.jpg','2D93DBA0FE49-1.jpg','2D93DBA0FE49-1.jpg',0,62,1,0,'','','','','','','',''),(76,7,'Отделочная линия SUPERFICCI','','<div align=\"justify\">Последним этапом в процессе изготовления дверных блоков из массива сосны является завершающая шлифовка и отделка. Для этого используются широколенточные шлифовальные станки DMC (Италия), а так же автоматическая отделочная линия SUPERFICCI.</div>','1261661003',0,0,1,7,'FDCC9CB4F92C-5.jpg','FDCC9CB4F92C-5.jpg','FDCC9CB4F92C-5.jpg',0,62,1,0,'','','','','','','',''),(75,7,'Сборочный пресс STROMAB','','<div align=\"justify\">Сборка дверных полотен из массива сосны на гидравлическом прессе STROMAB.</div>','1261660938',0,0,1,6,'FF3E9E92F661-5.jpg','FF3E9E92F661-5.jpg','FF3E9E92F661-5.jpg',0,62,1,0,'','','','','','','',''),(78,3,'Каталог цветов','','','1259400397',0,0,0,1,'2A9B939B34CC-3.jpg','2A9B939B34CC-3.jpg','2A9B939B34CC-3.jpg',0,62,1,0,'','','','','','','',''),(79,7,'Каталог интерьер','','','1259400462',0,0,0,7,'D76D9B666AC5-4.jpg','D76D9B666AC5-4.jpg','D76D9B666AC5-4.jpg',0,62,1,0,'','','','','','','',''),(80,5,'Каталог технологии','','','1259400580',0,0,0,5,'4B9B8EF90D4E-5.jpg','4B9B8EF90D4E-5.jpg','4B9B8EF90D4E-5.jpg',0,62,1,0,'','','','','','','',''),(81,2,'Каталог МДФ','','','1259400612',0,0,0,21,'73A9D37A6178-2.jpg','73A9D37A6178-2.jpg','73A9D37A6178-2.jpg',0,62,1,0,'','','','','','','',''),(84,7,'Санузел Модель М-7','','Санузел Модель М-2','1468585414',0,0,1,4,'D9C03982A542-4.jpg','D9C03982A542-4.jpg','D9C03982A542-4.jpg',0,62,1,0,'','','','','','','','Санузел Модель М-2'),(85,7,'Экструзионная линия MONTBLANC','','<div align=\"justify\">Производство профильных систем MONTBLANC оснащено экструзионными линиями только нового поколения, изготовленными и прошедшими испытания на заводах австрийской фирмы GRUBER &amp; Co Group.</div>','1261660376',0,0,0,10,'2A1CB187A409-5.jpg','2A1CB187A409-5.jpg','2A1CB187A409-5.jpg',0,62,1,0,'','','','','','','','Экструзионная линия MONTBLANC'),(86,7,'Завод по производству профиля MONTBLANC','','<div align=\"justify\">В 2000 году английская фирма STL Extrusion Technology Limited совместно с австрийской фирмой A+G Extrusion Technology gmbh организовали на территории Московской области предприятие по производству ПВХ-профилей оконных систем под торговой маркой MONTBLANC.</div>','1261660361',0,0,0,9,'25BE05936205-5.jpg','25BE05936205-5.jpg','25BE05936205-5.jpg',0,62,1,0,'','','','','','','','Завод по производству профиля MONTBLANC'),(87,7,'Линия оптимизации SALVADOR','','Линия оптимизации SALVADOR позволяет осуществлять операцию выпиливания дефектов. К особенности данной линии хотелось бы отнести ее производительность (примерно 40-50 тыс. пропилов в смену).','1261661212',0,0,1,8,'1D60F0170CA6-5.jpg','1D60F0170CA6-5.jpg','1D60F0170CA6-5.jpg',0,62,1,0,'','','','','','','','Линия оптимизации SALVADOR'),(88,7,'Палитра МАВ','','','1261661513',0,0,0,15,'FA9226E5D88C-3.jpg','FA9226E5D88C-3.jpg','FA9226E5D88C-3.jpg',0,62,1,0,'','','','','','','','Палитра МАВ'),(89,6,'Каталог документы','','Каталог документы','1262188280',0,0,0,1,'03F4F7C2B26B-6.jpg','03F4F7C2B26B-6.jpg','03F4F7C2B26B-6.jpg',0,62,1,0,'','','','','','','','Каталог документы'),(90,6,'Двери ПВХ (Удостоверение о гигиене)','','Удостоверение о государтсвенной гигиенической регистрации.','1262188682',0,0,0,2,'50D4FA801595-6.jpg','50D4FA801595-6.jpg','50D4FA801595-6.jpg',0,62,1,0,'','','','','','','','Удостоверение о государтсвенной гигиенической регистрации.'),(91,7,'Модель М-7-2','','Распашная дверь в зальную комнату.','1468585441',0,0,1,32,'10C19FEB72ED-4.jpg','10C19FEB72ED-4.jpg','10C19FEB72ED-4.jpg',0,62,1,0,'','','','','','','',''),(92,6,'Двери массив (Сертификат соответствия)','','Сертификат соответствия СТБ 1138-98 дверей из массива сосны.','1263162673',0,0,0,3,'8961A795F739-6.jpg','8961A795F739-6.jpg','8961A795F739-6.jpg',0,62,1,0,'','','','','','','',''),(97,7,'Модель M-7 (210 х 130)','','','1468585488',0,0,1,22,'B9B4A011F84F-7.jpg','B9B4A011F84F-7.jpg','B9B4A011F84F-7.jpg',0,62,1,0,'','','','','','','',''),(98,7,'Модель M-17-2','','','1444727606',0,0,1,9,'97304F7D1AC6-7.jpg','97304F7D1AC6-7.jpg','97304F7D1AC6-7.jpg',0,62,1,0,'','','','','','','',''),(99,1,'Модель M-17','','','1444727596',0,0,1,26,'BC149B51BD83-7.jpg','BC149B51BD83-7.jpg','BC149B51BD83-7.jpg',0,62,1,0,'','','','','','','',''),(100,7,'Модель M-7 с витражом','','','1468585510',0,0,1,23,'3E32AC02E4D4-7.jpg','3E32AC02E4D4-7.jpg','3E32AC02E4D4-7.jpg',0,62,1,0,'','','','','','','',''),(101,7,'Модель M-16-2','','','1444727750',0,0,1,11,'6BCBCA0FF0FA-7.jpg','6BCBCA0FF0FA-7.jpg','6BCBCA0FF0FA-7.jpg',0,62,1,0,'','','','','','','',''),(111,7,'Модель M-9','','','1445932555',0,0,1,19,'FC4067866A93-7.jpg','FC4067866A93-7.jpg','FC4067866A93-7.jpg',0,62,1,0,'','','','','','','',''),(103,7,'Модель M-17','','','1444727892',0,0,1,13,'91C97BC18102-7.jpg','91C97BC18102-7.jpg','91C97BC18102-7.jpg',0,62,1,0,'','','','','','','',''),(104,7,'Модель M-7','','','1468585391',0,0,1,17,'EFA01D1C016D-7.jpg','EFA01D1C016D-7.jpg','EFA01D1C016D-7.jpg',0,62,1,0,'','','','','','','',''),(105,7,'филёнка','','','1444728220',0,0,1,5,'76604A354C9F-7.jpg','76604A354C9F-7.jpg','76604A354C9F-7.jpg',0,62,1,0,'','','','','','','',''),(106,7,'Модель М-1 со вставкой на 400 мм','','','1444729117',0,0,1,12,'59DA8DB27231-7.jpg','59DA8DB27231-7.jpg','59DA8DB27231-7.jpg',0,62,1,0,'','','','','','','',''),(107,1,'Модель M-5','','','1444729236',0,0,1,6,'E57ADC24CBC7-1.jpg','E57ADC24CBC7-1.jpg','E57ADC24CBC7-1.jpg',0,62,1,0,'','','','','','','',''),(108,1,'Модель М-5-2','','','1444729374',0,0,1,7,'618E0DFDC96A-1.jpg','618E0DFDC96A-1.jpg','618E0DFDC96A-1.jpg',0,62,1,0,'','','','','','','',''),(112,7,'Модель М-5 ','','','1453725192',0,0,1,16,'99F6980AE53A-7.jpg','99F6980AE53A-7.jpg','99F6980AE53A-7.jpg',0,62,1,0,'','','','','','','',''),(114,7,'Модель M-7-2(210 х 130)','','','1468585366',0,0,1,20,'83631599298A-7.jpg','83631599298A-7.jpg','83631599298A-7.jpg',0,62,1,0,'','','','','','','',''),(115,7,'Модель M-7 (саунзел)','','','1468585349',0,0,1,14,'F8C9C7805CDA-7.jpg','F8C9C7805CDA-7.jpg','F8C9C7805CDA-7.jpg',0,62,1,0,'','','','','','','',''),(116,7,'Модель M-17 (210 х 130)','','','1455285504',0,0,1,10,'5748055F4A7B-7.jpg','5748055F4A7B-7.jpg','5748055F4A7B-7.jpg',0,62,1,0,'','','','','','','',''),(117,7,'Модель M-9','','','1458894771',0,0,1,15,'9594F7775256-7.jpg','9594F7775256-7.jpg','9594F7775256-7.jpg',0,62,1,0,'','','','','','','',''),(118,7,'Модель M-9 (210 х 130)','','','1458894823',0,0,1,62,'344E43B0DC39-7.jpg','344E43B0DC39-7.jpg','344E43B0DC39-7.jpg',0,62,1,0,'','','','','','','',''),(141,1,'Модель M-15-2','','','1494852737',0,0,1,23,'B7D9DA9AB2A3-1.png','B7D9DA9AB2A3-1.png','B7D9DA9AB2A3-1.png',0,62,1,0,'','','','','','','',''),(142,1,'Модель M 16-2','','','1494852949',0,0,1,25,'54BA338D0D9E-1.png','54BA338D0D9E-1.png','54BA338D0D9E-1.png',0,62,1,0,'','','','','','','',''),(156,7,'Модель М-11-2Б','','','1496167782',0,0,1,39,'7985C8E4ACCD-7.jpg','7985C8E4ACCD-7.jpg','7985C8E4ACCD-7.jpg',0,62,1,0,'','','','','','','',''),(155,7,'Модель М-15-2','','','1496167707',0,0,1,38,'A9AE9CBFE5B8-7.jpg','A9AE9CBFE5B8-7.jpg','A9AE9CBFE5B8-7.jpg',0,62,1,0,'','','','','','','',''),(154,7,'Модель M-17 в интерьере','','','1494942904',0,0,1,36,'02C6115D9902-7.jpg','02C6115D9902-7.jpg','02C6115D9902-7.jpg',0,62,1,0,'','','','','','','',''),(152,7,'Модель M-17 (210 х 130)','','','1494942826',0,0,1,34,'4257BC73D61D-7.jpg','4257BC73D61D-7.jpg','4257BC73D61D-7.jpg',0,62,1,0,'','','','','','','',''),(153,7,'Модель M-9','','','1494942880',0,0,1,35,'D2EE5CBA15FD-7.jpg','D2EE5CBA15FD-7.jpg','D2EE5CBA15FD-7.jpg',0,62,1,0,'','','','','','','',''),(151,7,'Модель M-1-2','','','1494939974',0,0,1,33,'032645D9B2F8-7.jpg','032645D9B2F8-7.jpg','032645D9B2F8-7.jpg',0,62,1,0,'','','','','','','',''),(150,7,'Модель M-17','','','1494939803',0,0,1,24,'C50CBF0B3DA5-7.jpg','C50CBF0B3DA5-7.jpg','C50CBF0B3DA5-7.jpg',0,62,1,0,'','','','','','','',''),(148,7,'Модель M-13','','','1494939556',0,0,1,29,'056C528933C5-7.jpg','056C528933C5-7.jpg','056C528933C5-7.jpg',0,62,1,0,'','','','','','','',''),(149,7,'Модель M-17-2 в интерьере','','','1494939736',0,0,1,32,'0EDD4357A487-7.jpg','0EDD4357A487-7.jpg','0EDD4357A487-7.jpg',0,62,1,0,'','','','','','','',''),(143,7,'Модель M-7-2 (210 х 130) до и после','','','1494860288',0,0,1,31,'4B886A8E9B09-7.jpg','4B886A8E9B09-7.jpg','4B886A8E9B09-7.jpg',0,62,1,0,'','','','','','','',''),(144,7,'Модель M-7 кабинеты','','','1494860195',0,0,1,26,'6291692CFEEE-7.jpg','6291692CFEEE-7.jpg','6291692CFEEE-7.jpg',0,62,1,0,'','','','','','','',''),(145,7,'Модель M-1-2 (80 +40)','','','1494860252',0,0,1,27,'54149AB28897-7.jpg','54149AB28897-7.jpg','54149AB28897-7.jpg',0,62,1,0,'','','','','','','',''),(146,7,'Модель M-5 в интерьере','','','1494860326',0,0,1,28,'D308CF171BEC-7.jpg','D308CF171BEC-7.jpg','D308CF171BEC-7.jpg',0,62,1,0,'','','','','','','',''),(147,7,'Модель M-7','','','1494860378',0,0,1,30,'47FB00FB814F-7.jpg','47FB00FB814F-7.jpg','47FB00FB814F-7.jpg',0,62,1,0,'','','','','','','',''),(140,1,'Модель M-15','','','1494852360',0,0,1,22,'09D372F32E80-1.png','09D372F32E80-1.png','09D372F32E80-1.png',0,62,1,0,'','','','','','','',''),(157,7,'Модель M-16-2','','','1496998555',0,0,1,42,'0064F3C5D945-7.jpg','0064F3C5D945-7.jpg','0064F3C5D945-7.jpg',0,62,1,0,'','','','','','','',''),(158,7,'Модель M-15-2','','','1496998535',0,0,1,41,'1FB6DF389B41-7.jpg','1FB6DF389B41-7.jpg','1FB6DF389B41-7.jpg',0,62,1,0,'','','','','','','',''),(159,7,'Модель M-4','','','1497353382',0,0,1,43,'B508A6D2A6BD-7.jpg','B508A6D2A6BD-7.jpg','B508A6D2A6BD-7.jpg',0,62,1,0,'','','','','','','',''),(160,7,'Модель М-7 со вставкой на 400 мм','','','1497958040',0,0,1,44,'D6137CDAE9AB-7.jpg','D6137CDAE9AB-7.jpg','D6137CDAE9AB-7.jpg',0,62,1,0,'','','','','','','',''),(161,7,'Модель M-11-6','','','1510231144',0,0,1,45,'66A0318C9607-7.jpg','66A0318C9607-7.jpg','66A0318C9607-7.jpg',0,62,1,0,'','','','','','','',''),(162,7,'Модель M-7','','','1510231205',0,0,1,46,'64BB2E42DF3A-7.jpg','64BB2E42DF3A-7.jpg','64BB2E42DF3A-7.jpg',0,62,1,0,'','','','','','','',''),(163,7,'Модель M-13 в интерьере','','','1511177020',0,0,1,47,'BE8F2E7F2AE8-7.jpg','BE8F2E7F2AE8-7.jpg','BE8F2E7F2AE8-7.jpg',0,62,1,0,'','','','','','','',''),(164,7,'Модель M-16-2','','','1511437630',0,0,1,49,'953EFEBDDFBB-7.jpg','953EFEBDDFBB-7.jpg','953EFEBDDFBB-7.jpg',0,62,1,0,'','','','','','','',''),(167,7,'Модель M-7-2 раздвижная','','','1519216341',0,0,1,53,'C51AF1706CA6-7.jpg','C51AF1706CA6-7.jpg','C51AF1706CA6-7.jpg',0,62,1,0,'','','','','','','',''),(166,7,'Модель M-7-2 рамка без перемычек','','','1518772838',0,0,1,51,'5978A8824C5A-7.jpg','5978A8824C5A-7.jpg','5978A8824C5A-7.jpg',0,62,1,0,'','','','','','','',''),(168,7,'Модель M-7-2 (210 х 170) раздвижная','','','1519216443',0,0,1,54,'4862E98B934B-7.jpg','4862E98B934B-7.jpg','4862E98B934B-7.jpg',0,62,1,0,'','','','','','','',''),(169,7,'Модель M-7 коньяк','','','1521471482',0,0,1,55,'3718F61DB124-7.jpg','3718F61DB124-7.jpg','3718F61DB124-7.jpg',0,62,1,0,'','','','','','','',''),(170,7,'Модель M-7 (210 х 130)','','','1521471542',0,0,1,56,'9E128A41A400-7.jpg','9E128A41A400-7.jpg','9E128A41A400-7.jpg',0,62,1,0,'','','','','','','',''),(177,7,'Модель M-5 в интерьере','','','1540394070',0,0,1,61,'E8F83B1D9681-7.jpg','E8F83B1D9681-7.jpg','E8F83B1D9681-7.jpg',0,62,1,0,'','','','','','','',''),(176,7,'Модель M-7 (саунзел)','','','1540393927',0,0,1,60,'BDB3554AFBDE-7.jpg','BDB3554AFBDE-7.jpg','BDB3554AFBDE-7.jpg',0,62,1,0,'','','','','','','',''),(175,7,'Модель M-5','','','1540393723',0,0,1,59,'96F15AAA0EA9-7.jpg','96F15AAA0EA9-7.jpg','96F15AAA0EA9-7.jpg',0,62,1,0,'','','','','','','',''),(178,7,'Модель M-5 белый воск','','','1540394359',0,0,1,21,'AD332CAD22B9-7.jpg','AD332CAD22B9-7.jpg','AD332CAD22B9-7.jpg',0,62,1,0,'','','','','','','',''),(179,7,'Модель M-4 санузел','','','1543936686',0,0,1,63,'2F1DBDD8AFEE-7.jpg','2F1DBDD8AFEE-7.jpg','2F1DBDD8AFEE-7.jpg',0,62,1,0,'','','','','','','','');
/*!40000 ALTER TABLE `bel_true` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_true_catg`
--

DROP TABLE IF EXISTS `bel_true_catg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_true_catg` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `parent` varchar(255) NOT NULL DEFAULT '0',
  `description` text,
  `desc_full` text,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `published` char(1) NOT NULL DEFAULT '0',
  `cmetadesc` varchar(250) NOT NULL,
  `cmetakey` varchar(250) NOT NULL,
  `menulink` char(1) NOT NULL DEFAULT '0',
  `menuselecttype` varchar(100) NOT NULL DEFAULT '0',
  `catimg` int(11) DEFAULT NULL,
  `usercat` int(11) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_true_catg`
--

LOCK TABLES `bel_true_catg` WRITE;
/*!40000 ALTER TABLE `bel_true_catg` DISABLE KEYS */;
INSERT INTO `bel_true_catg` VALUES (1,'Массив сосны','0','<br /><font style=\"font-size: 11px\">В каталоге расположен весь предоставляемый модельный ряд на двери из массива сосны.</font>','',7,0,'1','','','0','mainmenu',77,NULL),(7,'Разное','0','','',1,0,'1','','','0','mainmenu',79,NULL);
/*!40000 ALTER TABLE `bel_true_catg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_true_config`
--

DROP TABLE IF EXISTS `bel_true_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_true_config` (
  `ad_path` varchar(250) DEFAULT 'trueimg',
  `ad_protect` int(1) NOT NULL DEFAULT '0',
  `ad_orgresize` int(1) NOT NULL DEFAULT '0',
  `ad_orgwidth` int(11) NOT NULL DEFAULT '800',
  `ad_orgheight` int(11) NOT NULL DEFAULT '600',
  `ad_thumbwidth` int(11) NOT NULL DEFAULT '120',
  `ad_thumbheight` int(11) NOT NULL DEFAULT '120',
  `ad_crsc` int(1) NOT NULL DEFAULT '0',
  `ad_thumbquality` int(3) NOT NULL DEFAULT '90',
  `ad_showdetail` int(1) NOT NULL DEFAULT '1',
  `ad_showrating` int(1) NOT NULL DEFAULT '1',
  `ad_showcomment` int(1) NOT NULL DEFAULT '1',
  `ad_pathway` int(1) NOT NULL DEFAULT '1',
  `ad_showpanel` int(1) NOT NULL DEFAULT '1',
  `ad_userpannel` int(1) NOT NULL DEFAULT '1',
  `ad_special` int(1) NOT NULL DEFAULT '1',
  `ad_rating` int(1) NOT NULL DEFAULT '1',
  `ad_lastadd` int(1) NOT NULL DEFAULT '1',
  `ad_owners` int(1) NOT NULL DEFAULT '1',
  `ad_lastcomment` int(1) NOT NULL DEFAULT '1',
  `ad_showinformer` int(1) NOT NULL DEFAULT '1',
  `ad_periods` int(11) NOT NULL DEFAULT '604800',
  `ad_search` int(1) NOT NULL DEFAULT '1',
  `ad_comtitle` int(1) NOT NULL DEFAULT '1',
  `ad_showsend2friend` int(1) NOT NULL DEFAULT '1',
  `ad_picincat` int(1) NOT NULL DEFAULT '1',
  `ad_powered` int(1) NOT NULL DEFAULT '1',
  `ad_showwatermark` int(1) NOT NULL DEFAULT '0',
  `ad_showdownload` int(1) NOT NULL,
  `ad_downpub` int(1) NOT NULL,
  `ad_perpage` int(5) NOT NULL DEFAULT '16',
  `ad_catsperpage` int(5) NOT NULL DEFAULT '6',
  `ad_sortby` varchar(50) DEFAULT 'ASC',
  `ad_toplist` int(11) NOT NULL DEFAULT '20',
  `ad_approve` int(1) NOT NULL DEFAULT '0',
  `ad_maxuserimage` int(11) NOT NULL DEFAULT '200',
  `ad_maxfilesize` int(22) NOT NULL DEFAULT '120000000',
  `ad_maxwidth` int(11) NOT NULL DEFAULT '448',
  `ad_maxheight` int(11) NOT NULL DEFAULT '332',
  `ad_category` int(1) NOT NULL,
  `ad_imgstyle` int(1) NOT NULL,
  `ad_ncsc` int(1) NOT NULL DEFAULT '2',
  `ad_showimgtext` int(1) NOT NULL DEFAULT '1',
  `ad_showfimgdate` int(1) NOT NULL DEFAULT '1',
  `ad_showimgcounter` int(1) NOT NULL DEFAULT '1',
  `ad_showfrating` int(1) NOT NULL DEFAULT '1',
  `ad_showres` int(1) NOT NULL DEFAULT '1',
  `ad_showfimgsize` int(1) NOT NULL DEFAULT '1',
  `ad_showimgauthor` int(1) NOT NULL DEFAULT '1',
  `ad_cp` int(1) NOT NULL DEFAULT '4',
  `ad_lightbox` int(1) NOT NULL DEFAULT '1',
  `ad_lightbox_fa` int(1) NOT NULL DEFAULT '1',
  `ad_js_effect` int(1) NOT NULL DEFAULT '2',
  `ad_cat_desc` int(1) NOT NULL DEFAULT '1',
  `ad_field1` int(1) NOT NULL DEFAULT '0',
  `ad_field2` int(1) NOT NULL DEFAULT '0',
  `ad_field3` int(1) NOT NULL DEFAULT '0',
  `ad_field4` int(1) NOT NULL DEFAULT '0',
  `ad_field5` int(1) NOT NULL DEFAULT '0',
  `ad_mini_to_js` int(1) NOT NULL DEFAULT '0',
  `ad_status1` int(11) NOT NULL DEFAULT '5',
  `ad_status2` int(11) NOT NULL DEFAULT '15',
  `ad_status3` int(11) NOT NULL DEFAULT '30',
  `ad_status4` int(11) NOT NULL DEFAULT '50',
  `ad_status5` int(11) NOT NULL DEFAULT '100',
  `ad_cat_img_detail` int(1) NOT NULL DEFAULT '1',
  `ad_carusel` int(1) NOT NULL DEFAULT '1',
  `ad_bbhtml` int(1) NOT NULL DEFAULT '1',
  `ad_toggle` int(1) NOT NULL DEFAULT '0',
  `ad_lang` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_true_config`
--

LOCK TABLES `bel_true_config` WRITE;
/*!40000 ALTER TABLE `bel_true_config` DISABLE KEYS */;
INSERT INTO `bel_true_config` VALUES ('/images/trueimg',0,1,800,800,100,250,1,80,1,0,0,1,0,1,1,1,1,1,1,0,604800,0,0,0,1,0,1,0,0,30,6,'ASC',20,1,200,120000000,500,400,7,0,2,1,0,1,0,0,0,0,4,1,1,2,1,0,0,0,0,0,0,5,15,30,50,100,1,0,0,0,'');
/*!40000 ALTER TABLE `bel_true_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_true_count`
--

DROP TABLE IF EXISTS `bel_true_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_true_count` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `imgid` int(10) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_true_count`
--

LOCK TABLES `bel_true_count` WRITE;
/*!40000 ALTER TABLE `bel_true_count` DISABLE KEYS */;
INSERT INTO `bel_true_count` VALUES (46,46,1085),(45,45,1086),(44,44,1103),(43,43,987),(42,42,1034),(41,41,1051),(40,40,984),(39,39,1041),(38,38,1026),(37,37,1034),(36,36,1013),(35,35,1016),(34,34,1005),(110,110,526),(109,109,464),(31,31,955),(30,30,961),(29,29,1028),(28,28,1000),(27,27,1016),(26,26,970),(25,25,1342),(24,24,1099),(47,47,1179),(49,49,1052),(50,50,694),(51,51,749),(52,52,699),(53,53,736),(54,54,742),(55,55,676),(56,56,732),(57,57,869),(58,58,743),(59,59,735),(60,60,777),(61,61,686),(62,62,731),(63,63,725),(64,64,705),(65,65,777),(66,66,696),(67,67,779),(68,68,750),(69,69,678),(70,70,1290),(71,71,1179),(72,72,1252),(77,77,0),(76,76,1198),(75,75,1083),(78,78,1),(79,79,0),(80,80,0),(81,81,0),(88,88,1288),(87,87,1472),(84,84,1234),(85,85,1026),(86,86,1002),(89,89,0),(90,90,26),(91,91,1234),(92,92,20),(97,97,589),(98,98,505),(99,99,491),(100,100,533),(101,101,519),(111,111,534),(103,103,544),(104,104,510),(105,105,523),(106,106,541),(107,107,432),(108,108,456),(112,112,521),(114,114,441),(115,115,430),(116,116,493),(117,117,436),(118,118,523),(141,141,183),(142,142,182),(159,159,183),(151,151,177),(150,150,186),(149,149,197),(148,148,211),(158,158,182),(157,157,159),(147,147,195),(146,146,193),(145,145,281),(156,156,187),(144,144,204),(143,143,242),(155,155,181),(154,154,194),(153,153,201),(152,152,186),(140,140,184),(160,160,184),(161,161,108),(162,162,115),(163,163,118),(164,164,112),(167,167,91),(166,166,94),(168,168,95),(169,169,68),(170,170,68),(177,177,24),(176,176,22),(175,175,23),(178,178,29),(179,179,4);
/*!40000 ALTER TABLE `bel_true_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_true_votes`
--

DROP TABLE IF EXISTS `bel_true_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_true_votes` (
  `vpic` int(11) NOT NULL DEFAULT '0',
  `vip` varchar(255) NOT NULL DEFAULT '',
  `vote` int(11) NOT NULL DEFAULT '0',
  `user` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(100) DEFAULT NULL,
  UNIQUE KEY `vpic` (`vpic`,`vip`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_true_votes`
--

LOCK TABLES `bel_true_votes` WRITE;
/*!40000 ALTER TABLE `bel_true_votes` DISABLE KEYS */;
INSERT INTO `bel_true_votes` VALUES (1,'88.198.170.118static.88-198-170-118.clients.your-server.de',3,'guest','1'),(1,'46.4.209.126static.126.209.4.46.clients.your-server.de',3,'guest','1'),(1,'46.4.253.146co-maild.co.uk61439',0,'guest','1'),(1,'1',0,'guest','1'),(1,'46.4.253.146co-maild.co.uk20881',0,'guest','1'),(1,'46.4.253.146co-maild.co.uk25563',0,'guest','1'),(1,'46.4.253.146co-maild.co.uk38189',0,'guest','1'),(1,'46.4.253.146co-maild.co.uk48808',0,'guest','1'),(1,'46.4.253.146co-maild.co.uk24119',0,'guest','1');
/*!40000 ALTER TABLE `bel_true_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_users`
--

DROP TABLE IF EXISTS `bel_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_users`
--

LOCK TABLES `bel_users` WRITE;
/*!40000 ALTER TABLE `bel_users` DISABLE KEYS */;
INSERT INTO `bel_users` VALUES (62,'Administrator','admin','mm112@mail.ru','565cf9cc1ae7ac13ad0e4da35ef8ee95:c555idVwj3sARkMa','Super Administrator',0,1,25,'2009-11-05 15:24:21','2018-10-24 15:23:57','','expired=\nexpired_time='),(63,'Олег Клос','alex2597','alexklos@list.ru','0d5f3a2327d90e6a8cb2ad923447a442:TsX8lwLV7RzEiYot','',0,0,18,'2010-04-25 13:52:18','2010-09-16 14:05:29','',''),(64,'александр','best','suzs@rambler.ru','e6be4fce7f7fa58caa1df1b879ac6f23:rdNiCtJ2w6MRJpgT','',0,0,18,'2010-08-01 21:03:16','0000-00-00 00:00:00','',''),(65,'Хабров А.Н.','director','xabroff@rambler.ru','f331078a8b3bb7b393d02b4048dcb876:aJP2dPNKEZ1XZAP4','Super Administrator',0,0,25,'2011-05-29 21:14:08','2017-05-30 13:34:37','','editor=\nexpired=\nexpired_time='),(66,'qwert','qwert','qwert@mailinator.com','1de871f2eacaeae227659d6701d70760:98Ty6vkkBC9yLR98','',0,0,18,'2011-08-18 20:08:02','2011-08-18 20:10:22','',''),(67,'Расч т стоимости рекламы на яндексе','Раскрутить ссылку','seo@sswe.ru','0a48a049aea535f2468884578b48fcce:xWfR2EOGRVMx4fXw','',0,0,18,'2011-09-16 05:16:55','0000-00-00 00:00:00','',''),(68,'Игры для телефона Samsung C3300','Конструкторы Java игр','170911@smle.ru','e56c597f0a9cd845019a862967557cf5:GO2vagDDeKM50miZ','',0,0,18,'2011-09-17 04:19:53','0000-00-00 00:00:00','',''),(69,'Юлия','Юлия','230911@mpouyut.ru','d8879ea48bf3244f993e2a6a3050472f:Clg72ymjkRg7gaKU','',0,0,18,'2011-09-23 07:17:03','0000-00-00 00:00:00','',''),(70,'Добавить сайт в Яндекс','Добавить сайт в Яндекс','addurl@ssve.ru','5b446fbc418bae3f96db7ab408854ae1:fMDTDtD5VYhtwakd','',0,0,18,'2011-11-05 03:59:18','0000-00-00 00:00:00','',''),(71,'Ремонт квартир в Екатеринбурге · http://rem66.ru/','Ремонт квартир в Екатерин','151111@rem66.ru','bf58361fe04733aab57cffebf7585689:cY4J3mq5qRTREvxT','',0,0,18,'2011-11-20 11:52:29','0000-00-00 00:00:00','',''),(72,'Кнопка «Бабло!»','Кнопка «Бабло!»','bablo@bablo.ssve.ru','04d97e72c4904491898e5321f2599289:VQREtsAUl1uZQkdN','',0,0,18,'2011-12-10 04:17:58','0000-00-00 00:00:00','',''),(73,'Game Of Thrones Genesis отзывы','Game Of Thrones Hbo','1@smle.ru','27fecdeffa23c0ed8900c12504b887a9:6WlCJfGvnTuZ45Py','',0,0,18,'2011-12-11 15:20:17','0000-00-00 00:00:00','',''),(74,'Game Boy Advance отзывы','Game Boy Advance прошивка','0@smle.ru','c846e3179ca47ba5e5bea5fa766be5e6:0N6OeEEi0DXSMDD8','',0,0,18,'2011-12-12 05:18:49','0000-00-00 00:00:00','',''),(75,'Ремонт квартир Екатеринбург','Ремонт квартир Екатеринбу','ekaterinburg@rem66.ru','ecf23ace379cc34ab856f3f3dae1c2bd:X6tfm8x3CxidCyHj','',0,0,18,'2011-12-13 06:49:36','0000-00-00 00:00:00','',''),(76,'Вызов сантехника Екатеринбург','Электрик в Екатеринбурге','ekaterinburg@pvh66.ru','8f9e20ef7db27daca73df932b95dddf3:IQHX3BkjsIyd5p6t','',0,0,18,'2011-12-14 06:31:19','0000-00-00 00:00:00','',''),(77,'Продвижение сайта самостоятельно бесплатно','Продвижение сайтов самому','2013@ssve.ru','988b1b1ec4eb6fa57738235d8a1c284d:8MIQezP6i2WSe8ji','',0,0,18,'2012-12-07 14:04:32','0000-00-00 00:00:00','',''),(78,'Nuuxazhot','Nuuxazhot','falameev.vasilij@mail.ru','11dbbea59a54974862af5511b022f43b:qtllnQJtadobmidX','',1,0,18,'2016-12-28 18:14:48','0000-00-00 00:00:00','19384f032aa5890840ba3f2e49962b8b',''),(79,'RichNouh','RichNouh','new@emailvam.xyz','cab1fc0c8a1271627de6d4ea983ce69c:I6yVzQQ2dNtdFrpu','',1,0,18,'2017-03-06 01:47:30','0000-00-00 00:00:00','aa71b9c4dd902a245f7cc43ecddee263',''),(80,'Chasearnes','Chasearnes','mulo@try-rx.com','11946db90d7c6fb29b7bd524ac97e3b6:SgXAUox4AwDn3oU3','',0,0,18,'2017-05-09 09:04:01','2017-05-09 09:07:19','',''),(81,'Worldbpaw','Worldbpaw','ejjecyqa08@mail.ru','a9c9a7c30c2135ddb46e25c860b85a55:IB6sILBpJ5IjtrhN','',0,0,18,'2017-06-27 14:41:12','2017-06-27 14:43:35','',''),(82,'JustEnfows','JustEnfows','justDug@3drugs.com','f1a218ca5b551e6630fc95bd9684dfe9:p9YMBhBDnqkBWec7','',1,0,18,'2017-11-16 16:42:57','0000-00-00 00:00:00','b41d33dbdabf2154aa08091e8f5d8ae0',''),(83,'Yolabapse','Yolabapse','yolHigowl@cheapvia50mg.com','e747efd91bf51e739058f047286efc87:0jJALWDPE2Tz5qao','',0,0,18,'2018-01-29 01:50:42','2018-02-06 00:59:45','',''),(84,'Anthony','ywurahapu','1012chdch@xne6.com.pl','8d80d119d5bb34a9047f7356c812640a:TvyV9cHzEYNbhmf4','',0,0,18,'2018-03-12 08:34:29','2018-03-12 08:35:45','',''),(85,'Ellexpins','Ellexpins','ellpels@lmail.science','2396170d0cc81972fa2a05eddff883b5:93Tzc10IOZ7QK8Rg','',1,0,18,'2018-04-24 18:49:17','0000-00-00 00:00:00','ef091722d10edf8d647d6ce987bd9465','');
/*!40000 ALTER TABLE `bel_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bel_usertypes`
--

DROP TABLE IF EXISTS `bel_usertypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bel_usertypes` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `mask` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bel_usertypes`
--

LOCK TABLES `bel_usertypes` WRITE;
/*!40000 ALTER TABLE `bel_usertypes` DISABLE KEYS */;
INSERT INTO `bel_usertypes` VALUES (0,'superadministrator',''),(1,'administrator',''),(2,'editor',''),(3,'user',''),(4,'author',''),(5,'publisher',''),(6,'manager','');
/*!40000 ALTER TABLE `bel_usertypes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-13 10:44:37
