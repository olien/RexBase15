## Redaxo Database Dump Version 4
## Prefix rex_
## charset utf-8

DROP TABLE IF EXISTS `rex_420_xoutputfilter`;
CREATE TABLE `rex_420_xoutputfilter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `typ` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `lang` int(11) NOT NULL DEFAULT '0',
  `marker` text NOT NULL,
  `html` text NOT NULL,
  `allcats` tinyint(1) NOT NULL DEFAULT '0',
  `subcats` tinyint(1) NOT NULL DEFAULT '0',
  `once` tinyint(1) NOT NULL DEFAULT '0',
  `categories` text NOT NULL,
  `insertbefore` tinyint(1) NOT NULL DEFAULT '0',
  `excludeids` text NOT NULL,
  `useragent` text NOT NULL,
  `dataarea` text NOT NULL,
  `validfrom` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `validto` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_420_xoutputfilter` WRITE;
/*!40000 ALTER TABLE `rex_420_xoutputfilter` DISABLE KEYS */;
INSERT INTO `rex_420_xoutputfilter` VALUES 
  (1,5,1,'Beispiel_001','Beispiel für HTML-Insert im Header (mit PHP-Code)',0,'<head>',' \r\n\r\n<!--\r\n	Beispiel für einen Insert im Header-Bereich des Backends ;-)\r\n<?php\r\n	global $REX;\r\n	echo date(\'	d.m.Y H:i:s\') . \"\\n\";\r\n	echo \'	REDAXO Version: \' . $REX[\'VERSION\'] . \'.\' . $REX[\'SUBVERSION\'] . \'.\' . $REX[\'MINORVERSION\'] . \"\\n\";\r\n?>\r\n-->\r\n\r\n',1,0,1,'',0,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (2,5,1,'Beispiel_002','Anzeige der REDAXO-Version im Backend',0,'<li class=\"rex-navi-first\">','<?php\r\n  global $REX;\r\n  echo \'<em>Version: \'\r\n    . $REX[\'VERSION\'] . \'.\' . $REX[\'SUBVERSION\'] . \'.\' . $REX[\'MINORVERSION\']\r\n    . \'</em>&nbsp;&nbsp;</li><li>\';\r\n?>',1,0,1,'',0,'mediapool','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (3,5,1,'Beispiel_003','Link zum Frontend einfügen',0,'<li><a href=\"index.php?page=profile\">Mein Profil</a></li>','<li>\r\n<a href=\"../index.php\" onclick=\"window.open(this.href); return false;\">zur Webseite</a>\r\n</li>',1,0,1,'',1,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (4,5,1,'Beispiel_004','Beispiel \"abmelden\" durch \"Logout\" ersetzen',0,'<a href=\"index.php?rex_logout=1\" title=\"abmelden\">abmelden</a>\r\n|\r\n<a href=\"index.php?rex_logout=1\" accesskey=\"l\" title=\"abmelden [l]\">abmelden</a>','<a href=\"index.php?rex_logout=1\" accesskey=\"l\" title=\"Logout [l]\">Logout</a>',1,0,1,'',2,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (5,5,1,'Beispiel_005','Beispiel Linkmap und Medienpool ohne REDAXO-Logo (4.3.x)',0,'</head>\r\n<body class=\"rex-popuplinkmap\r\n|\r\n</head>\r\n<body class=\"rex-popupmediapool','  \r\n<style type=\"text/css\">\r\n#rex-website { margin-top:-65px; }\r\n#rex-wrapper { margin-top:-50px; } \r\n</style>\r\n ',0,0,1,'linkmap, mediapool',1,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (6,5,1,'Beispiel_006','Beispiel Linkmap und Medienpool ohne REDAXO-Logo (4.2.x)',0,'</head>\r\n<body id=\"rex-page-mediapool\r\n|\r\n</head>\r\n<body id=\"rex-page-linkmap','  \r\n<style type=\"text/css\">\r\n#rex-website { margin-top:-65px; }\r\n#rex-wrapper { margin-top:-20px; } \r\n</style>\r\n ',0,0,1,'linkmap, mediapool',1,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (7,5,0,'Beispiel_007','Alle HTML-Kommentare entfernen - ausser Conditional Comments für IE',0,'/<!--[^\\[](.|\\s)*?[^\\]]-->/','',1,0,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (8,5,1,'Beispiel_008','PHP-Code bei vorhandenem Marker ausführen',0,'</body>','<?php\r\n/**\r\n * Minibeispiel PHP-Code bei vorhandenem Marker ausführen\r\n */\r\nglobal $REX;\r\n\r\n$replace = \'\r\n</body>\r\n<!-- Beispiel Backend-Ersetzung mit PHP \'.\r\ndate(\'d.m.Y H:i:s\')\r\n.\' -->\r\n\';\r\n\r\n$REX[\'xoutputfilter\'][\'content\'] = str_replace(\'</body>\', $replace, $REX[\'xoutputfilter\'][\'content\']);\r\n?>',1,0,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (9,4,1,'Beispiel_001','Umpersand durch benanntes Zeichen ersetzen (& -> &amp;)',0,'/&(?!(?i:\\#((x([\\dA-F]){1,5})\r\n|(104857[0-5]\r\n|10485[0-6]\\d\r\n|1048[0-4]\\d\\d\r\n|104[0-7]\\d{3}\r\n|10[0-3]\\d{4}\r\n|0?\\d{1,6}))\r\n|([A-Za-z\\d.]{2,31}));)/x','&amp;',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (10,4,0,'Beispiel_002','HTML-Kommentare entfernen',0,'/<!--(.|\\s)*?-->/\r\n','',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (11,4,0,'Beispiel_003','Alle HTML-Kommentare entfernen - ausser Conditional Comments für IE',0,'/<!--[^\\[](.|\\s)*?[^\\]]-->/','',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (12,4,0,'Beispiel_004','JavaScript entfernen',0,'/<script(.|\\s)*?<\\/script>/','',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (13,4,1,'Beispiel_005','Ungeschlossene Tags schliessen (<br>, <hr>, <img>, <input>, <meta>, <base>, <basefont>, <param>, <link>, <area>)',0,'/\r\n<(br|hr|img|input|meta|base|basefont|param|link|area)\r\n+\r\n((\\s+[a-zA-Z-]+\\s*=\\s*(\"([^\"]*)\"|\'([^\']*)\'|([a-zA-Z0-9]*)))*\\s*)>\r\n/ix','<$1$2 />',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (14,4,1,'Beispiel_006','Leere HTML-Tags entfernen (<p>, <span>, <strong>, <b>, <em>, <h1>, <h2>, <h3>, <h4>, <h5>, <h6>)',0,'/<(p|span|strong|b|em|h1|h2|h3|h4|h5|h6)>(\\s|\\b)*<\\/\\1>/','',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (15,4,1,'Beispiel_007','Fehlende alt-Attribute bei <img>-Tags einfügen',0,'/(?!<img[^>]*\\salt[^=>]*=[^>]*>)<img[^>](.*)(>)/','<img alt=\"\" $1>',1,1,0,'',3,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (16,4,1,'Beispiel_008','Zeichen und Tags ersetzen / entfernen',0,'<head>','<?php\r\n/**\r\n * Zeichen und Tags ersetzen / entfernen\r\n */\r\nglobal $REX;\r\n\r\n  $xoutputfilter_codereplace = array(\r\n  \'<b>\' => \'<strong>\' ,\r\n  \'</b>\' => \'</strong>\' ,\r\n  \'<i>\' => \'<em>\' ,\r\n  \'</i>\' => \'</em>\' ,\r\n  \'ä\' => \'&auml;\' ,\r\n  \'ö\' => \'&ouml;\' ,\r\n  \'ü\' => \'&uuml;\' ,\r\n  \'Ä\' => \'&Auml;\' ,\r\n  \'Ö\' => \'&Ouml;\' ,\r\n  \'Ü\' => \'&Uuml;\' ,\r\n  \'ß\' => \'&szlig;\',\r\n  \'(c)\' => \'&copy;\',\r\n  \' ismap=\"ismap\"\' => \'\',\r\n  \' ismap=\"true\"\' => \'\',\r\n  \' target=\"_self\"\' => \'\',\r\n  \' target=\"_blank\"\' => \' onclick=\"window.open(this.href); return false;\"\',\r\n  \'<div align=\"center\">\' => \'<div style=\"text-align:center;\">\',\r\n  \'<hr width=\"100%\" size=\"2\" />\' => \'<hr />\'\r\n  );\r\n\r\n  $search = array();\r\n  $replace = array();\r\n  foreach ($xoutputfilter_codereplace as $key => $value)\r\n  {\r\n    $search[] = $key;\r\n    $replace[] = $value;\r\n  }\r\n  $REX[\'xoutputfilter\'][\'content\'] = str_replace($search, $replace, $REX[\'xoutputfilter\'][\'content\']);\r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (17,4,1,'Beispiel_009','HTML-Attribute in Anführungszeichen, HTML-Tags in Kleinbuchstaben',0,'<head>','<?php\r\n/**\r\n * HTML-Attribute in Anführungszeichen, HTML-Tags in Kleinbuchstaben\r\n */\r\nglobal $REX;\r\n\r\n  // HTML-Tags in Kleinbuchstaben\r\n  $REX[\'xoutputfilter\'][\'content\'] = preg_replace(\"#<(/?)([A-Z]+)([^>]+)?(/?)>#ies\", \'\"<$1\".strtolower(\"$2\").\"$3$4>\"\', $REX[\'xoutputfilter\'][\'content\']);\r\n\r\n  // HTML-Attribute in Anführungszeichen\r\n  $mtchs = array();\r\n  $attrs = array();\r\n\r\n  preg_match_all(\'/(<(link|a|body|div|span|p|br|hr|img|table|tr|td|ul|li|dl|dt)[^<>]+>)/is\', $REX[\'xoutputfilter\'][\'content\'], $mtchs);\r\n\r\n  foreach ($mtchs[0] as $mtch)\r\n  {\r\n    preg_match_all(\'/([\\w]+)=(.*?)(?:\\s|>)/is\', $mtch, $attrs);\r\n    $c = count ($attrs[0]);\r\n    if ($c <> 0)\r\n    {\r\n      for ($i = 0; $i < $c; $i++)\r\n      {\r\n        if (($attrs[2][$i]{0} != \'\"\') )//and ($attrs[2][$i]{0} != \'\\\'\')\r\n        {\r\n          $srch[] = $attrs[1][$i].\'=\'.$attrs[2][$i];\r\n          $rplc[] = strtolower($attrs[1][$i]).\'=\"\'.str_replace(\'\\\\\\\'\',\'\',$attrs[2][$i]).\'\"\';\r\n        }\r\n      }\r\n    }\r\n  }\r\n\r\n  if (isset($srch) and is_array($srch))\r\n  {\r\n    $REX[\'xoutputfilter\'][\'content\'] = str_replace($srch, $rplc, $REX[\'xoutputfilter\'][\'content\']);\r\n  }\r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (18,4,1,'Beispiel_010','E-Mail-Adressen mit Klasse email versehen und verschlüsseln',0,'mailto:','<?php\r\n/**\r\n * E-Mail Adressen verschlüsseln\r\n */\r\nglobal $REX;\r\n\r\n  // hier via regEx alle absoluten, externen Linkadressen heraussuchen\r\n  preg_match_all(\"/<a[^>]*(href\\s*=\\s*(\\\"|\')(mailto)(?=:).*?(\\\"|\'))[^>]*>(.*?)<\\/a>/ims\", $REX[\'xoutputfilter\'][\'content\'], $matches);\r\n\r\n  // hier jetzt alle gefundenen durchgehen und um klasse erweitern\r\n  if ( isset ($matches[0][0]) and $matches[0][0] != \'\')\r\n  {\r\n    for ($m = 0; $m < count ($matches[0]); $m++)\r\n    {\r\n      $msearch = $matches[0][$m];\r\n      if (strstr($matches[0][$m], \'class=\'))\r\n      {\r\n        $mreplace = $matches[0][$m];\r\n      }\r\n      else\r\n      {\r\n        $mreplace = str_replace(\'href=\', \'class=\"email\" href=\', $matches[0][$m]);\r\n      }\r\n      $REX[\'xoutputfilter\'][\'content\'] = str_replace($msearch, $mreplace, $REX[\'xoutputfilter\'][\'content\']);\r\n    }\r\n  }\r\n\r\n  // hier jetzt alle gefundenen durchgehen und crypt\r\n  if ( isset ($matches[1][0]) and $matches[1][0] != \'\')\r\n  {\r\n    for ($m = 0; $m < count ($matches[1]); $m++)\r\n    {\r\n      $va = explode(\'mailto:\', $matches[1][$m]);\r\n      $originalemail = str_replace(\'\"\', \'\', $va[1]);\r\n\r\n      $encryptedemail = \'\';\r\n      for ($i=0; $i < strlen($originalemail); $i++) {\r\n        $encryptedemail .= \'&#\'.ord(substr($originalemail, $i, 1)).\';\';\r\n      }\r\n\r\n      $msearch = \'mailto:\'.$originalemail;\r\n      $mreplace = \'mailto:\'.str_replace(\'&#64;\', \'%40\', $encryptedemail);\r\n      $REX[\'xoutputfilter\'][\'content\'] = str_replace($msearch, $mreplace, $REX[\'xoutputfilter\'][\'content\']);\r\n\r\n      $msearch = $originalemail;\r\n      $mreplace = $encryptedemail;\r\n      $REX[\'xoutputfilter\'][\'content\'] = str_replace($msearch, $mreplace, $REX[\'xoutputfilter\'][\'content\']);\r\n    }\r\n  }\r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (19,4,0,'Beispiel_011','Unverlinkte Domains verlinken',0,'<head>','<?php\r\n/**\r\n * Unverlinkte Domains verlinken\r\n */\r\nglobal $REX;\r\n\r\n  $regex = array();\r\n  $regex[] = \"{ \\\\b(?<![\\\">])((https?|ftp):[\\\\w/\\\\#~:.?+=&%@!\\\\-]+?)(?=[.:?\\\\-]*(?:[^\\\\w/\\\\#~:.?+=&%@!\\\\-]|$)) }x\";\r\n  $regex[] = \"{ (?<![\\\">])(>|\\\\s)+\\\\b((www)[\\\\w/\\\\#~:.?+=&%@!\\\\-]+?)(?=[.:?\\\\-]*(?:[^\\\\w/\\\\#~:.?+=&%@!\\\\-]|$)) }x\";\r\n\r\n  $replace = array();\r\n  $replace[] = \"<a href=\\\"$1\\\">$1</a>\";\r\n  $replace[] = \"$1<a href=\\\"http://$2\\\">$2</a>\";\r\n\r\n  $REX[\'xoutputfilter\'][\'content\'] = preg_replace($regex, $replace, $REX[\'xoutputfilter\'][\'content\']);\r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (20,4,0,'Beispiel_012','Externe Links mit Klasse extern versehen',0,'href=\"http:','<?php\r\n/**\r\n * Kennzeichnung externe Links mit Ausnahme\r\n */\r\nglobal $REX;\r\n\r\n  //$content = $REX[\'xoutputfilter\'][\'content\'];\r\n\r\n  // Von der Ersetzung ausgeschlossen:\r\n  $excl = array();\r\n  $excl[] = \'href=\"\' . $REX[\'SERVER\'];\r\n  $excl[] = \'href=\"http://\' . $_SERVER[\'HTTP_HOST\'];\r\n  $excl[] = \'href=\"https://\' . $_SERVER[\'HTTP_HOST\'];\r\n  $excl[] = \'#top\';\r\n  $excl[] = \'#nav\';\r\n  $excl[] = \'#mainnav\';\r\n  $excl[] = \'#hauptnavigation\';\r\n  $excl[] = \'#content\';\r\n  $excl[] = \'href=\"http://www.facebook.com/\';\r\n  $excl[] = \'href=\"http://twitter.com/\';\r\n\r\n  // hier via regEx alle absoluten, externen Linkadressen heraussuchen\r\n  preg_match_all(\"/<a[^>]*(href\\s*=\\s*(\\\"|\')(http(s)?|ftp(s)?|telnet|irc)(?=:\\/\\/).*?(\\\"|\'))[^>]*>(.*?)<\\/a>/ims\", $REX[\'xoutputfilter\'][\'content\'], $matches);\r\n\r\n  if ( isset ($matches[0][0]) and $matches[0][0] != \'\')\r\n  {\r\n    $srch = $repl = array();\r\n    for ($m = 0; $m < count ($matches[0]); $m++)\r\n    {\r\n      $msearch = $matches[0][$m];\r\n      if (strstr($matches[0][$m], \'class=\'))\r\n      {\r\n        $mreplace = $matches[0][$m];\r\n      }\r\n      else\r\n      {\r\n        $mreplace = str_replace(\'href=\', \'class=\"extern\" href=\', $matches[0][$m]);\r\n      }\r\n      for ($x = 0; $x < count($excl); $x++)\r\n      {\r\n        if (strstr($matches[1][$m], $excl[$x]))\r\n        {\r\n          $mreplace = $matches[0][$m];\r\n        }\r\n      }\r\n      $srch[] = $msearch;\r\n      $repl[] = $mreplace;\r\n    }\r\n    $REX[\'xoutputfilter\'][\'content\'] = str_replace($srch, $repl, $REX[\'xoutputfilter\'][\'content\']);\r\n  }  \r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (21,4,0,'Beispiel_013','Wartungsarbeiten - Nicht angemeldete Benutzer auf eine Wartungsseite umleiten',0,'<head>','<?php\r\n/**\r\n* Wartungsarbeiten\r\n*/\r\n  global $REX;\r\n\r\n  // Hier die URL angeben auf die weitergeleitet werden soll!\r\n  $offline_url = $REX[\'SERVER\'] . \'wartungsarbeiten.html\';\r\n\r\n  // evtl. Weiterleitung\r\n  @session_start();\r\n  $islogon = false;\r\n  \r\n  if (isset($_SESSION[$REX[\'INSTNAME\']]) and isset($_SESSION[$REX[\'INSTNAME\']][\'UID\']) and $_SESSION[$REX[\'INSTNAME\']][\'UID\']<>\'\')\r\n  {\r\n    $islogon = true;\r\n  }\r\n\r\n  if (!$islogon) \r\n  {\r\n    if ( !strstr($_SERVER[\"REQUEST_URI\"], \'&maintenance\') )\r\n    {\r\n      $trash = ob_get_contents();\r\n      ob_end_clean();\r\n      if (strstr($offline_url, \'?\'))\r\n      {\r\n        header(\'Location: \' . $offline_url . \'&maintenance\');\r\n      }\r\n      else\r\n      {\r\n        header(\'Location: \' . $offline_url);\r\n      }\r\n      \r\n    }\r\n  }\r\n?>',1,1,1,'',4,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (22,5,1,'01 Test Trenner','Test Trenner',0,'<li id=\"rex-navi-page-xform_manager_test','<li style=\"background: #6e6e6e; padding: 5px 0 5px 10px ;color: #e3eaea;\">TestÜberschrift</li>',1,0,1,'',1,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
  (23,5,0,'10 - Rex Toolba (seperator fix)','Seperator Fix',0,'\">separator: ','\" style=\"color: #315588 !important; font-weight: bold; font-size: 10px;\" > ---',1,0,0,'',2,'','','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `rex_420_xoutputfilter` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_62_params`;
CREATE TABLE `rex_62_params` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `prior` int(10) unsigned NOT NULL,
  `attributes` text NOT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `default` varchar(255) NOT NULL,
  `params` text,
  `validate` text,
  `restrictions` text NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `updatedate` int(11) NOT NULL,
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_62_params` WRITE;
/*!40000 ALTER TABLE `rex_62_params` DISABLE KEYS */;
INSERT INTO `rex_62_params` VALUES 
  (1,'translate:pool_file_description','med_description',1,'',2,'','','','','%USER%',1417172789,'%USER%',1417172789),
  (2,'translate:pool_file_copyright','med_copyright',2,'',1,'','','','','%USER%',1417172789,'%USER%',1417172789),
  (10,'Menüpunkt anzeigen in:','cat_navigationstyp',1,'multiple=multiple',3,'main','main:Hauptnavigation|header:Header|footer:Footer|hidden:verstecken','','','olien',1417447349,'olien',1417447349),
  (11,'\"zurück\" Link anzeigen','art_backlink',2,'',5,'','1:ja','','','olien',1417447387,'olien',1417447387),
  (24,'Font Awesome Icon','art_fonticon',1,'',1,'','','','','olien',1417703790,'olien',1417703790);
/*!40000 ALTER TABLE `rex_62_params` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_62_type`;
CREATE TABLE `rex_62_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `dbtype` varchar(255) NOT NULL,
  `dblength` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_62_type` WRITE;
/*!40000 ALTER TABLE `rex_62_type` DISABLE KEYS */;
INSERT INTO `rex_62_type` VALUES 
  (1,'text','text',0),
  (2,'textarea','text',0),
  (3,'select','varchar',255),
  (4,'radio','varchar',255),
  (5,'checkbox','varchar',255),
  (10,'date','text',0),
  (13,'time','text',0),
  (11,'datetime','text',0),
  (12,'legend','text',0),
  (6,'REX_MEDIA_BUTTON','varchar',255),
  (7,'REX_MEDIALIST_BUTTON','text',0),
  (8,'REX_LINK_BUTTON','varchar',255),
  (9,'REX_LINKLIST_BUTTON','text',0);
/*!40000 ALTER TABLE `rex_62_type` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_679_type_effects`;
CREATE TABLE `rex_679_type_effects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `effect` varchar(255) NOT NULL,
  `parameters` text NOT NULL,
  `prior` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_679_type_effects` WRITE;
/*!40000 ALTER TABLE `rex_679_type_effects` DISABLE KEYS */;
INSERT INTO `rex_679_type_effects` VALUES 
  (1,1,'resize','a:6:{s:15:\"rex_effect_crop\";a:5:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:24:\"rex_effect_crop_position\";s:13:\"middle_center\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:5:\"right\";s:28:\"rex_effect_insert_image_vpos\";s:6:\"bottom\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"200\";s:24:\"rex_effect_resize_height\";s:3:\"200\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:11:\"not_enlarge\";}}',1,1417172789,'%USER%',1417172789,'%USER%'),
  (2,2,'resize','a:6:{s:15:\"rex_effect_crop\";a:5:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:24:\"rex_effect_crop_position\";s:13:\"middle_center\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:5:\"right\";s:28:\"rex_effect_insert_image_vpos\";s:6:\"bottom\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"600\";s:24:\"rex_effect_resize_height\";s:3:\"600\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:11:\"not_enlarge\";}}',1,1417172789,'%USER%',1417172789,'%USER%'),
  (3,3,'resize','a:6:{s:15:\"rex_effect_crop\";a:5:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:24:\"rex_effect_crop_position\";s:13:\"middle_center\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:5:\"right\";s:28:\"rex_effect_insert_image_vpos\";s:6:\"bottom\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:2:\"80\";s:24:\"rex_effect_resize_height\";s:2:\"80\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:11:\"not_enlarge\";}}',1,1417172789,'%USER%',1417172789,'%USER%'),
  (4,4,'resize','a:6:{s:15:\"rex_effect_crop\";a:5:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:24:\"rex_effect_crop_position\";s:13:\"middle_center\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:5:\"right\";s:28:\"rex_effect_insert_image_vpos\";s:6:\"bottom\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"246\";s:24:\"rex_effect_resize_height\";s:3:\"246\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:11:\"not_enlarge\";}}',1,1417172789,'%USER%',1417172789,'%USER%'),
  (5,5,'resize','a:6:{s:15:\"rex_effect_crop\";a:5:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:24:\"rex_effect_crop_position\";s:13:\"middle_center\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:5:\"right\";s:28:\"rex_effect_insert_image_vpos\";s:6:\"bottom\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"246\";s:24:\"rex_effect_resize_height\";s:3:\"246\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:11:\"not_enlarge\";}}',1,1417172789,'%USER%',1417172789,'%USER%'),
  (8,7,'focuspoint_resize','a:10:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:30:\"rex_effect_filter_blur_repeats\";s:2:\"10\";s:27:\"rex_effect_filter_blur_type\";s:8:\"gaussian\";s:31:\"rex_effect_filter_blur_smoothit\";s:0:\"\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:28:\"rex_effect_focuspoint_resize\";a:4:{s:34:\"rex_effect_focuspoint_resize_width\";s:3:\"480\";s:35:\"rex_effect_focuspoint_resize_height\";s:3:\"200\";s:34:\"rex_effect_focuspoint_resize_style\";s:7:\"maximum\";s:42:\"rex_effect_focuspoint_resize_allow_enlarge\";s:7:\"enlarge\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:0:\"\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:26:\"rex_effect_rounded_corners\";a:4:{s:34:\"rex_effect_rounded_corners_topleft\";s:0:\"\";s:35:\"rex_effect_rounded_corners_topright\";s:0:\"\";s:37:\"rex_effect_rounded_corners_bottomleft\";s:0:\"\";s:38:\"rex_effect_rounded_corners_bottomright\";s:0:\"\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1417696484,'olien',1417688279,'olien'),
  (7,6,'focuspoint_resize','a:10:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:30:\"rex_effect_filter_blur_repeats\";s:2:\"10\";s:27:\"rex_effect_filter_blur_type\";s:8:\"gaussian\";s:31:\"rex_effect_filter_blur_smoothit\";s:0:\"\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:28:\"rex_effect_focuspoint_resize\";a:4:{s:34:\"rex_effect_focuspoint_resize_width\";s:3:\"300\";s:35:\"rex_effect_focuspoint_resize_height\";s:3:\"200\";s:34:\"rex_effect_focuspoint_resize_style\";s:7:\"maximum\";s:42:\"rex_effect_focuspoint_resize_allow_enlarge\";s:7:\"enlarge\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:0:\"\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:26:\"rex_effect_rounded_corners\";a:4:{s:34:\"rex_effect_rounded_corners_topleft\";s:0:\"\";s:35:\"rex_effect_rounded_corners_topright\";s:0:\"\";s:37:\"rex_effect_rounded_corners_bottomleft\";s:0:\"\";s:38:\"rex_effect_rounded_corners_bottomright\";s:0:\"\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1417603151,'olien',1417603118,'olien'),
  (9,8,'focuspoint_resize','a:10:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:30:\"rex_effect_filter_blur_repeats\";s:2:\"10\";s:27:\"rex_effect_filter_blur_type\";s:8:\"gaussian\";s:31:\"rex_effect_filter_blur_smoothit\";s:0:\"\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:28:\"rex_effect_focuspoint_resize\";a:4:{s:34:\"rex_effect_focuspoint_resize_width\";s:3:\"600\";s:35:\"rex_effect_focuspoint_resize_height\";s:3:\"300\";s:34:\"rex_effect_focuspoint_resize_style\";s:7:\"maximum\";s:42:\"rex_effect_focuspoint_resize_allow_enlarge\";s:7:\"enlarge\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:0:\"\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:26:\"rex_effect_rounded_corners\";a:4:{s:34:\"rex_effect_rounded_corners_topleft\";s:0:\"\";s:35:\"rex_effect_rounded_corners_topright\";s:0:\"\";s:37:\"rex_effect_rounded_corners_bottomleft\";s:0:\"\";s:38:\"rex_effect_rounded_corners_bottomright\";s:0:\"\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',2,1417692363,'olien',1417688294,'olien'),
  (10,9,'focuspoint_resize','a:10:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:30:\"rex_effect_filter_blur_repeats\";s:2:\"10\";s:27:\"rex_effect_filter_blur_type\";s:8:\"gaussian\";s:31:\"rex_effect_filter_blur_smoothit\";s:0:\"\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:28:\"rex_effect_focuspoint_resize\";a:4:{s:34:\"rex_effect_focuspoint_resize_width\";s:4:\"1070\";s:35:\"rex_effect_focuspoint_resize_height\";s:0:\"\";s:34:\"rex_effect_focuspoint_resize_style\";s:7:\"maximum\";s:42:\"rex_effect_focuspoint_resize_allow_enlarge\";s:11:\"not_enlarge\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:0:\"\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:26:\"rex_effect_rounded_corners\";a:4:{s:34:\"rex_effect_rounded_corners_topleft\";s:0:\"\";s:35:\"rex_effect_rounded_corners_topright\";s:0:\"\";s:37:\"rex_effect_rounded_corners_bottomleft\";s:0:\"\";s:38:\"rex_effect_rounded_corners_bottomright\";s:0:\"\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1417697244,'olien',1417688310,'olien'),
  (13,8,'filter_sepia','a:10:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:30:\"rex_effect_filter_blur_repeats\";s:2:\"10\";s:27:\"rex_effect_filter_blur_type\";s:8:\"gaussian\";s:31:\"rex_effect_filter_blur_smoothit\";s:0:\"\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:28:\"rex_effect_focuspoint_resize\";a:4:{s:34:\"rex_effect_focuspoint_resize_width\";s:0:\"\";s:35:\"rex_effect_focuspoint_resize_height\";s:0:\"\";s:34:\"rex_effect_focuspoint_resize_style\";s:7:\"maximum\";s:42:\"rex_effect_focuspoint_resize_allow_enlarge\";s:7:\"enlarge\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:0:\"\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:26:\"rex_effect_rounded_corners\";a:4:{s:34:\"rex_effect_rounded_corners_topleft\";s:0:\"\";s:35:\"rex_effect_rounded_corners_topright\";s:0:\"\";s:37:\"rex_effect_rounded_corners_bottomleft\";s:0:\"\";s:38:\"rex_effect_rounded_corners_bottomright\";s:0:\"\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1417694294,'olien',1417694294,'olien');
/*!40000 ALTER TABLE `rex_679_type_effects` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_679_types`;
CREATE TABLE `rex_679_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_679_types` WRITE;
/*!40000 ALTER TABLE `rex_679_types` DISABLE KEYS */;
INSERT INTO `rex_679_types` VALUES 
  (1,1,'rex_mediapool_detail','Zur Darstellung von Bildern in der Detailansicht im Medienpool'),
  (2,1,'rex_mediapool_maximized','Zur Darstellung von Bildern im Medienpool wenn maximiert'),
  (3,1,'rex_mediapool_preview','Zur Darstellung der Vorschaubilder im Medienpool'),
  (4,1,'rex_mediabutton_preview','Zur Darstellung der Vorschaubilder in REX_MEDIA_BUTTON[]s'),
  (5,1,'rex_medialistbutton_preview','Zur Darstellung der Vorschaubilder in REX_MEDIALIST_BUTTON[]s');
/*!40000 ALTER TABLE `rex_679_types` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_action`;
CREATE TABLE `rex_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `preview` text,
  `presave` text,
  `postsave` text,
  `previewmode` tinyint(4) DEFAULT NULL,
  `presavemode` tinyint(4) DEFAULT NULL,
  `postsavemode` tinyint(4) DEFAULT NULL,
  `createuser` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_article`;
CREATE TABLE `rex_article` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `catprior` int(11) NOT NULL,
  `attributes` text NOT NULL,
  `startpage` tinyint(1) NOT NULL,
  `prior` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `clang` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `revision` int(11) NOT NULL,
  `yrewrite_url` varchar(255) NOT NULL,
  `yrewrite_priority` varchar(5) NOT NULL,
  `yrewrite_changefreq` varchar(10) NOT NULL,
  `yrewrite_title` varchar(255) NOT NULL,
  `yrewrite_description` text NOT NULL,
  `yrewrite_noindex` tinyint(1) NOT NULL,
  `seo_title` text,
  `seo_description` text,
  `seo_keywords` text,
  `seo_custom_url` text,
  `seo_canonical_url` text,
  `seo_noindex` varchar(1) DEFAULT NULL,
  `seo_ignore_prefix` varchar(1) DEFAULT NULL,
  `cat_navigationstyp` varchar(255) DEFAULT 'main',
  `art_backlink` varchar(255) DEFAULT '',
  `art_fonticon` text,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `find_articles` (`id`,`clang`),
  KEY `id` (`id`),
  KEY `clang` (`clang`),
  KEY `re_id` (`re_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_article` WRITE;
/*!40000 ALTER TABLE `rex_article` DISABLE KEYS */;
INSERT INTO `rex_article` VALUES 
  (1,1,0,'404','',0,'',0,1,'|',1,1417433330,1417433333,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','main','',''),
  (2,2,0,'Startseite','Startseite',2,'',1,1,'|',1,1417433347,1417703825,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|header|','||','fa-home'),
  (3,3,0,'Ausgaben / Beispiele','',0,'',0,2,'|',1,1417445961,1417688660,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','main','',''),
  (4,4,0,'separator: Navigation: Header','separator: Navigation: Header',1,'',1,1,'|',0,1417447983,1417448008,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|main|','',''),
  (5,5,0,'separator: Navigation: Haupt','separator: Navigation: Haupt',5,'',1,1,'|',0,1417447992,1417447992,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|main|','',''),
  (6,6,0,'separator: Footer Informationen','separator: Footer Informationen',8,'',1,1,'|',0,1417448001,1417448001,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|main|','',''),
  (7,7,0,'Kontakt','Kontakt',3,'',1,1,'|',1,1417448022,1417703845,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|header|','||','fa-envelope-o'),
  (8,8,0,'Impressum','Impressum',4,'',1,1,'|',1,1417448023,1417703888,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|header|','||','fa-exclamation'),
  (9,9,0,'Main 1','Main 1',6,'',1,1,'|',1,1417448046,1417448080,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|main|','',''),
  (10,10,0,'Footer 1','Footer 1',9,'',1,1,'|',1,1417448054,1417448057,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|footer|','',''),
  (11,11,0,'Footer 2','Footer 2',10,'',1,1,'|',1,1417448063,1417448067,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|footer|','',''),
  (12,12,0,'Main 2','Main 2',7,'',1,1,'|',0,1417448248,1417448088,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','|main|','',''),
  (13,13,0,'Ausgabe Beispiele / Formular','',0,'',0,4,'|',1,1417521580,1417597669,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','main','',''),
  (14,14,0,'Ausgabe Beispiele Details','',0,'',0,3,'|',1,1417529294,1417529325,1,0,'olien','olien',0,'','','','','',0,'','','','','','','','main','','');
/*!40000 ALTER TABLE `rex_article` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_article_slice`;
CREATE TABLE `rex_article_slice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clang` int(11) NOT NULL,
  `ctype` int(11) NOT NULL,
  `re_article_slice_id` int(11) NOT NULL,
  `value1` text,
  `value2` text,
  `value3` text,
  `value4` text,
  `value5` text,
  `value6` text,
  `value7` text,
  `value8` text,
  `value9` text,
  `value10` text,
  `value11` text,
  `value12` text,
  `value13` text,
  `value14` text,
  `value15` text,
  `value16` text,
  `value17` text,
  `value18` text,
  `value19` text,
  `value20` text,
  `file1` varchar(255) DEFAULT NULL,
  `file2` varchar(255) DEFAULT NULL,
  `file3` varchar(255) DEFAULT NULL,
  `file4` varchar(255) DEFAULT NULL,
  `file5` varchar(255) DEFAULT NULL,
  `file6` varchar(255) DEFAULT NULL,
  `file7` varchar(255) DEFAULT NULL,
  `file8` varchar(255) DEFAULT NULL,
  `file9` varchar(255) DEFAULT NULL,
  `file10` varchar(255) DEFAULT NULL,
  `filelist1` text,
  `filelist2` text,
  `filelist3` text,
  `filelist4` text,
  `filelist5` text,
  `filelist6` text,
  `filelist7` text,
  `filelist8` text,
  `filelist9` text,
  `filelist10` text,
  `link1` varchar(10) DEFAULT NULL,
  `link2` varchar(10) DEFAULT NULL,
  `link3` varchar(10) DEFAULT NULL,
  `link4` varchar(10) DEFAULT NULL,
  `link5` varchar(10) DEFAULT NULL,
  `link6` varchar(10) DEFAULT NULL,
  `link7` varchar(10) DEFAULT NULL,
  `link8` varchar(10) DEFAULT NULL,
  `link9` varchar(10) DEFAULT NULL,
  `link10` varchar(10) DEFAULT NULL,
  `linklist1` text,
  `linklist2` text,
  `linklist3` text,
  `linklist4` text,
  `linklist5` text,
  `linklist6` text,
  `linklist7` text,
  `linklist8` text,
  `linklist9` text,
  `linklist10` text,
  `php` text,
  `html` text,
  `article_id` int(11) NOT NULL,
  `modultyp_id` int(11) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `next_article_slice_id` int(11) DEFAULT NULL,
  `revision` int(11) NOT NULL,
  `status` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`re_article_slice_id`,`article_id`,`modultyp_id`),
  KEY `id` (`id`),
  KEY `clang` (`clang`),
  KEY `re_article_slice_id` (`re_article_slice_id`),
  KEY `article_id` (`article_id`),
  KEY `find_slices` (`clang`,`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_article_slice` WRITE;
/*!40000 ALTER TABLE `rex_article_slice` DISABLE KEYS */;
INSERT INTO `rex_article_slice` VALUES 
  (21,0,1,0,'zttrzztr','h1','','','','','l','noresize','','','','','nurbildlink','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',7,1,1417681907,1417681907,'olien','olien',0,0,1),
  (10,0,1,11,'Überschrift H1','h1','h2. Überschrift H1\r\n\r\nh3. Überschrift H2\r\n\r\nh4. Überschrift H3\r\n\r\nh5. Überschrift H4\r\n\r\nh6. Überschrift H5\r\n\r\n*Sortierte Liste*\r\n\r\n# Erster Punkt\r\n# Zweiter Punkt\r\n## Erster Unterpunkt\r\n## Zweiter Unterpunkt\r\n# Dritter Punkt\r\n# Vierter Punkt\r\n# Fünfter Punkt \r\n\r\n*Unsortierter Liste*\r\n* Erster Punkt\r\n* Zweiter Punkt\r\n** Erster Unterpunkt\r\n** Zweiter Unterpunkt\r\n* Dritter Punkt\r\n* Vierter Punkt\r\n* Fünfter Punkt \r\n\r\n\r\n\r\n*fett* _kursiv_ -durchgestrichen- +unterstrichen+ \"interner Link\":redaxo://3 \"externer Link\":http://concedra.de \"E-Mail Adresse\":mailto:mail@mail.de hochgestellt[^2^] und tiefgestellt[~2~] Acronym: CMS(Content Management System)\r\n\r\nbq. Dies ist ein Zitat\r\n\r\n\r\n|Name |concedra GmbH|\r\n|Anschrift|Dirschauer Strasse 10<br/>44789 Bochum|\r\n|Telefon|0234 51637 0|\r\n\r\n|_. Id|_. Name|\r\n|1|Peter|\r\n\r\n|<. Ausrichtung links|\r\n|=. zentriert|\r\n|>. rechts| \r\n\r\nEtiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis. Donec sed odio dui.\r\n\r\nNullam quis risus eget urna mollis ornare vel eu leo. Donec id elit non mi porta gravida at eget metus. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla vitae elit libero, a pharetra augue. Cras mattis consectetur purus sit amet fermentum.','','','','l','noresize','','','','','nurbildlink','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',3,1,1417519780,1417521046,'olien','olien',0,0,1),
  (11,0,1,22,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',3,5,1417521625,1417521625,'olien','olien',0,0,1),
  (14,0,1,0,'Detailansicht','h1','','','','','l','noresize','','','','','nurbildlink','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',14,1,1417529325,1417529325,'olien','olien',0,0,1),
  (15,0,1,0,'1','kreischer@concedra.de','url_var|vars|Hallo||\r\nhidden|tid||REQUEST\r\n','testmail','###vars###','Danke\r\n\r\n###vars###','0','','','','2','kreischer@concedra.de','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',13,6,1417596574,1417597669,'olien','olien',0,0,1),
  (22,0,1,0,'','','','','','','','','','','','','','','','','','','','','stadt.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',3,8,1417688465,1417688660,'olien','olien',0,0,1);
/*!40000 ALTER TABLE `rex_article_slice` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_clang`;
CREATE TABLE `rex_clang` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `rex_clang` WRITE;
/*!40000 ALTER TABLE `rex_clang` DISABLE KEYS */;
INSERT INTO `rex_clang` VALUES 
  (0,'deutsch',0);
/*!40000 ALTER TABLE `rex_clang` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_file`;
CREATE TABLE `rex_file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `re_file_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `attributes` text,
  `filetype` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `originalname` varchar(255) DEFAULT NULL,
  `filesize` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `revision` int(11) NOT NULL,
  `med_description` text,
  `med_copyright` text,
  PRIMARY KEY (`file_id`),
  KEY `re_file_id` (`re_file_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_file` WRITE;
/*!40000 ALTER TABLE `rex_file` DISABLE KEYS */;
INSERT INTO `rex_file` VALUES 
  (1,0,1,'','application/pdf','lorem2.pdf','lorem2.pdf','69058',0,0,'',1417601574,1417601574,'olien','olien',0,'',''),
  (2,0,1,'','application/pdf','lorem4.pdf','lorem4.pdf','426709',0,0,'',1417601574,1417601574,'olien','olien',0,'',''),
  (3,0,1,'','application/pdf','lorem3.pdf','lorem3.pdf','79612',0,0,'',1417601574,1417601574,'olien','olien',0,'',''),
  (4,0,1,'','application/pdf','lorem5.pdf','lorem5.pdf','72273',0,0,'',1417601574,1417601574,'olien','olien',0,'',''),
  (5,0,1,'','application/pdf','lorem.pdf','lorem.pdf','77123',0,0,'',1417601574,1417601574,'olien','olien',0,'',''),
  (7,0,1,'','image/jpeg','katze.jpg','katze.jpg','24249',378,393,'af',1417601654,1417610847,'olien','olien',0,'',''),
  (8,0,1,'','image/jpeg','brot.jpg','brot.jpg','129006',1450,667,'',1417601654,1417602242,'olien','olien',0,'',''),
  (9,0,1,'','image/jpeg','stadt.jpg','stadt.jpg','93038',1073,650,'',1417601654,1417697224,'olien','olien',0,'',''),
  (12,0,1,'','image/jpeg','stadt_header_desktop.jpg','stadt.jpg','320695',1070,450,'Header Desktop',1417700878,1417700878,'olien','olien',0,'',''),
  (14,0,1,'','image/jpeg','stadt_header_mobile.jpg','stadt.jpg','89176',480,250,'Header Mobile',1417700942,1417700942,'olien','olien',0,'',''),
  (17,0,1,'','image/jpeg','stadt_header_tablet.jpg','stadt.jpg','193820',960,400,'',1417703498,1417703498,'olien','olien',0,'','');
/*!40000 ALTER TABLE `rex_file` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_file_category`;
CREATE TABLE `rex_file_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `re_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `attributes` text,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `re_id` (`re_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_file_category` WRITE;
/*!40000 ALTER TABLE `rex_file_category` DISABLE KEYS */;
INSERT INTO `rex_file_category` VALUES 
  (1,'5000 - Testdateien',0,'|',1417601548,1417601555,'olien','olien','',0);
/*!40000 ALTER TABLE `rex_file_category` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_module`;
CREATE TABLE `rex_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `ausgabe` text NOT NULL,
  `eingabe` text NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `attributes` text,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_module` WRITE;
/*!40000 ALTER TABLE `rex_module` DISABLE KEYS */;
INSERT INTO `rex_module` VALUES 
  (1,'0010 - Text / Bild ',0,'<?php\r\n\r\nglobal $colcounter;\r\n\r\n\r\n//  function olien($thing) {echo \'<pre>\'; var_dump($thing); echo \'</pre>\';}\r\n\r\n  $link             = \"\";\r\n  $linkbild         = \"\";\r\n  $linkueberschrift = \"\";\r\n  $linkanfang       = \"\";\r\n  $linkende         = \"\";\r\n  $bild             = \'\';\r\n  $bildunterschrift = \'\';\r\n  $abstandzumtext   = \'\';\r\n  $weiterlesenlink  = \'\';\r\n  $bildcode         = \'\';\r\n  $text             = \'\';\r\n  $content          = \'\';\r\n\r\n\r\n\r\n# Variablen für Online-Prüfung\r\n  $online = \'REX_VALUE[20]\';\r\n  $time = time();\r\n  $start = strtotime(\'REX_VALUE[19]\');\r\n  $end = strtotime(\'REX_VALUE[18]\');\r\n\r\n$msgonline = \'\r\n<div class=\"rex-message\"><div class=\"rex-info\" style=\"font-size: 15px; font-weight: normal;\"><p><span>Für diesen Inhalt ist ein in Veröffentlichungszeitraum angegeben (REX_VALUE[19] - REX_VALUE[18])<br/><b>Dieser Inhalt wird auf der Webseite angezeigt.</b><span></p></div></div>\';\r\n\r\n$msgoffline = \'\r\n<div class=\"rex-message\"><div class=\"rex-warning\" style=\"font-size: 15px; font-weight: normal;\"><p><span>Für diesen Inhalt ist ein in Veröffentlichungszeitraum angegeben (REX_VALUE[19] - REX_VALUE[18])<br/><b>Dieser Inhalt wird momentan NICHT auf der Webseite angezeigt.</b><span></p></div></div>\';\r\n\r\n\r\nif (!isset($REX[\'base\'][\'textmodulcount\'])){\r\n  $REX[\'base\'][\'textmodulcount\'] = 0;\r\n}\r\n$REX[\'base\'][\'textmodulcount\'] = $REX[\'base\'][\'textmodulcount\'] + 1;\r\n\r\n\r\nif(!$REX[\'REDAXO\']) {\r\n\r\n//\r\n//  Frontend\r\n//\r\n  if(OOAddon::isAvailable(\'textile\'))\r\n  {\r\n\r\n  if(REX_IS_VALUE[3]) { // Text\r\n    $text = \'\';\r\n    $text = htmlspecialchars_decode(\'REX_VALUE[3]\',ENT_QUOTES);\r\n    $text = str_replace(\'<br />\',\'\',$text);\r\n    $text = rex_a79_textile($text);\r\n  }\r\n\r\n// echo \"REX_FILE[1]\";\r\n\r\n    if (\"REX_FILE[1]\" != \"\") { // Bild\r\n\r\n      $bild         = OOMedia::getMediaByName(\'REX_FILE[1]\');\r\n      $bildTitle      = $bild->getTitle();\r\n      $bildBeschreibung   = $bild->getValue(\'med_description\');\r\n      $bildCopyright    = $bild->getValue(\'med_copyright\');\r\n      $bildDateiName    = $bild->getFileName();\r\n      $bildBreite     = $bild->getWidth();\r\n      $bildHoehe      = $bild->getHeight();\r\n\r\n    $image = rex_image_manager::getImageCache(\'REX_FILE[1]\', \"contentimage_REX_VALUE[8]\");\r\n\r\n      //  printf(\'%s[%s] = %d x %d Pixel\',\r\n        // $bildDateiName,\r\n        // \"contentimage_REX_VALUE[8]\",\r\n        // $image->getWidth(),\r\n      // $image->getHeight()\r\n      // );\r\n\r\n      if ($bildCopyright != \'\') {\r\n        $bildCopyright = \" | (c) \".$bildCopyright;\r\n      }\r\n\r\n  $bildunterschrift = \'\';\r\n  if(REX_IS_VALUE[6])   {\r\n      $bildunterschrift = htmlspecialchars_decode(\'REX_VALUE[6]\',ENT_QUOTES);\r\n      $bildunterschrift = str_replace(\'<br />\',\'\',$bildunterschrift);\r\n      $bildunterschrift = rex_a79_textile($bildunterschrift);\r\n      $bildunterschrift = \'<div class=\"bildunterschrift\">\'.$bildunterschrift.\'</div>\'.PHP_EOL;\r\n  }\r\n\r\n    if(REX_IS_VALUE[9])   {\r\n      $rahmen = \'class=\"rahmen\"\';\r\n    } else {\r\n      $rahmen = \'\';\r\n    }\r\n\r\n  $bildcode = \'<img \'.$rahmen.\' src=\"index.php?rex_img_type=contentimage_REX_VALUE[8]&amp;rex_img_file=\'.$bildDateiName.\'\" title=\"REX_VALUE[5]\'.$bildCopyright.\'\" alt=\"REX_VALUE[5]\'.$bildCopyright.\'\" width=\"100%\" />\'.PHP_EOL;\r\n  }\r\n\r\n   if(REX_IS_VALUE[11] OR \"REX_LINK_ID[1]\" != 0) {\r\n\r\n    $link = \"1\";\r\n      $externerlink = \"REX_VALUE[11]\";\r\n        if($externerlink != str_replace(\"http://\", \"\",$externerlink)) {\r\n        $linkanfang = \'<a href=\"REX_VALUE[11]\">\'.PHP_EOL;\r\n      } else {\r\n        $linkanfang = \'<a href=\"http://REX_VALUE[11]\">\'.PHP_EOL;\r\n      }\r\n\r\n    if (\"REX_LINK_ID[1]\" != 0) {\r\n        $linkanfang  = \'<a href=\"\'.rex_geturl(\"REX_LINK_ID[1]\", $REX[\'CUR_CLANG\']).\'\">\'.PHP_EOL;\r\n      }\r\n\r\n    $linkende =\'</a>\'.PHP_EOL;\r\n\r\n\r\n    if (\"REX_VALUE[13]\" == \"nurbildlink\") { $linkbild = \"1\"; }\r\n    if (\"REX_VALUE[13]\" == \"ueberschriftlink\") { $linkueberschrift = \"1\"; }\r\n    if (\"REX_VALUE[13]\" == \"ueberschriftundbildlink\") { $linkbild = \"1\"; $linkueberschrift = \"1\";}\r\n\r\n    $weiterlesenlink = \'\';\r\n    if (REX_IS_VALUE[10]) {\r\n      $weiterlesenlink = \'<div class=\"weiterlesen\">\'.$linkanfang.\'REX_VALUE[10]\'.$linkende.\'</div>\'.PHP_EOL;\r\n    } else {\r\n      $weiterlesenlink = \'\';\r\n    }\r\n\r\n    }\r\n\r\n  // Überschrift\r\n  if (\'REX_VALUE[1]\' != \'\') {\r\n\r\n    if ($linkueberschrift) {\r\n      $contentueberschrift = \'<REX_VALUE[2]>\'.$linkanfang.\'REX_VALUE[1]\'.$linkende.\'</REX_VALUE[2]>\'.PHP_EOL;\r\n    } else {\r\n      $contentueberschrift =  \'<REX_VALUE[2]>REX_VALUE[1]</REX_VALUE[2]>\'.PHP_EOL;\r\n    }\r\n  } else {\r\n    $contentueberschrift = \'\';\r\n  }\r\n\r\n  // Bild\r\n  if ($linkbild) {\r\n    $contentbild = $linkanfang.$bildcode.$linkende.$bildunterschrift.$abstandzumtext;\r\n  } else {\r\n    $contentbild = $bildcode.$bildunterschrift.$abstandzumtext;\r\n  }\r\n\r\n  if (REX_IS_VALUE[12]) {\r\n    $contentbild = \'<a class=\"boxer\" href=\"index.php?rex_img_type=contentimage_noresize&amp;rex_img_file=\'.$bildDateiName.\'\" title=\"\'.$bildBeschreibung.\'\">\'.$bildcode.$bildunterschrift.\'</a>\';\r\n  }\r\n\r\n  // Text\r\n  $contenttext = $text;\r\n  $contentweiterlesen = $weiterlesenlink;\r\n\r\n  if (\"REX_VALUE[13]\" == \"nurbildlink\") { $contentweiterlesen = \'\'; }\r\n\r\n  //HTML\r\n\r\n\r\n  $content .= \'<div class=\"textbildlink\">\'.PHP_EOL;\r\n\r\n  // Ausrichtung\r\n\r\n  $floatimg = \'\';\r\n  $block = \'\';\r\n\r\n  // Ausrichtungen \"im Fliesstext links\"\r\n  if (\"REX_VALUE[7]\" == \'l\' OR \"REX_VALUE[7]\" == \'tl\' OR \"REX_VALUE[7]\" == \'tlu\') {\r\n    $floatimg = \"flLeft\";\r\n  }\r\n\r\n  // Ausrichtungen \"im Fliesstext rechts\"\r\n  if (\"REX_VALUE[7]\" == \'r\' OR \"REX_VALUE[7]\" == \'tr\' OR \"REX_VALUE[7]\" == \'tru\') {\r\n    $floatimg = \"flRight\";\r\n  }\r\n\r\n  if (\"REX_VALUE[7]\" == \'tl\' OR \"REX_VALUE[7]\" == \'tr\' OR \"REX_VALUE[7]\" == \'tlu\' OR \"REX_VALUE[7]\" == \'tru\' ) {\r\n    $block = \'block\';\r\n  } else {\r\n    $block = \'\';\r\n  }\r\n\r\n  if (\"REX_VALUE[7]\" == \'tlu\' OR \"REX_VALUE[7]\" == \'tru\') {\r\n    $content .= \'<div class=\"bildcontainer \'.$floatimg.\' REX_VALUE[8]\">\'.PHP_EOL;\r\n    $content .= $contentbild.\'</div>\'.PHP_EOL;\r\n    if ($contenttext !=\'\') {\r\n      $content .= \'<div class=\"text \'.$block.\'\">\'.PHP_EOL;\r\n      $content .= $contentueberschrift.$contenttext.$contentweiterlesen.\'</div>\'.PHP_EOL;\r\n    }\r\n  } else if ($contentbild !=\'\') {\r\n    $content .= $contentueberschrift;\r\n    $content .= \'<div class=\"bildcontainer \'.$floatimg.\' REX_VALUE[8]\">\'.PHP_EOL;\r\n    $content .= $contentbild.\'</div>\'.PHP_EOL;\r\n    if ($contenttext !=\'\') {\r\n      $content .= \'<div class=\"text \'.$block.\'\">\'.PHP_EOL;\r\n      $content .= $contenttext.$contentweiterlesen.\'</div>\'.PHP_EOL;\r\n    }\r\n  } else {\r\n    $content .= $contentueberschrift;\r\n    if ($contenttext !=\'\') {\r\n        $content .= \'<div class=\"text \'.$block.\'\">\'.PHP_EOL;\r\n        $content .= $contenttext.$contentweiterlesen.\'</div>\'.PHP_EOL;\r\n    }\r\n  }\r\n\r\n  $content .=  \'</div>\'.PHP_EOL;\r\n\r\n// Zeiteinstellung\r\nif ($online == \"1\") {\r\n\r\n  if( $time > $start && $time < $end )\r\n    {\r\n      echo PHP_EOL.\'<!-- SLICE ID REX_SLICE_ID ANFANG -->\'.PHP_EOL;\r\n      echo $content;\r\n        echo \'<!-- // -->\'.PHP_EOL;\r\n    }\r\n  }\r\n# Prüfung aus\r\n  if ($online == \"\") {\r\n  echo PHP_EOL.\'<!-- SLICE ID REX_SLICE_ID ANFANG -->\'.PHP_EOL;\r\n  echo $content;\r\n    echo \'<!-- // -->\'.PHP_EOL;\r\n  }\r\n\r\n\r\n  } else {\r\n    echo rex_warning(\'Dieses Modul benötigt das \"textile\" Addon!\');\r\n  }\r\n} else {\r\n\r\n//\r\n//  Backend\r\n//\r\n\r\n// Eingaben prüfen\r\n\r\n$warnings = [];\r\n\r\nif (\"REX_FILE[1]\" != \"\" AND \"REX_VALUE[5]\" == \"\" ) {\r\n    $warnings[] = \'Bitte geben Sie einen Alternativtext für das Bild an.\';\r\n}\r\n\r\nif (\"REX_FILE[1]\" == \"\" AND \"REX_VALUE[5]\" != \"\" OR \"REX_FILE[1]\" == \"\" AND \"REX_VALUE[6]\" != \"\" ) {\r\n    $warnings[] = \'Sie haben Angaben zu einem Bild gemacht ohne ein Bild auszuwählen. Bitte wählen Sie ein Bild aus.\';\r\n}\r\n\r\nif (\"REX_VALUE[10]\" != \"\" AND (\"REX_LINK_ID[1]\" == \"\" AND \"REX_VALUE[11]\" == \"\" )) {\r\n    $warnings[] = \'Bitte geben Sie einen Link an.\';\r\n}\r\n\r\nif (\"REX_VALUE[11]\" != \"\" AND \"REX_LINK_ID[1]\" != \"\") {\r\n    $warnings[] = \'Bitte geben Sie entweder einen externen oder einen internen Link an.\';\r\n}\r\n\r\nif ((\"REX_VALUE[11]\" != \"\" OR \"REX_LINK_ID[1]\" != \"\") AND ((\"REX_VALUE[1]\" == \"\" AND \"REX_VALUE[13]\" == \"ueberschriftlink\") OR (\"REX_VALUE[1]\" == \"\" AND \"REX_VALUE[13]\" == \"ueberschriftundbildlink\"))) {\r\n    $warnings[] = \'Die Überschrift kann nicht verlinkt werden. Bitte geben Sie eine Überschrift ein.\';\r\n}\r\n\r\nif ((\"REX_VALUE[11]\" != \"\" OR \"REX_LINK_ID[1]\" != \"\") AND ((\"REX_FILE[1]\" == \"\" AND \"REX_VALUE[13]\" == \"nurbildlink\") OR (\"REX_FILE[1]\" == \"\" AND \"REX_VALUE[13]\" == \"ueberschriftundbildlink\"))) {\r\n    $warnings[] = \'Das Bild kann nicht verlinkt werden. Bitte wählen Sie ein Bild aus.\';\r\n}\r\n\r\nif ((\"REX_VALUE[12]\" != \"\" ) AND (\"REX_VALUE[11]\" != \"\" OR \"REX_LINK_ID[1]\" != \"\")) {\r\n    $warnings[] = \'Sie können ein zoombares Bild nicht verlinken.\';\r\n}\r\n\r\n\r\n\r\n\r\n\r\nif ($REX[\'REDAXO\'] && count($warnings) > 0) {\r\n    foreach ($warnings as $warning) {\r\n        echo rex_warning($warning);\r\n    }\r\n}\r\n\r\n// Zeiteinstellung\r\nif ($online == \"1\") {\r\n  if( $time > $start && $time < $end ) {\r\n    echo $msgonline;\r\n  } else {\r\n    echo $msgoffline;\r\n  }\r\n}\r\n\r\n  echo \'<table style=\"width: 100%;\">\'.PHP_EOL;\r\n\r\n  if (REX_IS_VALUE[1]) // Überschrift\r\n  {\r\n\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Überschrift</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">REX_VALUE[1]</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Grösse</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">REX_VALUE[2]</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n  }\r\n\r\n\r\n  if(REX_IS_VALUE[3])\r\n  {\r\n    $text = \'\';\r\n    $text = htmlspecialchars_decode(\'REX_VALUE[3]\',ENT_QUOTES);\r\n    $text = str_replace(\'<br />\',\'\',$text);\r\n    $text = rex_a79_textile($text);\r\n\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Text</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">\'.$text.\'</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n  }\r\n\r\n\r\n    //  Wenn Bild eingefuegt wurde, Code schreiben\r\n    if (\"REX_FILE[1]\" != \"\") {\r\n\r\n  echo \'<tr>\'.PHP_EOL;\r\n  echo \'<th colspan=\"2\"><br/><hr/><br/></th>\'.PHP_EOL;\r\n  echo \'</tr>\'.PHP_EOL;\r\n\r\n  $ausrichtung = \"\";\r\n    if (\"REX_VALUE[7]\" == \"l\")    $ausrichtung = \"im Text links\";\r\n    if (\"REX_VALUE[7]\" == \"r\")    $ausrichtung = \"im Text rechts\";\r\n    if (\"REX_VALUE[7]\" == \"tl\")   $ausrichtung = \"links vom Text\";\r\n    if (\"REX_VALUE[7]\" == \"tr\")   $ausrichtung = \"rechts vom Text\";\r\n  if (\"REX_VALUE[7]\" == \"tlu\")  $ausrichtung = \"links von Text und Überschrift\";\r\n    if (\"REX_VALUE[7]\" == \"tru\")  $ausrichtung = \"rechts von Text und Überschrift\";\r\n\r\n    $bild         = OOMedia::getMediaByName(\'REX_FILE[1]\');\r\n    $bildTitle      = $bild->getTitle();\r\n    $bildBeschreibung   = $bild->getValue(\'med_description\');\r\n    $bildCopyright    = $bild->getValue(\'med_copyright\');\r\n    $bildDateiName    = $bild->getFileName();\r\n    $bildBreite     = $bild->getWidth();\r\n    $bildHoehe      = $bild->getHeight();\r\n\r\n    if ($bildCopyright != \'\') {\r\n      $bildCopyright = \" | (c) \".$bildCopyright;\r\n    }\r\n\r\n  echo \'<tr>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Bild</td>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px;\">REX_FILE[1]<br/><br/>\r\n      <img src=\"index.php?rex_img_type=rex_medialistbutton_preview&rex_img_file=\'.$bildDateiName.\'\" title=\"REX_VALUE[5]\'.$bildCopyright.\'\" alt=\"REX_VALUE[5]\'.$bildCopyright.\'\" />\r\n      </td>\'.PHP_EOL;\r\n  echo \'</tr>\'.PHP_EOL;\r\n\r\n  echo \'<tr>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Alternativtext</td>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px;\">REX_VALUE[5]\'.$bildCopyright.\'</td>\'.PHP_EOL;\r\n  echo \'</tr>\'.PHP_EOL;\r\n\r\n  $bildunterschrift = \'\';\r\n    if(REX_IS_VALUE[6])\r\n      {\r\n      $bildunterschrift = htmlspecialchars_decode(\'REX_VALUE[6]\',ENT_QUOTES);\r\n      $bildunterschrift = str_replace(\'<br />\',\'\',$bildunterschrift);\r\n      $bildunterschrift = rex_a79_textile($bildunterschrift);\r\n\r\n      echo \'<tr>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Bildunterschrift</td>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px;\">\'.$bildunterschrift.\'</td>\'.PHP_EOL;\r\n      echo \'</tr>\'.PHP_EOL;\r\n       }\r\n\r\n  $bildgroesse = \"\";\r\n    if (\"REX_VALUE[8]\" == \"noresize\")   $bildgroesse = \"keine Anpassung\";\r\n    if (\"REX_VALUE[8]\" == \"full\")     $bildgroesse = \"ganze Breite\";\r\n    if (\"REX_VALUE[8]\" == \"half\")     $bildgroesse = \"halbe Breite\";\r\n    if (\"REX_VALUE[8]\" == \"quarter\")  $bildgroesse = \"viertel Breite\";\r\n\r\n  echo \'<tr>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Grösse</td>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px;\">\'.$bildgroesse.\'</td>\'.PHP_EOL;\r\n  echo \'</tr>\'.PHP_EOL;\r\n\r\n  echo \'<tr>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Ausrichtung</td>\'.PHP_EOL;\r\n  echo \'<td style=\"padding: 5px;\">\'.$ausrichtung.\'</td>\'.PHP_EOL;\r\n  echo \'</tr>\'.PHP_EOL;\r\n\r\n  $bildrahmen = \"\";\r\n     if(REX_IS_VALUE[9]) {\r\n      $bildrahmen = \"ja\";\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Rahmen</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">\'.$bildrahmen.\'</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n     }\r\n\r\n\r\n  $zoombar = \"\";\r\n     if(REX_IS_VALUE[12]) {\r\n      $zoombar = \"ja\";\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Bild Zoom</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">\'.$zoombar.\'</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n     }\r\n\r\n\r\n\r\n     if(REX_IS_VALUE[14]) {\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Bild Abstand zum Text</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">REX_VALUE[14]px</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n     }\r\n\r\n  }\r\n\r\n    // Link\r\n    if (REX_IS_VALUE[10] OR REX_IS_VALUE[11] OR \"REX_LINK_ID[1]\" != 0 ) {\r\n\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<th colspan=\"2\"><br/><hr/><br/></th>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n\r\n      if(REX_IS_VALUE[11]) {\r\n\r\n        $externerlink = \"REX_VALUE[11]\";\r\n        if($externerlink != str_replace(\"http://\", \"\",$externerlink)) {\r\n        $externerlink = \"REX_VALUE[11]\";\r\n      } else {\r\n        $externerlink = \"http://REX_VALUE[11]\";\r\n      }\r\n\r\n      echo \'<tr>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">externe URL</td>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px;\">\'.$externerlink.\'</td>\'.PHP_EOL;\r\n      echo \'</tr>\'.PHP_EOL;\r\n    }\r\n\r\n      if (\"REX_LINK_ID[1]\" != 0) {\r\n\r\n      echo \'<tr>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">interner Link</td>\'.PHP_EOL;\r\n\r\n      $article=OOArticle::getArticleById(REX_LINK_ID[1]);\r\n      $name=$article->getName();\r\n\r\n      echo \'<td style=\"padding: 5px;\"><a href=\"index.php?page=content&article_id=REX_LINK_ID[1]&mode=edit\">\'.$name.\'</a></td>\'.PHP_EOL;\r\n      echo \'</tr>\'.PHP_EOL;\r\n    }\r\n\r\n    $verlinkungsart = \"\";\r\n      if (\"REX_VALUE[13]\" == \"nurbildlink\")         $verlinkungsart = \"nur das Bild ist verlinkt\";\r\n      if (\"REX_VALUE[13]\" == \"ueberschriftlink\")      $verlinkungsart = \"nur die Überschrift ist verlinkt\";\r\n      if (\"REX_VALUE[13]\" == \"ueberschriftundbildlink\")   $verlinkungsart = \"Überschrift und Bild sind verlinkt\";\r\n\r\n    echo \'<tr>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Verlinkungsart</td>\'.PHP_EOL;\r\n    echo \'<td style=\"padding: 5px;\">\'.$verlinkungsart.\'</td>\'.PHP_EOL;\r\n    echo \'</tr>\'.PHP_EOL;\r\n\r\n      if(REX_IS_VALUE[10]) {\r\n      echo \'<tr>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Linkbezeichnung</td>\'.PHP_EOL;\r\n      echo \'<td style=\"padding: 5px;\">REX_VALUE[10]</td>\'.PHP_EOL;\r\n      echo \'</tr>\'.PHP_EOL;\r\n    }\r\n    }\r\n\r\n  echo \'</table>\'.PHP_EOL;\r\n\r\n\r\n\r\n}\r\n\r\n\r\n\r\n?>\r\n','<div id=\"tabs\">\r\n	<ul>\r\n		<li><a href=\"#text\">Überschrift &amp; Text</a></li>\r\n		<li><a href=\"#bild\">Bild</a></li>\r\n		<li><a href=\"#link\">Link</a></li>\r\n		<li style=\"float:right;\"><a href=\"#weiteres\">Weitere Einstellungen</a></li>\r\n	</ul>\r\n\r\n\r\n<?php\r\n\r\n// Rex Values\r\n//  1  : Überschrift\r\n//  2  : Überschrift-Tag\r\n\r\n//  3  : Inhaltstext\r\n// 	1  : Bild Datei -> REX_FILE[1]\r\n// 	5  : Alt Attribu\r\n// 	6  : Bildunterschrift\r\n// 	7  : Bild Ausrichtung\r\n// 	8  : Bild Größe\r\n// 	9  : Bild Rahmen\r\n\r\n\r\n// 10  : Link Bezeichnung\r\n// 11  : externe URL\r\n\r\n// 12  : Bild im Popup öffnen\r\n\r\n//  1  : interne URL -> REX_LINK_ID[1]\r\n// 13  : Verlinkungsart\r\n\r\n// 18,19,20 -> Online Einstellungen\r\n\r\nif (!isset($REX[\'base\'][\'textmodulcount\'])){\r\n	$REX[\'base\'][\'textmodulcount\'] = 0;\r\n}\r\n\r\n$REX[\'base\'][\'textmodulcount\'] = $REX[\'base\'][\'textmodulcount\'] + 1;\r\n\r\n\r\n$objForm = new mform();\r\n\r\n// TEXT\r\n\r\n$objForm->addHtml(\'<div id=\"text\">\');\r\n\r\n$objForm->addHeadline(\'Überschrift\');\r\n\r\n$objForm->addTextAreaField(1,array(\'label\'=>\'Text\',\'style\'=>\'width:500px\'));\r\n\r\n// Tag für Überschrift\r\n$tag = \'REX_VALUE[2]\';\r\nif ($tag == \'\' and $REX[\'base\'][\'textmodulcount\'] == 1) $tag = \'h1\';\r\nif ($tag == \'\') $tag = \'h2\';\r\n\r\n$objForm->addSelectField(2,array(\'h1\'=>\'H1\',\'h2\'=>\'H2\',\'h3\'=>\'H3\',\'h4\'=>\'H4\',\'h5\'=>\'H5\',\'h6\'=>\'H6\'),array(\'label\'=>\'Grösse\'),\'\',$tag);\r\n\r\n$objForm->addHeadline(\'Text\');\r\n$objForm->addTextAreaField(3,array(\'label\'=>\'Text eingeben\',\'class\'=>\"rex-markitup\",\'data-buttonset\'=>\"kreischer\",\'style\'=>\'width:505px !important;\'));\r\n$objForm->addHtml(\'</div>\');\r\n\r\n// BILD\r\n\r\n$objForm->addHtml(\'<div id=\"bild\">\');\r\n$objForm->addHeadline(\'Bild\');\r\n$objForm->addMediaField(1,array(\'types\'=>\'gif,jpg,png\',\'preview\'=>0,\'category\'=>0,\'label\'=>\'Datei\'));\r\n$objForm->addTextField(5,array(\'label\'=>\'Alternativtext\',\'style\'=>\'width:500px\'));\r\n\r\n$objForm->addHtml(\'<br/>\');\r\n$objForm->addHeadline(\'Weitere Eigenschaften\');\r\n$objForm->addTextAreaField(6,array(\'label\'=>\'Bildunterschrift\',\'style\'=>\'width:500px\'));\r\n\r\n\r\n$objForm->addSelectField(7, array(\r\n	\'l\'=>\'im Fliesstext links\',\r\n	\'r\'=>\'im Fliestext rechts\',\r\n//	\'tl\'=>\'links vom Text\',\r\n//	\'tr\'=>\'rechts vom Text\',\r\n//	\'tlu\'=>\'links von Text und Überschrift\',\r\n//	\'tru\'=>\'rechts von Text und Überschrift\'\r\n), array(\'label\'=>\'Ausrichtung\'));\r\n\r\n$objForm->addSelectField(8,array(\r\n	\'noresize\'=>\'keine Anpassung\',\r\n	\'full\'=>\'ganze Breite\',\r\n	\'half\'=>\'halbe Breite\',\r\n	\'quarter\'=>\'viertel Breite\'\r\n	),array(\'label\'=>\'Größe\'));\r\n\r\n$objForm->addCheckboxField(9,array(1=>\'\'),array(\'label\'=>\'Bildrahmen\'));\r\n$objForm->addCheckboxField(12,array(1=>\'\'),array(\'label\'=>\'Bild zoombar\'));\r\n$objForm->addHtml(\'</div>\');\r\n\r\n// LINK\r\n\r\n$objForm->addHtml(\'<div id=\"link\">\');\r\n$objForm->addHeadline(\'Link\');\r\n$objForm->addTextField(11,array(\'label\'=>\'extern\',\'style\'=>\'width:500px\'));\r\n$objForm->addLinkField(1,array(\'label\'=>\'intern\',\'category\'=>0));\r\n\r\n$objForm->addHtml(\'<br/>\');\r\n$objForm->addHeadline(\'Weitere Eigenschaften\');\r\n\r\n$objForm->addTextField(10,array(\'label\'=>\'Bezeichnung\',\'style\'=>\'width:500px\'));\r\n\r\n$objForm->addSelectField(13, array(\r\n	\'nurbildlink\'=>\'nur das Bild verlinken\',\r\n	\'ueberschriftlink\'=>\'nur Überschrift verlinken\',\r\n	\'ueberschriftundbildlink\'=>\'Überschrift und Bild verlinken\'\r\n), array(\'label\'=>\'Elemente\'));\r\n\r\n\r\n$objForm->addHtml(\'</div>\');\r\n\r\n// Weitere Einstellungen\r\n\r\n$objForm->addHtml(\'<div id=\"weiteres\">\');\r\n$objForm->addHeadline(\'Online Zeitraum einstellen\');\r\n$objForm->addCheckboxField(20,array(1=>\'\'),array(\'label\'=>\'Aktiv\'));\r\n$objForm->addTextField(19,array(\'label\'=>\'Online von\',\'style\'=>\'width:100px\',\'class\'=>\'datepicker1\'));\r\n$objForm->addTextField(18,array(\'label\'=>\'Online bis\',\'style\'=>\'width:100px\',\'class\'=>\'datepicker2\'));\r\n\r\n\r\n$objForm->addHtml(\'</div>\');\r\n\r\n\r\necho $objForm->show_mform();\r\n\r\n?>\r\n\r\n<script type=\"text/javascript\">\r\njQuery(\'#tabs\').tabs({\r\n	fx: { height: \'toggle\', duration: 200 },\r\n	select: function(event, ui) {\r\n		jQuery(this).css(\'height\', jQuery(this).height());\r\n	},\r\n//	show: function(event, ui) {\r\n//		jQuery(this).css(\'height\', \'550px\');\r\n//		jQuery(this).css(\'overflow\', \'visible\');\r\n//	}\r\n});\r\n\r\n\r\n	jQuery(document).ready(function($) {\r\n\r\n// Hilfe Boxen\r\n// $(\'.dialog\').dialog({ autoOpen: false, width: 700});\r\n// $(\'#info_ueberschrift\').click(function(){  $(\'#dialog_ueberschrift\').dialog(\'open\');return false;});\r\n// $(\'#info_text\').click(function(){  $(\'#dialog_text\').dialog(\'open\');return false;});\r\n\r\n			$(\'#tabs\').tabs();\r\n\r\n			$(\".datepicker1\").datepicker({\r\n							inline: true,\r\n							dateFormat: \"dd.mm.yy\"\r\n\r\n			});\r\n\r\n			$(\".datepicker2\").datepicker({\r\n							inline: true,\r\n				 			defaultDate: \"+1w\",\r\n							dateFormat: \"dd.mm.yy\"\r\n			});\r\n\r\n	});\r\n</script>\r\n\r\n\r\n\r\n','olien','olien',1417445942,1417605694,'',0),
  (2,'Abstand',0,'<?php\r\n\r\n	if (\'REX_VALUE[1]\' == \'\') {\r\n		$abstand = 50;\r\n	} else {\r\n		$abstand = \'REX_VALUE[1]\';\r\n	}\r\n\r\n\r\nif (!$REX[\'REDAXO\']) {\r\n\r\n\r\n	echo \'<div class=\"abstand\" style=\"height: \'.$abstand.\'px\"></div>\';\r\n\r\n\r\n\r\n} else {\r\n\r\n\r\n	echo \'<table style=\"width: 100%;\">\'.PHP_EOL;\r\n		echo \'<tr>\'.PHP_EOL;\r\n		echo \'<td style=\"padding: 5px; width: 100px; font-weight: bold;\">Abstand</td>\'.PHP_EOL;\r\n		echo \'<td style=\"padding: 5px;\">\'.$abstand.\'px</td>\'.PHP_EOL;\r\n		echo \'</tr>\'.PHP_EOL;\r\n\r\n	echo \'</table>\'.PHP_EOL;\r\n\r\n\r\n}\r\n\r\n\r\n\r\n?>\r\n\r\n\r\n','<?php\r\n\r\n$objForm = new mform();\r\n\r\n// TEXT\r\n\r\n$objForm->addHtml(\'<div id=\"text\">\');\r\n$objForm->addTextField(1,array(\'label\'=>\'Abstand in PX\',\'style\'=>\'width:500px\'));\r\n$objForm->addDescription(\'Sofern das Feld leer gelassen wird wird ein default Abstand von : 50px benutzt\');\r\n$objForm->addHtml(\'</div>\');\r\n\r\n\r\necho $objForm->show_mform();\r\n\r\n?>\r\n\r\n','olien','',1417446202,0,'',0),
  (3,'xxx Tabelle',0,'<?php\r\n\r\nglobal $colcounter;\r\n\r\nif(!function_exists(\'getdyntable\')) {\r\n    function getdyntable($string) {\r\n        $tmp = explode(\'[ROW|ROW]\', $string);\r\n        $table = array();\r\n        for($i=0;$i<count($tmp);$i++) {\r\n            $tmp2 = explode(\'[COL|COL]\', $tmp[$i]);\r\n            foreach($tmp2 as $col) {\r\n                $table[$i][] = trim($col);\r\n            }           \r\n        }\r\n        return $table;\r\n    }\r\n}\r\n$table_data = \"REX_VALUE[1]\";\r\n$table_data = getdyntable($table_data);\r\n\r\n$out = \'<table>\';\r\n$rowcount=0;\r\nforeach ($table_data as $row) {\r\n    $out .= \'<tr>\';\r\n\r\n    foreach ($row as $col) {\r\n        ($rowcount==0) ? $out .= \'<th>\' : $out .= \'<td>\';\r\n        $out .= $col;\r\n        ($rowcount==0) ? $out .= \'</th>\' : $out .= \'</td>\';\r\n    }\r\n    $out .= \'</tr>\';\r\n    $rowcount++;\r\n}\r\n$out .= \'</table>\';\r\nprint $out;\r\n?>\r\n\r\n\r\n','<script type=\"text/javascript\">\r\n\r\njQuery(function($){ \r\n    \r\n//--- Functions ---///\r\n\r\n    function get_dyn_table_data() {\r\n        var table_data = \'\';\r\n        i=0;\r\n        $(\'div#dyntable table tr[class!=\"control\"]\').each(function() {\r\n            if(i>0) {\r\n                table_data = table_data+\'[ROW|ROW]\';\r\n            }\r\n            i++;\r\n            \r\n            j=0;\r\n            $(this).children(\'.dyn_content\').each(function() {\r\n                if(j>0) {\r\n                table_data = table_data+\'[COL|COL]\';\r\n                }\r\n                j++;     \r\n                var fieldvalue = $(this).children().first().val();\r\n                var fieldvalue_clean = fieldvalue.replace(\'[COL|COL]\', \'[col|col]\').replace(\'[ROW|ROW]\', \'[row|row]\');\r\n                table_data = table_data+fieldvalue_clean;\r\n            });\r\n        });\r\n        $(\'#debugout\').html(table_data);\r\n        $(\'#dyntable_string\').val(table_data);\r\n\r\n    }     \r\n    \r\n    function generate_dyn_table() {\r\n        var table_data = $(\'#dyntable_string\').val();\r\n        var table_rows = table_data.split(\'[ROW|ROW]\');\r\n        var table_cols = table_rows[0].split(\'[COL|COL]\');\r\n        for(var i=1; i<table_cols.length;i++) {\r\n            add_dyn_table_col();\r\n        }\r\n        for(var i=1; (i+1)<table_rows.length;i++) {\r\n           add_dyn_table_row();            \r\n        }       \r\n        update_dyn_table_counter();\r\n \r\n        for(var i=0;i<table_rows.length;i++) {\r\n            table_cols = table_rows[i].split(\'[COL|COL]\');\r\n            for(var j=0;j<table_cols.length;j++) {\r\n                if(i==0) {\r\n                    $(\'th[data-col=\"\'+(j+2)+\'\"][data-row=\"\'+(i+2)+\'\"] input\').val(table_cols[j]);\r\n                }\r\n                else {\r\n                    $(\'td[data-col=\"\'+(j+2)+\'\"][data-row=\"\'+(i+2)+\'\"] textarea\').html(table_cols[j]);\r\n                }\r\n            }   \r\n        }\r\n        get_dyn_table_data();\r\n    }\r\n\r\n    function update_dyn_table_counter() {\r\n        i=0;\r\n        $(\'div#dyntable table tr\').each(function() {\r\n            i++;\r\n            j=0;\r\n            $(this).children().each(function() {\r\n                j++;\r\n                $(this).attr(\'data-row\', i);\r\n                $(this).attr(\'data-col\', j);\r\n            });\r\n        });  \r\n    }\r\n\r\n    function add_dyn_table_col() {\r\n        $(\'div#dyntable_show table tr[class!=\"control\"][class!=\"dyn_head\"]\').append(\'<td class=\"dyn_content\"><textarea style=\"width:95%\"></textarea></td>\');\r\n        $(\'div#dyntable_show table tr[class=\"dyn_head\"][class!=\"control\"]\').append(\'<th class=\"dyn_content\"><input style=\"width:95%\"></input></th>\');\r\n        $(\'div#dyntable_show table tr[class=\"control\"]\').append(\'<th><a href=\"#\" class=\"dyntable_del_col\" >[löschen]</a> <br> <a href=\"#\" class=\"left\">[links]</a> <a href=\"#\" class=\"right\">[rechts]</a></th>\');\r\n    } \r\n\r\n    function add_dyn_table_row() {\r\n        var count = $(\'div#dyntable_show table tr.control th\').size();\r\n        var rowout = \'\';\r\n        for (var i=0; i<(count-1); i++){\r\n            rowout = rowout+\'<td class=\"dyn_content\"><textarea style=\"width:95%\"></textarea></td>\';\r\n        }\r\n\r\n        $(\'div#dyntable_show table\').append(\'<tr><td><a href=\"#\" class=\"dyntable_del_row\">[löschen]</a><br><a href=\"#\" class=\"up\" >[hoch]</a><br><a href=\"#\" class=\"down\">[runter]</a></td>\'+rowout+\'</tr>\');\r\n    }  \r\n\r\n    function move_table_col(from,to) {\r\n        var rows = $(\'tr\', \'#dyntable_show table\');\r\n        var cols;\r\n        rows.each(function() {\r\n            cols = $(this).children(\'th, td\');\r\n            cols.eq(from).detach().insertBefore(cols.eq(to));\r\n        });\r\n        get_dyn_table_data();\r\n        update_dyn_table_counter();\r\n    }\r\n\r\n//--- Events ---//\r\n\r\n    $(\'#dyntable_add_col\').click(function(e) {\r\n        e.preventDefault();\r\n        add_dyn_table_col();\r\n        update_dyn_table_counter();\r\n        get_dyn_table_data();\r\n    });\r\n    $(\'#dyntable_add_row\').click(function(e) {\r\n        e.preventDefault();\r\n        add_dyn_table_row();\r\n        update_dyn_table_counter();\r\n        get_dyn_table_data();\r\n    });\r\n  \r\n      \r\n    $(\'#dyntable_show\').on(\'click\', \'.up,.down\', function(e){\r\n        e.preventDefault();\r\n        var row = $(this).closest(\'tr\');\r\n        \r\n        if ($(this).is(\".up\")) {\r\n            var index = $( \"tr\" ).index( $(this).parent().parent() );\r\n            if(index>2)\r\n                row.insertBefore(row.prev());\r\n        } else {\r\n            row.insertAfter(row.next());\r\n        }\r\n        get_dyn_table_data();\r\n    });\r\n\r\n\r\n    $(\'#dyntable_show\').on(\'click\', \'.left,.right\', function(e) {\r\n        e.preventDefault();\r\n        var index = $( \"th\" ).index( $(this).parent() );\r\n        if($(this).is(\'.left\')) {\r\n            if(index > 1)\r\n                move_table_col(index, index-1);\r\n        }\r\n        else {\r\n            move_table_col(index+1, index);\r\n        }    \r\n    });\r\n\r\n    $(\'#dyntable_show\').on(\'click\', \'.dyntable_del_col\' ,function(e) {\r\n        e.preventDefault();\r\n        var col = $(this).parent().attr(\'data-col\');\r\n        $(\'th[data-col=\"\'+col+\'\"],td[data-col=\"\'+col+\'\"]\').remove();\r\n        get_dyn_table_data();\r\n     });\r\n\r\n     $(\'#dyntable_show\').on(\'click\', \'.dyntable_del_row\', function(e) {\r\n         e.preventDefault();\r\n         var row = $(this).parent().attr(\'data-row\');\r\n         $(this).parent().parent().remove();\r\n         get_dyn_table_data();\r\n     });\r\n\r\n     $(\'div#dyntable\').on(\'change\', \'input,textarea\', function() {\r\n            get_dyn_table_data();\r\n     });\r\n\r\n//--- Initial execution ---//\r\n\r\n     generate_dyn_table();\r\n\r\n});\r\n</script>\r\n\r\n\r\n<div id=\"dyntable\">    \r\n    <input id=\"dyntable_string\" type=\"hidden\" class=\"text\'.$classes.$wc.\'\" name=\"VALUE[1]\" id=\"test\" value=\"REX_VALUE[1]\">\r\n    <div id=\"dyntable_show\">    \r\n        <table class=\"rex-table\" style=\"padding-right:10px;\" >\r\n                <tr class=\"control\">\r\n                    <th><a id=\"dyntable_add_row\" style=\"display:block;float:left;width:20px; height:20px; background-image:url(media/pfeil_down.gif); background-position:center center; background-repeat:no-repeat;text-indent:-9999px;\" href=\"#\">[Zeile hinzu]</a><a id=\"dyntable_add_col\" style=\"display:block;width:20px; height:20px; background-image:url(media/pfeil_right.gif); background-position:center center; background-repat:no-repeat; float:left;text-indent:-9999px;\" href=\"#\">[Spalte hinzu]</a></th><th><a href=\"#\" class=\"dyntable_del_col\" >[löschen]</a> <br> <a href=\"#\" class=\"left\">[links]</a> <a href=\"#\" class=\"right\">[rechts]</a></th>\r\n                </tr>          \r\n                <tr class=\"dyn_head\">\r\n                        <th></th>\r\n                        <th class=\"dyn_content\"><input style=\"width:95%\"></input></th>\r\n                </tr>\r\n                <tr>\r\n                        <td><a href=\"#\" class=\"dyntable_del_row\">[löschen]</a><br><a href=\"#\" class=\"up\" >[hoch]</a><br><a href=\"#\" class=\"down\">[runter]</a></td>\r\n                        <td class=\"dyn_content\"><textarea style=\"width:95%\"></textarea></td>\r\n                </tr>             \r\n        </table>\r\n    </div>\r\n</div>','olien','olien',1417446222,1417704066,'',0),
  (4,'xxx PHP',0,'REX_PHP','PHP:<br>\r\n<textarea name=INPUT_PHP cols=80 rows=20 class=inp100>REX_PHP</textarea>\r\n<br><br>','olien','olien',1417446245,1417704059,'',0),
  (5,'5000 - Xform Tabelle Anzeigen',0,'<h3>Ausgabe Beispiel von Table Manger Daten inkl. Verlinkung.</h3>\n<small>url_control (hier wird auch das Ziel definiert) / xForm Klasse beachten</small>\n\n<?php\n$id = url_generate::getId(\'rex_test\');\n\nif ($id > 0) {\n\n    $datas = rex_sql::factory()->getArray(\'SELECT * FROM rex_test WHERE id = \"\' . mysql_real_escape_string($id). \'\"\');\n\n    if (count($datas) > 0) {\n        $data = current($datas);\n        echo \'<br/><br/>\'.$data[\'name\'].\'<br/>\'.PHP_EOL;\n    }\n\n} else {\n    $datas = rex_sql::factory()->getArray(\'SELECT * FROM rex_test\');\n\n    if (count($datas) > 0) {\n\n        echo \'<p><strong>Verlinkung auf eigene Seite</strong></p>\'.PHP_EOL;\n\n        foreach ($datas as $data) {\n\n            echo \'Details:<a href=\"\' . url_generate::getUrlById(\'rex_test\', $data[\'id\']) . \'\">\' . $data[\'name\'] . \'</a> | Anmeldung: <a href=\"/ausgabe-beispiele-formular.html?tid=\'.$data[\'id\'].\'\">\' . $data[\'name\'] . \'</a><br/>\';\n\n        }\n\n    }\n\n}\n?>\n\n','Keine Eingabe nötig','olien','olien',1417519055,1417529680,'',0),
  (6,'0500 - XForm Formbuilder',0,'<?php\r\n\r\n/**\r\n * XForm\r\n * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus\r\n * @author <a href=\"http://www.yakamara.de\">www.yakamara.de</a>\r\n */\r\n\r\n// module:xform_basic_out\r\n// v0.2.2\r\n//--------------------------------------------------------------------------------\r\n\r\n$xform = new rex_xform;\r\nif (\"REX_VALUE[7]\" == 1) { $xform->setDebug(TRUE); }\r\n$form_data = \'REX_VALUE[3]\';\r\n$form_data = trim(str_replace(\"<br />\",\"\",rex_xform::unhtmlentities($form_data)));\r\n$xform->setFormData($form_data);\r\n$xform->setRedaxoVars(REX_ARTICLE_ID,REX_CLANG_ID); \r\n\r\n?>REX_PHP_VALUE[9]<?php\r\n\r\n// action - showtext\r\nif(\"REX_IS_VALUE[6]\" == \"true\")\r\n{\r\n  $html = \"0\"; // plaintext\r\n  if(\'REX_VALUE[11]\' == 1) $html = \"1\"; // html\r\n  if(\'REX_VALUE[11]\' == 2) $html = \"2\"; // textile\r\n  \r\n  $e3 = \'\'; $e4 = \'\';\r\n  if ($html == \"0\") {\r\n    $e3 = \'<div class=\"rex-message\"><div class=\"rex-info\"><p>\';\r\n    $e4 = \'</p></div></div>\';\r\n  }\r\n  \r\n  $t = str_replace(\"<br />\",\"\",rex_xform::unhtmlentities(\'REX_VALUE[6]\'));\r\n  $xform->setActionField(\"showtext\",array(\r\n      $t,\r\n      $e3,\r\n      $e4,\r\n      $html // als HTML interpretieren\r\n    )\r\n  );\r\n}\r\n\r\n$form_type = \"REX_VALUE[1]\";\r\n\r\n// action - email\r\nif ($form_type == \"1\" || $form_type == \"2\" || $form_type == \"3\")\r\n{\r\n  $mail_from = $REX[\'ERROR_EMAIL\'];\r\n  if(\"REX_VALUE[2]\" != \"\") $mail_from = \"REX_VALUE[2]\";\r\n  $mail_to = $REX[\'ERROR_EMAIL\'];\r\n  if(\"REX_VALUE[12]\" != \"\") $mail_to = \"REX_VALUE[12]\";\r\n  $mail_subject = \"REX_VALUE[4]\";\r\n  $mail_body = str_replace(\"<br />\",\"\",rex_xform::unhtmlentities(\'REX_VALUE[5]\'));\r\n  $xform->setActionField(\"email\", array(\r\n      $mail_from,\r\n      $mail_to,\r\n      $mail_subject,\r\n      $mail_body\r\n    )\r\n  );\r\n}\r\n\r\n// action - db\r\nif ($form_type == \"0\" || $form_type == \"2\" || $form_type == \"3\")\r\n{\r\n  $xform->setObjectparams(\'main_table\', \'REX_VALUE[8]\');\r\n  \r\n  //getdata\r\n  if (\"REX_VALUE[10]\" != \"\")\r\n    $xform->setObjectparams(\"getdata\",TRUE);\r\n  \r\n  $xform->setActionField(\"db\", array(\r\n      \"REX_VALUE[8]\", // table\r\n      $xform->objparams[\"main_where\"], // where\r\n      )\r\n    );\r\n}\r\n\r\necho $xform->getForm();\r\n\r\n?>\r\n','<?php\r\n\r\n/**\r\n * XForm\r\n * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus\r\n * @author <a href=\"http://www.yakamara.de\">www.yakamara.de</a>\r\n */\r\n\r\n// module:xform_basic_in\r\n// v0.2.2\r\n// --------------------------------------------------------------------------------\r\n\r\n// DEBUG SELECT\r\n////////////////////////////////////////////////////////////////////////////////\r\n$dbg_sel = new rex_select();\r\n$dbg_sel->setName(\'VALUE[7]\');\r\n$dbg_sel->setSize(1);\r\n$dbg_sel->addOption(\'inaktiv\',\'0\');\r\n$dbg_sel->addOption(\'aktiv\',\'1\');\r\n$dbg_sel->setSelected(\'REX_VALUE[7]\');\r\n$dbg_sel = $dbg_sel->get();\r\n\r\n\r\n// TABLE SELECT\r\n////////////////////////////////////////////////////////////////////////////////\r\n$gc = rex_sql::factory();\r\n$gc->setQuery(\'SHOW TABLES\');\r\n$tables = $gc->getArray();\r\n$tbl_sel = new rex_select;\r\n$tbl_sel->setName(\'VALUE[8]\');\r\n$tbl_sel->setSize(1);\r\n$tbl_sel->addOption(\'Keine Tabelle ausgewählt\', \'\');\r\nforeach ($tables as $key => $value)\r\n{\r\n  $tbl_sel->addOption(current($value), current($value));\r\n}\r\n$tbl_sel->setSelected(\'REX_VALUE[8]\');\r\n$tbl_sel = $tbl_sel->get();\r\n\r\n\r\n// PLACEHOLDERS\r\n////////////////////////////////////////////////////////////////////////////////\r\n$xform = new rex_xform;\r\n$form_data = \'REX_VALUE[3]\';\r\n$form_data = trim(str_replace(\'<br />\',\'\',rex_xform::unhtmlentities($form_data)));\r\n$xform->setFormData($form_data);\r\n$xform->setRedaxoVars(REX_ARTICLE_ID,REX_CLANG_ID);\r\n$placeholders = \'\';\r\nif(\'REX_VALUE[3]\'!=\'\')\r\n{\r\n$ignores = array(\'html\',\'validate\',\'action\');\r\n  $placeholders .= \'  <strong class=\"hint\">Platzhalter: <span>[<a href=\"#\" id=\"xform-placeholders-help-toggler\">?</a>]</span></strong>\r\n  <p id=\"xform-placeholders\">\'.PHP_EOL;\r\nforeach($xform->objparams[\'form_elements\'] as $e)\r\n{\r\n  if(!in_array($e[0],$ignores) && isset($e[1]))\r\n  {\r\n      $placeholders .= \'<span>###\'.$e[1].\'###</span> \'.PHP_EOL;\r\n  }\r\n}\r\n  $placeholders .= \'  </p>\'.PHP_EOL;\r\n}\r\n\r\n\r\n// OTHERS\r\n////////////////////////////////////////////////////////////////////////////////\r\n$row_pad = 1;\r\n\r\n$sel = \'REX_VALUE[1]\';\r\n$db_display   = ($sel==\'\' || $sel==1) ?\'style=\"display:none\"\':\'\';\r\n$mail_display = ($sel==\'\' || $sel==0) ?\'style=\"display:none\"\':\'\';\r\n\r\n?>\r\n\r\n<style type=\"text/css\" media=\"screen\">\r\n  /*BAISC MODUL STYLE*/\r\n  #xform-modul                       {margin:0;padding:0;line-height:25px;}\r\n  #xform-modul fieldset              {background:#E4E1D1;margin:-20px 0 0 0;padding: 4px 10px 10px 10px;-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;}\r\n  #xform-modul fieldset legend       {display:block !important;position:relative !important;height:auto !important;top:0 !important;left:0 !important;width:100% !important;margin:0 0 0 0 !important;padding:30px 0 0 0px !important;background:transparent !important;border-bottom:1px solid #B1B1B1 !important;color:gray;font-size:14px;font-weight:bold;}\r\n  #xform-modul fieldset legend em    {font-size:10px;font-weight:normal;font-style:normal;}\r\n  #xform-modul fieldset strong.label,\r\n  #xform-modul fieldset label        {display:inline-block !important;width:150px !important;font-weight:bold;}\r\n  #xform-modul fieldset label span   {font-weight:normal;}\r\n  #xform-modul input,\r\n  #xform-modul select                {width:460px;border:auto;margin:0 !important;padding:0 !important;}\r\n  #xform-modul input[type=\"checkbox\"]{width:auto;}\r\n  #xform-modul hr                    {border:0;height:0;margin:4px 0 4px 0;padding:0;border-top:1px solid #B1B1B1 !important;clear:left;}\r\n  #xform-modul a.blank               {background:url(\"../files/addons/be_style/plugins/agk_skin/popup.gif\") no-repeat 100% 0;padding-right:17px;}\r\n  #xform-modul #modulinfo            {font-size:10px;text-align:right;}\r\n  /*XFORM MODUL*/\r\n  #xform-modul textarea              {min-height:50px;font-family:monospace;font-size:12px;}\r\n  #xform-modul pre                   {clear:left;}\r\n  #xform-modul strong span           {font-weight:normal;}\r\n  #xform-modul .help                 {display:none;color:#2C8EC0;line-height:12px;}\r\n  #xform-modul .area-wrapper         {background:white;border:1px solid #737373;margin-bottom:10px;width:100%;}\r\n  #xform-modul .fullwidth            {width:100% !important;}\r\n  #xform-modul #thx-markup           {width:auto !important;}\r\n  #xform-modul #thx-markup input     {width:auto !important;}\r\n  #xform-modul #xform-placeholders-help,\r\n  #xform-modul #xform-where-help     {display:none;}\r\n  #xform-modul #xform-placeholders,\r\n  #xform-modul #xform-classes-showhelp {background:white;border:1px solid #737373;margin-bottom:10px;width:100%;}\r\n  #xform-modul #xform-placeholders {padding:4px 10px;float:none;width:auto;}\r\n  #xform-modul #xform-placeholders span:hover {color:red;cursor:pointer;}\r\n  #xform-modul em.hint               {color:silver;margin:0;padding:0 0 0 10px;}\r\n  /*SHOWHELP OVERRIDES*/\r\n  #xform-modul ul.xform.root         {border:0;outline:0;margin:4px 0;padding:0;width:100%;background:transparent;}\r\n  #xform-modul ul.xform              {font-size:1.1em;line-height:1.4em;}\r\n</style>\r\n\r\n\r\n<div id=\"xform-modul\">\r\n<fieldset>\r\n  <legend>Formular</legend>\r\n\r\n  <label>DebugModus:</label>\r\n  <?php echo $dbg_sel;?>\r\n\r\n  <hr />\r\n\r\n  <label class=\"fullwidth\">Felddefinitionen:</label>\r\n  <textarea name=\"VALUE[3]\" id=\"xform-form-definition\" class=\"fullwidth\" rows=\"<?php echo (count(explode(\"\\r\",\'REX_VALUE[3]\'))+$row_pad);?>\">REX_VALUE[3]</textarea>\r\n\r\n  <strong class=\"label\">Verfügbare Feld-Klassen:</strong>\r\n  <div id=\"xform-classes-showhelp\">\r\n    <?php echo rex_xform::showHelp(true,true); ?>\r\n  </div><!-- #xform-classes-showhelp -->\r\n\r\n  <div id=\"thx-markup\"><strong>Meldung bei erfolgreichen Versand:</strong> (\r\n    <input type=\"radio\" name=\"VALUE[11]\" value=\"0\" <?php if(\"REX_VALUE[11]\" == \"0\") echo \'checked=\"checked\"\'; ?>> Plaintext\r\n    <input type=\"radio\" name=\"VALUE[11]\" value=\"1\" <?php if(\"REX_VALUE[11]\" == \"1\") echo \'checked=\"checked\"\'; ?>> HTML\r\n    <input type=\"radio\" name=\"VALUE[11]\" value=\"2\" <?php if(\"REX_VALUE[11]\" == \"2\") echo \'checked=\"checked\"\'; ?>> Textile)\r\n  </div><!-- #thx-markup -->\r\n  <textarea name=\"VALUE[6]\" id=\"xform-thx-message\" class=\"fullwidth\" rows=\"<?php echo (count(explode(\"\\r\",\'REX_VALUE[6]\'))+$row_pad);?>\">REX_VALUE[6]</textarea>\r\n\r\n</fieldset>\r\n\r\n\r\n<fieldset>\r\n  <legend>Vordefinierte Aktionen</legend>\r\n\r\n  <label>Bei Submit:</label>\r\n  <select name=\"VALUE[1]\" id=\"xform-action-select\" style=\"width:auto;\">\r\n    <option value=\"\"  <?php if(\"REX_VALUE[1]\" == \"\")  echo \" selected \"; ?>>Nichts machen (actions im Formular definieren)</option>\r\n    <option value=\"0\" <?php if(\"REX_VALUE[1]\" == \"0\") echo \" selected \"; ?>>Nur in Datenbank speichern oder aktualisieren wenn \"main_where\" gesetzt ist</option>\r\n    <option value=\"1\" <?php if(\"REX_VALUE[1]\" == \"1\") echo \" selected \"; ?>>Nur E-Mail versenden</option>\r\n    <option value=\"2\" <?php if(\"REX_VALUE[1]\" == \"2\") echo \" selected \"; ?>>E-Mail versenden und in Datenbank speichern</option>\r\n    <!--  <option value=\"3\" <?php if(\"REX_VALUE[1]\" == \"3\") echo \" selected \"; ?>>E-Mail versenden und Datenbank abfragen</option> -->\r\n  </select>\r\n\r\n</fieldset>\r\n\r\n\r\n<fieldset id=\"xform-mail-fieldset\" <?php echo $mail_display;?> >\r\n  <legend>Emailversand:</legend>\r\n\r\n  <label>Absender:</label>\r\n  <input type=\"text\" name=\"VALUE[2]\" value=\"REX_VALUE[2]\" />\r\n\r\n  <label>Empfänger:</label>\r\n  <input type=\"text\" name=\"VALUE[12]\" value=\"REX_VALUE[12]\" />\r\n\r\n  <label>Subject:</label>\r\n  <input type=\"text\" name=\"VALUE[4]\" value=\"REX_VALUE[4]\" />\r\n  <label class=\"fullwidth\">Mailbody:</label>\r\n  <textarea id=\"xform-mail-body\" class=\"fullwidth\" name=\"VALUE[5]\" rows=\"<?php echo (count(explode(\"\\r\",\'REX_VALUE[5]\'))+$row_pad);?>\">REX_VALUE[5]</textarea>\r\n\r\n    <?php echo $placeholders;?>\r\n\r\n  <ul class=\"help\" id=\"xform-placeholders-help\">\r\n    <li>Die Platzhalter ergeben sich aus den obenstehenden Felddefinitionen.</li>\r\n    <li>Per click können einzelne Platzhalter in den Mail-Body kopiert werden.</li>\r\n    <li>Aktualisierung der Platzhalter erfolgt über die Aktualisierung des Moduls.</li>\r\n  </ul>\r\n\r\n\r\n</fieldset>\r\n\r\n\r\n<fieldset id=\"xform-db-fieldset\" <?php echo $db_display;?> >\r\n  <legend>Datenbank Einstellungen</legend>\r\n\r\n  <label>Tabelle wählen <span>[<a href=\"#\" id=\"xform-db-help-toggler\">?</a>]</span></label>\r\n  <?php echo $tbl_sel;?>\r\n  <ul class=\"help\" id=\"xform-db-select-help\">\r\n    <li>Diese Tabelle gilt auch bei Uniqueabfragen (Pflichtfeld=2) siehe oben</li>\r\n  </ul>\r\n\r\n  <hr />\r\n\r\n  <label for=\"getdatapre\">Daten initial aus DB holen</label>\r\n  <input id=\"getdatapre\" type=\"checkbox\" value=\"1\" name=\"VALUE[10]\" <?php if(\"REX_VALUE[10]\" != \"\") echo \'checked=\"checked\"\'; ?> />\r\n\r\n  <div id=\"db_data\">\r\n    <hr />\r\n    <label>Where Klausel: <span>[<a href=\"#\" id=\"xform-xform-where-help-toggler\">?</a>]</span></label>\r\n    <textarea name=\"VALUE[9]\" cols=\"30\" id=\"xform-db-where\" class=\"fullwidth\"rows=\"<?php echo (count(explode(\"\\r\",\'REX_VALUE[9]\'))+$row_pad);?>\">REX_VALUE[9]</textarea>\r\n    <ul class=\"help\" id=\"xform-where-help\">\r\n      <li>PHP erlaubt. Beispiel: <em>$xform-&gt;setObjectparams(\"main_where\",$where);</em></li>\r\n      <li>Die Benutzereingaben aus dem Formular können mittels Platzhaltern (Schema: ###<em>FELDNAME</em>###) in der WHERE Klausel verwendet werden - Beispiel: text|myname|Name|1 -> Platzhalter: ###myname###</li>\r\n    </ul>\r\n  </div><!-- #db_data -->\r\n\r\n  </fieldset>\r\n\r\n  <p id=\"modulinfo\">XForm Formbuilder v0.2.2</p>\r\n\r\n</div><!-- #xform-modul -->\r\n\r\n<script type=\"text/javascript\">\r\n<!--\r\n(function($){\r\n\r\n  // FIX WEBKIT CSS QUIRKS\r\n  if ($.browser.webkit) {\r\n    $(\'#xform-modul textarea\').css(\'min-height\',\'70px\');\r\n    $(\'#xform-modul textarea\').css(\'width\',\'701px\');\r\n    $(\'#xform-modul fieldset\').css(\'width\',\'705px\');\r\n  }\r\n\r\n  // AUTOGROW BY ROWS\r\n  $(\'#xform-modul textarea\').keyup(function(){\r\n    var rows = $(this).val().split(/\\r?\\n|\\r/).length + <?php echo $row_pad;?>;\r\n    $(this).attr(\'rows\',rows);\r\n  });\r\n\r\n  // TOGGLERS\r\n  $(\'#xform-placeholders-help-toggler\').click(function(){\r\n    $(\'#xform-placeholders-help\').toggle(50);return false;\r\n  });\r\n  $(\'#xform-xform-where-help-toggler\').click(function(){\r\n    $(\'#xform-where-help\').toggle(50);return false;\r\n  });\r\n  $(\'#xform-db-help-toggler\').click(function(){\r\n    $(\'#xform-db-select-help\').toggle(50);return false;\r\n  });\r\n\r\n\r\n  // INSERT PLACEHOLDERS\r\n  $(\'#xform-placeholders span\').click(function(){\r\n    newval = $(\'#xform-mail-body\').val()+\' \'+$(this).html();\r\n    $(\'#xform-mail-body\').val(newval);\r\n  });\r\n\r\n  // TOGGLE MAIL/DB PANELS\r\n  $(\'#xform-action-select\').change(function(){\r\n    switch($(this).val()){\r\n      case \'\':\r\n        $(\'#xform-db-fieldset\').hide(0);\r\n        $(\'#xform-mail-fieldset\').hide(0);\r\n        break;\r\n      case \'1\':\r\n        $(\'#xform-db-fieldset\').hide(0);\r\n        $(\'#xform-mail-fieldset\').show(0);\r\n        break;\r\n      case \'0\':\r\n        $(\'#xform-db-fieldset\').show(0);\r\n        $(\'#xform-mail-fieldset\').hide(0);\r\n        break;\r\n      case \'2\':\r\n      case \'3\':\r\n        $(\'#xform-db-fieldset\').show(0);\r\n        $(\'#xform-mail-fieldset\').show(0);\r\n        break;\r\n    }\r\n  });\r\n\r\n})(jQuery)\r\n//-->\r\n</script>','','olien',0,1417605675,'',0),
  (8,'xxx Responsive Image (Media Edit)',0,'<hr/>\r\n\r\n<?php\r\n\r\n$image = \'REX_MEDIA[1]\';\r\n\r\n  $suffix = \'_header_desktop\';\r\n\r\nif ($REX[\"MOBILE\"]->isMobile()) {\r\n  $suffix = \'_header_mobil\';\r\n}\r\n\r\nif ($REX[\"MOBILE\"]->isTablet()) {\r\n  $suffix = \'_header_tablet\';\r\n}\r\n\r\n$parts = explode(\'.\', $image);\r\n$new_name = $parts[0] . $suffix . \'.\' . $parts[1];\r\n$thumbnail = OOMedia::getMediaByFilename($new_name);\r\nif ($thumbnail instanceof OOMedia) {\r\n  $thumb = $new_name;\r\n} else {\r\n  $thumb = $image;\r\n}\r\n\r\necho \'<img src=\"./files/\'.$thumb.\'\"\" alt=\"\" />\'\r\n\r\n\r\n?>\r\n\r\n<?php\r\n\r\n$image = \'REX_MEDIA[1]\';\r\n\r\n  $suffix = \'_header_tablet\';\r\n\r\nif ($REX[\"MOBILE\"]->isMobile()) {\r\n  $suffix = \'_header_mobil\';\r\n}\r\n\r\nif ($REX[\"MOBILE\"]->isTablet()) {\r\n  $suffix = \'_header_tablet\';\r\n}\r\n\r\n$parts = explode(\'.\', $image);\r\n$new_name = $parts[0] . $suffix . \'.\' . $parts[1];\r\n$thumbnail = OOMedia::getMediaByFilename($new_name);\r\nif ($thumbnail instanceof OOMedia) {\r\n  $thumb = $new_name;\r\n} else {\r\n  $thumb = $image;\r\n}\r\n\r\necho \'<img src=\"./files/\'.$thumb.\'\"\" alt=\"\" />\'\r\n\r\n\r\n?>\r\n\r\n\r\n<?php\r\n\r\n$image = \'REX_MEDIA[1]\';\r\n\r\n  $suffix = \'_header_mobile\';\r\n\r\nif ($REX[\"MOBILE\"]->isMobile()) {\r\n  $suffix = \'_header_mobil\';\r\n}\r\n\r\nif ($REX[\"MOBILE\"]->isTablet()) {\r\n  $suffix = \'_header_tablet\';\r\n}\r\n\r\n$parts = explode(\'.\', $image);\r\n$new_name = $parts[0] . $suffix . \'.\' . $parts[1];\r\n$thumbnail = OOMedia::getMediaByFilename($new_name);\r\nif ($thumbnail instanceof OOMedia) {\r\n  $thumb = $new_name;\r\n} else {\r\n  $thumb = $image;\r\n}\r\n\r\necho \'<img src=\"./files/\'.$thumb.\'\"\" alt=\"\" />\'\r\n\r\n\r\n?>\r\n','<?php\r\n$objForm = new mform();\r\n$objForm->addMediaField(1,array(\'types\'=>\'gif,jpg,png\',\'preview\'=>0,\'category\'=>0,\'label\'=>\'Datei\'));\r\n\r\n\r\necho $objForm->show_mform();\r\n?>\r\n','olien','olien',1417688457,1417704063,'',0);
/*!40000 ALTER TABLE `rex_module` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_module_action`;
CREATE TABLE `rex_module_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_redirects`;
CREATE TABLE `rex_redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_url` varchar(255) NOT NULL,
  `target_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_responsiveimg`;
CREATE TABLE `rex_responsiveimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile_first` varchar(255) NOT NULL,
  `minwidth` int(11) NOT NULL,
  `responsive` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_responsiveimg` WRITE;
/*!40000 ALTER TABLE `rex_responsiveimg` DISABLE KEYS */;
INSERT INTO `rex_responsiveimg` VALUES 
  (1,'focuspoint_mobile',480,'focuspoint_mobile'),
  (2,'focuspoint_mobile',600,'focuspoint_tablet'),
  (3,'focuspoint_mobile',960,'focuspoint_desktop');
/*!40000 ALTER TABLE `rex_responsiveimg` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_template`;
CREATE TABLE `rex_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `active` tinyint(1) DEFAULT NULL,
  `createuser` varchar(255) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `attributes` text,
  `revision` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_template` WRITE;
/*!40000 ALTER TABLE `rex_template` DISABLE KEYS */;
INSERT INTO `rex_template` VALUES 
  (1,'','Standard','<?php\r\nheader(\'Content-Type: text/html; charset=utf-8\');\r\n\r\n\r\n\r\nerror_reporting(E_ALL); // error_reporting(0);\r\n\r\nif ($this->getValue(\"article_id\") == $REX[\'NOTFOUND_ARTICLE_ID\']) {\r\n    header(\"HTTP/1.0 404 Not Found\");\r\n    header(\"Status: 404 Not Found\");\r\n}\r\n\r\n// OFFLINE ARTIKEL UMLEITEN\r\nif (!isset($_SESSION[$REX[\'INSTNAME\']][\'UID\']) or $_SESSION[$REX[\'INSTNAME\']][\'UID\']==\'\')\r\n{\r\n    if ($this->getValue(\'status\') == 0) {\r\n        if ($this->getValue(\'startpage\') == 0) {\r\n            // Weiterleitung für Artikel\r\n            header (\'HTTP/1.1 301 Moved Permanently\');\r\n            header(\'Location: http://\'.$_SERVER[\'HTTP_HOST\'].\'/\');\r\n            exit;\r\n        } else {\r\n            // Weiterleitung für Kategorien\r\n            header (\'HTTP/1.1 301 Moved Permanently\');\r\n            header(\'Location: http://\'.$_SERVER[\'HTTP_HOST\'].\'/\');\r\n            exit;\r\n        }\r\n    }\r\n}\r\n\r\n\r\n?><!doctype html>\r\n  <html lang=\"<?php echo seo42::getLangCode(); ?>\">\r\n  <head>\r\n    <meta charset=\"utf-8\" />\r\n    <base href=\"<?php echo seo42::getBaseUrl(); ?>\" />\r\n    <title><?php echo seo42::getTitle(); ?></title>\r\n    <meta name=\"description\" content=\"<?php echo seo42::getDescription(); ?>\" />\r\n    <meta name=\"keywords\" content=\"<?php echo seo42::getKeywords(); ?>\" />\r\n    <meta name=\"robots\" content=\"<?php echo seo42::getRobotRules();?>\" />\r\n    <meta name=\"HandheldFriendly\" content=\"True\">\r\n\r\n    <meta name=\"MobileOptimized\" content=\"320\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\">\r\n\r\n    <link rel=\"stylesheet\" href=\"<?php\r\n    echo min42::getCombinedCSSMinFile(\"screen.less\", array(\r\n        \"responsive.less\",\r\n        \"print.less\"\r\n    ));\r\n    ?>\">\r\n\r\n    <link rel=\"stylesheet\" href=\"<?php echo seo42::getCSSFile(\"../fonts/awesome/less/font-awesome.less\"); ?>\" type=\"text/css\" media=\"screen,print\" />\r\n\r\n\r\n    <link rel=\"shortcut icon\" href=\"<?php echo seo42::getImageFile(\"favicon.ico\"); ?>\" type=\"image/x-icon\" />\r\n    <link rel=\"canonical\" href=\"<?php echo seo42::getCanonicalUrl(); ?>\" />\r\n    <?php echo seo42::getLangTags(); ?>\r\n\r\n\r\n\r\n<script type=\"text/javascript\" src=\"<?php\r\n    echo min42::getCombinedJSMinFile(\"default.js\", array(\r\n        \"/vendor/jquery-1.11.1.min.js\",\r\n        \"domscript.js\"\r\n    ));\r\n?>\"></script>\r\n\r\n</head>\r\n\r\n<?php if ($REX[\'START_ARTICLE_ID\'] == $this->getValue(\"article_id\")) {\r\n  	echo \'<body id=\"home\">\'.PHP_EOL;\r\n  } else {\r\n  	echo \'<body>\'.PHP_EOL;\r\n  }\r\n?>\r\n<!--[if lt IE 9]>\r\n  <p class=\"browsehappy\">You are using an <strong>outdated</strong> browser. Please <a href=\"http://browsehappy.com/\">upgrade your browser</a> to improve your experience.</p>\r\n<![endif]-->\r\n <header>\r\n\r\n\r\n    <?php // Breadcrumb - phone\r\n\r\n    $detect = new Mobile_Detect;\r\n    if( $detect->isMobile() && !$detect->isTablet() ){\r\n\r\n         $P = explode(\"|\",$this->getValue(\"path\").$this->getValue(\"article_id\").\"|\");\r\n           if ($P[2] ) {\r\n\r\n              $nav = rex_navigation::factory();\r\n\r\n              echo \'\r\n              <div class=\"container\" >\r\n                <section id=\"breadcrumb\" >\r\n                  <ul class=\"rex-breadcrumb\">\r\n                     \'.$nav->getBreadcrumb(\'Start\',TRUE,0).\'\r\n                  </ul>\r\n                </section>\r\n              </div>\r\n              <script>\r\n                $(\"html, body\").animate({ scrollTop: \"35px\" }, 400);\r\n              </script>\r\n              \'.PHP_EOL;\r\n            }\r\n      }\r\n        ?>\r\n\r\n\r\n\r\n\r\n<div class=\"container\">\r\n\r\n<strong>Logo</strong>\r\n<a class=\"logo\" href=\"./\" title=\"### link auf dem logo ###\">### link auf dem logo ###</a>\r\n<br/><br/>\r\n<strong>Header Nav</strong>\r\n<?php\r\n\r\n\r\n\r\n    if(!function_exists(\'navIconCallback\')){\r\n        function navIconCallback($cat, $depth, &$li, &$a){\r\n            $articleObject = OOArticle::getArticleById($cat->getValue(\'id\'));\r\n            if(is_object($articleObject)) {\r\n                if($articleObject->getValue(\'art_fonticon\') != \'\'){\r\n                  $a[\'class\'][] = \'fa \'.$articleObject->getValue(\'art_fonticon\');\r\n//                  $li[\'class\'][] = \'fa \'.$articleObject->getValue(\'art_fonticon\');\r\n                }\r\n            }\r\n         //  print_r($a);\r\n\r\n            return $a;\r\n        }\r\n    }\r\n\r\n\r\n    $nav = rex_navigation::factory();\r\n    $nav->addFilter(\"cat_navigationstyp\",\"/\\|header\\|/\",\"regex\");\r\n    $nav->addCallback(\'navIconCallback\', 1);\r\n    $headerNav = $nav->get(0,-1,TRUE,TRUE);\r\n  unset($nav);\r\n\r\n    echo $headerNav;\r\n\r\n\r\n\r\n?>\r\n\r\n<strong>Main Nav</strong>\r\n<?php\r\n  $nav = rex_navigation::factory();\r\n  $nav->addFilter(\"cat_navigationstyp\",\"/\\|main\\|/\",\"regex\");\r\n  $nav_main = $nav->get(0,-1,TRUE,TRUE);\r\n  unset($nav);\r\n  echo $nav_main;\r\n?>\r\n\r\n<br/><br/>\r\n<strong>Inhalt</strong>\r\nREX_ARTICLE[]\r\n<br/><br/>\r\n\r\n<?php // Backlink\r\n  if ($this->getValue(\"art_backlink\") == \'|1|\') {\r\n    echo \'<a href=\"javascript:history.back();\">### zurueck ###</a>\'.PHP_EOL;\r\n  }\r\n?>\r\n<br/><br/>\r\n\r\n<strong>Footer Nav</strong>\r\n<?php\r\n  $nav = rex_navigation::factory();\r\n  $nav->addFilter(\"cat_navigationstyp\",\"/\\|footer\\|/\",\"regex\");\r\n  $nav_footer = $nav->get(0,1,TRUE,TRUE);\r\n  unset($nav);\r\n  echo $nav_footer;\r\n?>\r\n<br/><br/>\r\n<a class=\"top\" href=\"javascript:void(0);\" >###nach oben###</a>\r\n\r\n        <!-- Google Analytics: change UA-XXXXX-X to be your site\'s ID. -->\r\n        <!-- script>\r\n            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=\r\n            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;\r\n            e=o.createElement(i);r=o.getElementsByTagName(i)[0];\r\n            e.src=\'//www.google-analytics.com/analytics.js\';\r\n            r.parentNode.insertBefore(e,r)}(window,document,\'script\',\'ga\'));\r\n            ga(\'create\',\'UA-XXXXX-X\');ga(\'send\',\'pageview\');\r\n        </script -->\r\n    </body>\r\n</html>\r\n',1,'olien','olien',1417434340,1417704085,'a:3:{s:10:\"categories\";a:1:{s:3:\"all\";s:1:\"1\";}s:5:\"ctype\";a:0:{}s:7:\"modules\";a:1:{i:1;a:1:{s:3:\"all\";s:1:\"1\";}}}',0);
/*!40000 ALTER TABLE `rex_template` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_test`;
CREATE TABLE `rex_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_test` WRITE;
/*!40000 ALTER TABLE `rex_test` DISABLE KEYS */;
INSERT INTO `rex_test` VALUES 
  (1,'Erster Eintrag'),
  (2,'Zweiter Eintrag'),
  (3,'Dritter Eintrag'),
  (4,'Vierter Eintrag');
/*!40000 ALTER TABLE `rex_test` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_url_control_generate`;
CREATE TABLE `rex_url_control_generate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `clang` int(11) NOT NULL DEFAULT '0',
  `url` text,
  `table` varchar(255) NOT NULL,
  `table_parameters` text NOT NULL,
  `createdate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_url_control_generate` WRITE;
/*!40000 ALTER TABLE `rex_url_control_generate` DISABLE KEYS */;
INSERT INTO `rex_url_control_generate` VALUES 
  (1,14,0,'','rex_test','a:24:{s:21:\"rex_420_xoutputfilter\";a:5:{s:26:\"rex_420_xoutputfilter_name\";s:2:\"id\";s:24:\"rex_420_xoutputfilter_id\";s:2:\"id\";s:39:\"rex_420_xoutputfilter_restriction_field\";s:0:\"\";s:42:\"rex_420_xoutputfilter_restriction_operator\";s:1:\"=\";s:39:\"rex_420_xoutputfilter_restriction_value\";s:0:\"\";}s:13:\"rex_62_params\";a:5:{s:18:\"rex_62_params_name\";s:8:\"field_id\";s:16:\"rex_62_params_id\";s:8:\"field_id\";s:31:\"rex_62_params_restriction_field\";s:0:\"\";s:34:\"rex_62_params_restriction_operator\";s:1:\"=\";s:31:\"rex_62_params_restriction_value\";s:0:\"\";}s:11:\"rex_62_type\";a:5:{s:16:\"rex_62_type_name\";s:2:\"id\";s:14:\"rex_62_type_id\";s:2:\"id\";s:29:\"rex_62_type_restriction_field\";s:0:\"\";s:32:\"rex_62_type_restriction_operator\";s:1:\"=\";s:29:\"rex_62_type_restriction_value\";s:0:\"\";}s:20:\"rex_679_type_effects\";a:5:{s:25:\"rex_679_type_effects_name\";s:2:\"id\";s:23:\"rex_679_type_effects_id\";s:2:\"id\";s:38:\"rex_679_type_effects_restriction_field\";s:0:\"\";s:41:\"rex_679_type_effects_restriction_operator\";s:1:\"=\";s:38:\"rex_679_type_effects_restriction_value\";s:0:\"\";}s:13:\"rex_679_types\";a:5:{s:18:\"rex_679_types_name\";s:2:\"id\";s:16:\"rex_679_types_id\";s:2:\"id\";s:31:\"rex_679_types_restriction_field\";s:0:\"\";s:34:\"rex_679_types_restriction_operator\";s:1:\"=\";s:31:\"rex_679_types_restriction_value\";s:0:\"\";}s:10:\"rex_action\";a:5:{s:15:\"rex_action_name\";s:2:\"id\";s:13:\"rex_action_id\";s:2:\"id\";s:28:\"rex_action_restriction_field\";s:0:\"\";s:31:\"rex_action_restriction_operator\";s:1:\"=\";s:28:\"rex_action_restriction_value\";s:0:\"\";}s:11:\"rex_article\";a:5:{s:16:\"rex_article_name\";s:3:\"pid\";s:14:\"rex_article_id\";s:3:\"pid\";s:29:\"rex_article_restriction_field\";s:0:\"\";s:32:\"rex_article_restriction_operator\";s:1:\"=\";s:29:\"rex_article_restriction_value\";s:0:\"\";}s:17:\"rex_article_slice\";a:5:{s:22:\"rex_article_slice_name\";s:2:\"id\";s:20:\"rex_article_slice_id\";s:2:\"id\";s:35:\"rex_article_slice_restriction_field\";s:0:\"\";s:38:\"rex_article_slice_restriction_operator\";s:1:\"=\";s:35:\"rex_article_slice_restriction_value\";s:0:\"\";}s:9:\"rex_clang\";a:5:{s:14:\"rex_clang_name\";s:2:\"id\";s:12:\"rex_clang_id\";s:2:\"id\";s:27:\"rex_clang_restriction_field\";s:0:\"\";s:30:\"rex_clang_restriction_operator\";s:1:\"=\";s:27:\"rex_clang_restriction_value\";s:0:\"\";}s:8:\"rex_file\";a:5:{s:13:\"rex_file_name\";s:7:\"file_id\";s:11:\"rex_file_id\";s:7:\"file_id\";s:26:\"rex_file_restriction_field\";s:0:\"\";s:29:\"rex_file_restriction_operator\";s:1:\"=\";s:26:\"rex_file_restriction_value\";s:0:\"\";}s:17:\"rex_file_category\";a:5:{s:22:\"rex_file_category_name\";s:2:\"id\";s:20:\"rex_file_category_id\";s:2:\"id\";s:35:\"rex_file_category_restriction_field\";s:0:\"\";s:38:\"rex_file_category_restriction_operator\";s:1:\"=\";s:35:\"rex_file_category_restriction_value\";s:0:\"\";}s:10:\"rex_module\";a:5:{s:15:\"rex_module_name\";s:2:\"id\";s:13:\"rex_module_id\";s:2:\"id\";s:28:\"rex_module_restriction_field\";s:0:\"\";s:31:\"rex_module_restriction_operator\";s:1:\"=\";s:28:\"rex_module_restriction_value\";s:0:\"\";}s:17:\"rex_module_action\";a:5:{s:22:\"rex_module_action_name\";s:2:\"id\";s:20:\"rex_module_action_id\";s:2:\"id\";s:35:\"rex_module_action_restriction_field\";s:0:\"\";s:38:\"rex_module_action_restriction_operator\";s:1:\"=\";s:35:\"rex_module_action_restriction_value\";s:0:\"\";}s:13:\"rex_redirects\";a:5:{s:18:\"rex_redirects_name\";s:2:\"id\";s:16:\"rex_redirects_id\";s:2:\"id\";s:31:\"rex_redirects_restriction_field\";s:0:\"\";s:34:\"rex_redirects_restriction_operator\";s:1:\"=\";s:31:\"rex_redirects_restriction_value\";s:0:\"\";}s:12:\"rex_template\";a:5:{s:17:\"rex_template_name\";s:2:\"id\";s:15:\"rex_template_id\";s:2:\"id\";s:30:\"rex_template_restriction_field\";s:0:\"\";s:33:\"rex_template_restriction_operator\";s:1:\"=\";s:30:\"rex_template_restriction_value\";s:0:\"\";}s:8:\"rex_test\";a:5:{s:13:\"rex_test_name\";s:4:\"name\";s:11:\"rex_test_id\";s:2:\"id\";s:26:\"rex_test_restriction_field\";s:0:\"\";s:29:\"rex_test_restriction_operator\";s:1:\"=\";s:26:\"rex_test_restriction_value\";s:0:\"\";}s:24:\"rex_url_control_generate\";a:5:{s:29:\"rex_url_control_generate_name\";s:2:\"id\";s:27:\"rex_url_control_generate_id\";s:2:\"id\";s:42:\"rex_url_control_generate_restriction_field\";s:0:\"\";s:45:\"rex_url_control_generate_restriction_operator\";s:1:\"=\";s:42:\"rex_url_control_generate_restriction_value\";s:0:\"\";}s:23:\"rex_url_control_manager\";a:5:{s:28:\"rex_url_control_manager_name\";s:2:\"id\";s:26:\"rex_url_control_manager_id\";s:2:\"id\";s:41:\"rex_url_control_manager_restriction_field\";s:0:\"\";s:44:\"rex_url_control_manager_restriction_operator\";s:1:\"=\";s:41:\"rex_url_control_manager_restriction_value\";s:0:\"\";}s:8:\"rex_user\";a:5:{s:13:\"rex_user_name\";s:7:\"user_id\";s:11:\"rex_user_id\";s:7:\"user_id\";s:26:\"rex_user_restriction_field\";s:0:\"\";s:29:\"rex_user_restriction_operator\";s:1:\"=\";s:26:\"rex_user_restriction_value\";s:0:\"\";}s:24:\"rex_xform_email_template\";a:5:{s:29:\"rex_xform_email_template_name\";s:2:\"id\";s:27:\"rex_xform_email_template_id\";s:2:\"id\";s:42:\"rex_xform_email_template_restriction_field\";s:0:\"\";s:45:\"rex_xform_email_template_restriction_operator\";s:1:\"=\";s:42:\"rex_xform_email_template_restriction_value\";s:0:\"\";}s:15:\"rex_xform_field\";a:5:{s:20:\"rex_xform_field_name\";s:2:\"id\";s:18:\"rex_xform_field_id\";s:2:\"id\";s:33:\"rex_xform_field_restriction_field\";s:0:\"\";s:36:\"rex_xform_field_restriction_operator\";s:1:\"=\";s:33:\"rex_xform_field_restriction_value\";s:0:\"\";}s:15:\"rex_xform_table\";a:5:{s:20:\"rex_xform_table_name\";s:2:\"id\";s:18:\"rex_xform_table_id\";s:2:\"id\";s:33:\"rex_xform_table_restriction_field\";s:0:\"\";s:36:\"rex_xform_table_restriction_operator\";s:1:\"=\";s:33:\"rex_xform_table_restriction_value\";s:0:\"\";}s:19:\"rex_yrewrite_domain\";a:5:{s:24:\"rex_yrewrite_domain_name\";s:2:\"id\";s:22:\"rex_yrewrite_domain_id\";s:2:\"id\";s:37:\"rex_yrewrite_domain_restriction_field\";s:0:\"\";s:40:\"rex_yrewrite_domain_restriction_operator\";s:1:\"=\";s:37:\"rex_yrewrite_domain_restriction_value\";s:0:\"\";}s:20:\"rex_yrewrite_forward\";a:5:{s:25:\"rex_yrewrite_forward_name\";s:2:\"id\";s:23:\"rex_yrewrite_forward_id\";s:2:\"id\";s:38:\"rex_yrewrite_forward_restriction_field\";s:0:\"\";s:41:\"rex_yrewrite_forward_restriction_operator\";s:1:\"=\";s:38:\"rex_yrewrite_forward_restriction_value\";s:0:\"\";}}',1417522289,'olien',1417529342,'olien');
/*!40000 ALTER TABLE `rex_url_control_generate` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_url_control_manager`;
CREATE TABLE `rex_url_control_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `url` text,
  `method` varchar(255) NOT NULL,
  `method_parameters` text,
  `createdate` int(11) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_xform_email_template`;
CREATE TABLE `rex_xform_email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `mail_from` varchar(255) NOT NULL DEFAULT '',
  `mail_from_name` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `body_html` text NOT NULL,
  `attachments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_xform_field`;
CREATE TABLE `rex_xform_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(100) NOT NULL,
  `prio` int(11) NOT NULL,
  `type_id` varchar(100) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `list_hidden` tinyint(1) NOT NULL,
  `search` tinyint(1) NOT NULL,
  `name` text NOT NULL,
  `label` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_xform_field` WRITE;
/*!40000 ALTER TABLE `rex_xform_field` DISABLE KEYS */;
INSERT INTO `rex_xform_field` VALUES 
  (1,'rex_test',1,'value','text',0,1,'name','Name');
/*!40000 ALTER TABLE `rex_xform_field` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_xform_table`;
CREATE TABLE `rex_xform_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `list_amount` tinyint(3) unsigned NOT NULL DEFAULT '50',
  `list_sortfield` varchar(255) NOT NULL DEFAULT 'id',
  `list_sortorder` enum('ASC','DESC') NOT NULL DEFAULT 'ASC',
  `prio` int(11) NOT NULL,
  `search` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `export` tinyint(1) NOT NULL,
  `import` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `rex_xform_table` WRITE;
/*!40000 ALTER TABLE `rex_xform_table` DISABLE KEYS */;
INSERT INTO `rex_xform_table` VALUES 
  (1,1,'rex_test','Test Liste','',50,'id','ASC',1,0,0,0,0);
/*!40000 ALTER TABLE `rex_xform_table` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_yrewrite_domain`;
CREATE TABLE `rex_yrewrite_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `mount_id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL,
  `notfound_id` int(11) NOT NULL,
  `alias_domain` varchar(255) NOT NULL,
  `clangs` varchar(255) NOT NULL,
  `clang_start` int(11) NOT NULL,
  `robots` text NOT NULL,
  `title_scheme` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rex_yrewrite_forward`;
CREATE TABLE `rex_yrewrite_forward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `article_id` int(11) NOT NULL,
  `clang` int(11) NOT NULL,
  `extern` varchar(255) NOT NULL,
  `media` varchar(255) NOT NULL,
  `movetype` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
