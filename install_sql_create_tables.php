<?php

if(!defined('_MYSQL_ENGINE_')){
	define(_MYSQL_ENGINE_,'MyISAM');
}

Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."cloud_gallery_image_lang` (
			  `id_cloud_gallery_image` int(255) unsigned NOT NULL AUTO_INCREMENT,
			  `id_lang` int(11) NOT NULL,
			  `image` VARCHAR(100),
			  `image_w` VARCHAR(10),
				`image_h` VARCHAR(10),
			  `description` text NOT NULL,
			  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date when this that was created.',
			  PRIMARY KEY (`id_cloud_gallery_image`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");

// TODO: This php close tag shouldn't be here right?
?>