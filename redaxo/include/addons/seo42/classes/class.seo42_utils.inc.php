<?php

class seo42_utils {
	public static function appendToPageHeader($params) {
		global $REX;

		$insert = '<!-- BEGIN seo42 -->' . PHP_EOL;
		$insert .= '<link rel="stylesheet" type="text/css" href="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/seo42.css" />' . PHP_EOL;
		$insert .= '<link rel="stylesheet" type="text/css" href="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/qtip.css" />' . PHP_EOL;
		$insert .= '<link rel="stylesheet" type="text/css" href="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/jquery.tag-editor.css" />' . PHP_EOL;
		$insert .= '<link rel="stylesheet" type="text/css" href="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/jquery.dropdown.css" />' . PHP_EOL;
		$insert .= '<script type="text/javascript" src="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/jquery.qtip.min.js"></script>' . PHP_EOL;
		$insert .= '<script type="text/javascript" src="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/jquery.tag-editor.min.js"></script>' . PHP_EOL;
		$insert .= '<script type="text/javascript" src="../' . $REX['MEDIA_ADDON_DIR'] . '/seo42/jquery.dropdown.min.js"></script>' . PHP_EOL;
		$insert .= '<!-- END seo42 -->';
	
		return $params['subject'] . PHP_EOL . $insert;
	}

	public static function init($params) {
		global $REX;

		if ($REX['MOD_REWRITE']) {
			// includes
			require_once($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.seo42_rewrite.inc.php');

			if ($REX['REDAXO']) { // this is only necessary for backend
				$extensionPoints = array(
					'CAT_ADDED',     'CAT_UPDATED',     'CAT_DELETED',
					'ART_ADDED',     'ART_UPDATED',     'ART_DELETED',        'ART_META_FORM_SECTION',
					'ART_TO_CAT',    'CAT_TO_ART',      'ART_TO_STARTPAGE',
					'CLANG_ADDED',   'CLANG_UPDATED',   'CLANG_DELETED',
					'ALL_GENERATED'
				);

				// generate pathlist on each extension point
				foreach($extensionPoints as $extensionPoint) {
					rex_register_extension($extensionPoint, 'seo42_generate_pathlist');
				}
			}

			// init rewriter 
			$rewriter = new SEO42Rewrite();

			// rewrite ep 
			rex_register_extension('URL_REWRITE', array ($rewriter, 'rewrite'));

			$rewriter->resolve();
		}

		// init current article
		seo42::initArticle($REX['ARTICLE_ID']);

		// controller
		include($REX['INCLUDE_PATH'] . '/addons/seo42/controller.inc.php');

		// seo42 post init
		rex_register_extension_point('SEO42_INCLUDED');
	}

	public static function sendHeaders() {
		global $REX;

		// frontend
		if (!$REX['REDAXO']) {
			// set noindex header for robots if current article has noindex flag
			if (seo42::isArticleValid() && seo42::hasNoIndexFlag()) {
				header('X-Robots-Tag: noindex, noarchive');
			}

			// try fixing redaxo's errorarticle behaviour
			if (seo42::has404ResponseFlag() && $REX['START_ARTICLE_ID'] == $REX['NOTFOUND_ARTICLE_ID']) {
				header("HTTP/1.0 404 Not Found");
			}
		}
	}

	public static function afterDBImport($params) {
		global $REX, $I18N;

		$sqlStatement = 'SELECT seo_title, seo_description, seo_keywords, seo_custom_url, seo_canonical_url, seo_noindex, seo_ignore_prefix FROM ' . $REX['TABLE_PREFIX'] . 'article';
		$sql = rex_sql::factory();
		$sql->setQuery($sqlStatement);

		// check for db fields
		if ($sql->getRows() == 0) {
			require($REX['INCLUDE_PATH'] . '/addons/seo42/install.inc.php');
			echo rex_info($I18N->msg('seo42_dbfields_readded', $REX['ADDON']['name']['seo42']));
			echo rex_info($I18N->msg('seo42_dbfields_readded_check_setup', $REX['ADDON']['name']['seo42']));
		}
	}

	public static function showMsgAfterClangModified($params) {
		global $I18N, $REX;

		echo rex_info($I18N->msg('seo42_check_lang_msg', $REX['ADDON']['name']['seo42']));
	}

	public static function addSEOPageToPageContentMenu($params) {
		global $I18N;
			
		$class = "";

		if ($params['mode']  == 'seo') {
			$class = 'class="rex-active"';
		}

		$seoLink = '<a '.$class.' href="index.php?page=content&amp;article_id=' . $params['article_id'] . '&amp;mode=seo&amp;clang=' . $params['clang'] . '&amp;ctype=' . rex_request('ctype') . '">' . $I18N->msg('seo42_seopage_linktext') . '</a>';
		array_splice($params['subject'], '1', '0', $seoLink);

		return $params['subject'];
	}

	public static function addSEOPageToPageContentOutput($params) {
		global $REX, $I18N;

		if ($params['mode']  == 'seo') {
			include($REX['INCLUDE_PATH'] . '/addons/seo42/pages/seopage.inc.php');
		}
	}

	public static function addURLPageToPageContentMenu($params) {
		global $I18N;
			
		$class = "";

		if ($params['mode']  == 'url') {
			$class = 'class="rex-active"';
		}

		$seoLink = '<a ' . $class . ' href="index.php?page=content&amp;article_id=' . $params['article_id'] . '&amp;mode=url&amp;clang=' . $params['clang'] . '&amp;ctype=' . rex_request('ctype') . '">' . $I18N->msg('seo42_urlpage_linktext') . '</a>';
		array_splice($params['subject'], '1', '0', $seoLink);

		return $params['subject'];
	}

	public static function addURLPageToPageContentOutput($params) {
		global $REX, $I18N;

		if ($params['mode']  == 'url') {
			include($REX['INCLUDE_PATH'] . '/addons/seo42/pages/urlpage.inc.php');
		}
	}

	public static function enableSEOPage() {
		global $REX;

		if ($REX['ADDON']['seo42']['settings']['seopage']) {
			rex_register_extension('PAGE_CONTENT_MENU', 'seo42_utils::addSEOPageToPageContentMenu');
			rex_register_extension('PAGE_CONTENT_OUTPUT', 'seo42_utils::addSEOPageToPageContentOutput');
		}
	}

	public static function enableURLPage() {
		global $REX;

		if ($REX['ADDON']['seo42']['settings']['urlpage'] && $REX['ADDON']['seo42']['settings']['rewriter']) {
			rex_register_extension('PAGE_CONTENT_MENU', 'seo42_utils::addURLPageToPageContentMenu');
			rex_register_extension('PAGE_CONTENT_OUTPUT', 'seo42_utils::addURLPageToPageContentOutput');
		}
	}

	public static function fixArticlePreviewLink($params) {
		global $REX;

		$lastElement = count($params['subject']) - 1;

		if ($REX['ADDON']['seo42']['settings']['one_page_mode'] && $REX['ARTICLE_ID'] != $REX['START_ARTICLE_ID']) {
			// one page mode link to frontend
			$newUrl = seo42::getFullUrl($REX['START_ARTICLE_ID']);
		} else {
			$newUrl = seo42::getFullUrl();
		}

		$params['subject'][$lastElement] = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $newUrl, $params['subject'][$lastElement]);

		return $params['subject'];
	}

	public static function sanitizeString($string) {
		return trim(preg_replace("/\s\s+/", " ", $string));
	}

	public static function sanitizeUrl($url) {
		return preg_replace('@^https?://|/.*|[^\w.-]@', '', $url);
	}

	// untested
	public static function getServerUrl() {
		$url = $_SERVER['REQUEST_URI'];
		$parts = explode('/',$url);
		$serverUrl = 'http://' . self::getServerHost();

		for ($i = 0; $i < count($parts) - 2; $i++) {
			$serverUrl .= $parts[$i] . "/";
		}

		return $serverUrl;
	}

	public static function detectSubDir() {
		if ($_SERVER['PHP_SELF'] == '/redaxo/index.php') {
			return false;
		} else {
			return true;
		}
	}

	public static function print_r_pretty($arr, $first = true, $tab=0) {
		$output = "";
		$tabsign = ($tab) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$tab) : '';

		if ($first) $output .= "<pre>";

		foreach($arr as $key => $val)
		{
		    switch (gettype($val))
		    {
		        case "array":
					if (empty($val)) {
			            $output .= $tabsign."[".htmlspecialchars($key)."] => ".$tabsign."";
					} else {
			            $output .= $tabsign."[".htmlspecialchars($key)."] => <br>".$tabsign."(<br>";
					}

		            $tab++;
		            $output .= self::print_r_pretty($val,false,$tab);
		            $tab--;

					if (empty($val)) {
			            $output .= $tabsign."<br>";
					} else {
			            $output .= $tabsign.")<br>";
					}
		        break;
		        case "boolean":
		            $output .= $tabsign."[".htmlspecialchars($key)."] => ".($val?"true":"false")."<br>";
		        break;
		        case "integer":
		            $output .= $tabsign."[".htmlspecialchars($key)."] => ".htmlspecialchars($val)."<br>";
		        break;
		        case "double":
		            $output .= $tabsign."[".htmlspecialchars($key)."] => ".htmlspecialchars($val)."<br>";
		        break;
		        case "string":
		            $output .= $tabsign."[".htmlspecialchars($key)."] => ".((stristr($key,'passw')) ? str_repeat('*', strlen($val)) : htmlspecialchars($val))."<br>";
		        break;
		        default:
		            $output .= $tabsign."[".htmlspecialchars($key)."] => ".htmlspecialchars(gettype($val))."<br>";
		        break;
		    }
		}

		if ($first) $output .= "</pre>";

		return $output;
	}

	public static function autoInstallPlugins($addon, $plugins) {
		// take from xform install routine :)
		$msg = '';

		// GET ALL ADDONS & PLUGINS
		$all_addons = rex_read_addons_folder();
		$all_plugins = array();

		foreach ($all_addons as $_addon) {
			$all_plugins[$_addon] = rex_read_plugins_folder($_addon);
		}

		// DO AUTOINSTALL
		$pluginManager = new rex_pluginManager($all_plugins, $addon);

		foreach ($plugins as $pluginname) {
			if (in_array($pluginname, $all_plugins[$addon])) { // check if plugin that should be auto install really exists in addon folder
				// INSTALL PLUGIN
				if (($instErr = $pluginManager->install($pluginname)) !== true) {
					$msg = $instErr;
				}

				// ACTIVATE PLUGIN
				if ($msg == '' && ($actErr = $pluginManager->activate($pluginname)) !== true) {
					$msg = $actErr;
				}

				if ($msg != '') {
					break;
				}
			}
		}

		return $msg;
	}

	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public static function containsString($haystack, $needle) {
		$pos = strpos($haystack, $needle);

		if ($pos === false) {
			return false;
		} else {
			return true;
		}
	}

	public static function stringStartsWith($haystack, $startString) {
		if (strpos($haystack, $startString) === 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function showUrlTypeMsg($params) {
		global $REX, $I18N;

		$currentArticle = OOArticle::getArticleById($REX['ARTICLE_ID']);
		$urlField = $currentArticle->getValue('seo_custom_url');
		$articleId = $currentArticle->getValue('id');
		$clangId = $currentArticle->getValue('clang');
		$msg = '';
		$isError = false;

		$urlData = seo42_utils::getUrlTypeData($urlField);
		$jsonData = json_decode($urlData, true);	

		if ($REX['CUR_CLANG'] != $REX['START_CLANG_ID']) {
			$currentArticleDefaultLang = OOArticle::getArticleById($REX['ARTICLE_ID'], $REX['START_CLANG_ID']);
			$data = json_decode($currentArticleDefaultLang->getValue('seo_custom_url'), true);

			if (isset($data['url_clone']) && $data['url_clone'] == true) {
				$jsonData = $data;
			}
		}
		
		if (isset($jsonData['url_type'])) {
			switch ($jsonData['url_type']) {
				case SEO42_URL_TYPE_INTERN_REPLACE:
					$customArticleId = $jsonData['article_id'];
					$article = OOArticle::getArticleById($customArticleId);

					if (OOArticle::isValid($article)) {
						$msg = $I18N->msg('seo42_urltype_intern') . ' <a href="index.php?page=content&article_id=' . $customArticleId . '&mode=edit&clang=' . $REX['CUR_CLANG'] . '">' . $article->getName() . '</a>';
					} else {
						$msg = $I18N->msg('seo42_urltype_error');
						$isError = true;
					}

					break;
				case SEO42_URL_TYPE_INTERN_REPLACE_CLANG:
					$customArticleId = $jsonData['article_id'];
					$customClangId = $jsonData['clang_id'];
					$article = OOArticle::getArticleById($customArticleId, $customClangId);

					if (OOArticle::isValid($article)) {
						$msg = $I18N->msg('seo42_urltype_intern_plus_clang', '<a href="index.php?page=content&article_id=' . $customArticleId . '&mode=edit&clang=' . $customClangId . '">' . $article->getName() . '</a>', $REX['CLANG'][$customClangId]);
					} else {
						$msg = $I18N->msg('seo42_urltype_error');
						$isError = true;
					}

					break;
				case SEO42_URL_TYPE_USERDEF_INTERN:
					// do nothing
					break;
				case SEO42_URL_TYPE_USERDEF_EXTERN:
					$customUrl = $jsonData['custom_url'];

					if (seo42_utils::stringStartsWith($customUrl, 'javascript:')) {
						$msg = $I18N->msg('seo42_urltype_userdef_javascript');
					} else {
						$msg = $I18N->msg('seo42_urltype_userdef') . ': <a href="' . $customUrl . '" target="_blank">' . $customUrl . '</a>';
					}

					break;
				case SEO42_URL_TYPE_MEDIAPOOL:
					$customUrl = '/' . $REX['MEDIA_DIR'] . '/' . $jsonData['file'];

					$msg = $I18N->msg('seo42_urltype_mediapool', '<a href="' . $customUrl . '" target="_blank">' . $jsonData['file'] . '</a>');;

					break;
				case SEO42_URL_TYPE_LANGSWITCH:
					$newClangId = $jsonData['clang_id'];

					$msg = $I18N->msg('seo42_urltype_langswitch', $REX['CLANG'][$newClangId]);

					break;
				case SEO42_URL_TYPE_NONE:
					$msg = $I18N->msg('seo42_urltype_none');

					break;
				case SEO42_URL_TYPE_REMOVE_ROOT_CAT:
					// do nothing

					break;
				case SEO42_URL_TYPE_CALL_FUNC:
					if (isset($jsonData['no_url']) && $jsonData['no_url']) {
						$msg = $I18N->msg('seo42_urltype_none');
					}

					break;
				default:
				case SEO42_URL_TYPE_DEFAULT:
					// do nothing

					break;
			}
		}

		if ($msg != '') {
			echo '	<style type=text/css>
						.rex-info p,
						.rex-warning p { 
							padding: 4px 0 2px 0; 
						}
					</style>';

			if ($isError) {
				echo rex_warning($msg);
			} else {
				echo rex_info($msg);
			}
		}
	}

	public static function isInternalCustomUrl($url) {
		$urlParts = parse_url($url);

		if (isset($urlParts['scheme'])) {
			return false;
		} else {
			return true;
		}
	}

	public static function getUrlTypeData($urlField) {
		if (seo42_utils::isJson($urlField)) {
			return $urlField;
		} else {
			// compat
			return json_encode(array('url_type' => SEO42_URL_TYPE_USERDEF_INTERN, 'custom_url' => $urlField));
		}
	}

	public static function removeRootCatFromUrl($curUrl, $clangId) {
		global $REX;

		$newUrl = '';

		if ($REX['ADDON']['seo42']['settings']['hide_langslug'] == $clangId) {
			$pos = strpos($curUrl, '/');

			if ($pos !== false) {
				$newUrl = substr($curUrl, $pos + 1);
			}
		} else {
			$pos1 = strpos($curUrl, '/');
			$pos2 = strpos($curUrl, '/', $pos1 + 1);

			if ($pos2 !== false) {
				$langSlug = substr($curUrl, 0, $pos1 + 1);
				$restUrl = substr($curUrl, $pos2 + 1);
				$newUrl = $langSlug . $restUrl;
			}
		}
		
		return $newUrl;
	}

	public static function getHtmlFromMDFile($mdFile, $search = array(), $replace = array()) {
		global $REX;

		$curLocale = strtolower($REX['LANG']);

		if ($curLocale == 'de_de') {
			$file = $REX['INCLUDE_PATH'] . '/addons/seo42/' . $mdFile;
		} else {
			$file = $REX['INCLUDE_PATH'] . '/addons/seo42/lang/' . $curLocale . '/' . $mdFile;
		}

		if (file_exists($file)) {
			$md = file_get_contents($file);
			$md = str_replace($search, $replace, $md);
			$md = self::makeHeadlinePretty($md);

			return Parsedown::instance()->parse($md);
		} else {
			return '[translate:' . $file . ']';
		}
	}

	public static function makeHeadlinePretty($md) {
		return str_replace('SEO42 - ', '', $md);
	}

	public static function strposa($haystack, $needle, $offset = 0) {
		if (!is_array($needle)) $needle = array($needle);

		foreach ($needle as $query) {
		    if (strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
		}

		return false;
	}

	public static function createDynFile($file) {
		$fileHandle = fopen($file, 'w');

		fwrite($fileHandle, "<?php\r\n");
		fwrite($fileHandle, "// --- DYN\r\n");
		fwrite($fileHandle, "// --- /DYN\r\n");

		fclose($fileHandle);
	}

	public static function getSettingsFile() {
		global $REX;

		if (isset($REX['WEBSITE_MANAGER']) && $REX['WEBSITE_MANAGER']->getCurrentWebsiteId() != $REX['WEBSITE_MANAGER']->getMasterWebsiteId()) {
			return SEO42_DATA_DIR . 'settings' . $REX['WEBSITE_MANAGER']->getCurrentWebsiteId() . '.inc.php';
		} else {
			return SEO42_DATA_DIR . 'settings.inc.php';
		}
	}

	public static function getRedirectsFile() {
		global $REX;

		if (isset($REX['WEBSITE_MANAGER']) && $REX['WEBSITE_MANAGER']->getCurrentWebsiteId() != $REX['WEBSITE_MANAGER']->getMasterWebsiteId()) {
			return SEO42_DATA_DIR . 'redirects' . $REX['WEBSITE_MANAGER']->getCurrentWebsiteId() . '.inc.php';
		} else {
			return SEO42_DATA_DIR . 'redirects.inc.php';
		}
	}

	public static function includeSettingsFile() {
		global $REX; // important for include

		$settingsFile = self::getSettingsFile();

		if (!file_exists($settingsFile)) {
			self::updateSettingsFile(false);
		}

		require_once($settingsFile);
	}

	public static function includeRedirectsFile() {
		global $REX; // important for include

		$redirectsFile = self::getRedirectsFile();

		if (!file_exists($redirectsFile)) {
			self::updateRedirectsFile(false);
		}

		require_once($redirectsFile);
	}

	public static function updateSettingsFile($showSuccessMsg = true) {
		global $REX, $I18N;

		$settingsFile = self::getSettingsFile();
		$msg = self::checkDirForFile($settingsFile);

		if ($msg != '') {
			if ($REX['REDAXO']) {
				echo rex_warning($msg);
			}
		} else {
			if (!file_exists($settingsFile)) {
				self::createDynFile($settingsFile);
			}

			// deprecated settings
			unset($REX['ADDON']['seo42']['settings']['cached_redirects']);
			unset($REX['ADDON']['seo42']['settings']['no_double_content_redirects_only_frontend']);

			$content = "<?php\n\n";
		
			foreach ((array) $REX['ADDON']['seo42']['settings'] as $key => $value) {
				$content .= "\$REX['ADDON']['seo42']['settings']['$key'] = " . var_export($value, true) . ";\n";
			}

			if (rex_put_file_contents($settingsFile, $content)) {
				if ($REX['REDAXO'] && $showSuccessMsg) {
					echo rex_info($I18N->msg('seo42_config_ok'));
				}
			} else {
				if ($REX['REDAXO']) {
					echo rex_warning($I18N->msg('seo42_config_error'));
				}
			}
		}
	}

	public static function updateRedirectsFile($showSuccessMsg = true) {
		global $REX, $I18N;

		$redirectsFile = self::getRedirectsFile();
		$msg = self::checkDirForFile($redirectsFile);

		if ($msg != '') {
			if ($REX['REDAXO']) {
				echo rex_warning($msg);
			}
		} else {
			if (!file_exists($redirectsFile)) {
				self::createDynFile($redirectsFile);
			}

			$sql = rex_sql::factory();
			//$sql->debugsql = true;
			$sql->setQuery('SELECT * FROM ' . $REX['TABLE_PREFIX'] . 'redirects');

			$REX['SEO42_CACHED_REDIRECTS'] = array();

			for ($i = 0; $i < $sql->getRows(); $i++) {
				$REX['SEO42_CACHED_REDIRECTS'][$sql->getValue('source_url')] = $sql->getValue('target_url');

				$sql->next();
			}

			$content = "<?php\n\n";
			$content .= "\$REX['SEO42_CACHED_REDIRECTS'] = " . var_export($REX['SEO42_CACHED_REDIRECTS'], true) . ";\n";

			if (rex_put_file_contents($redirectsFile, $content)) {
				if ($REX['REDAXO'] && $showSuccessMsg) {
					echo rex_info($I18N->msg('seo42_config_ok'));
				}
			} else {
				if ($REX['REDAXO']) {
					echo rex_warning($I18N->msg('seo42_config_error'));
				}
			}
		}
	}

	public static function redirect() {
		global $REX;

		if (isset($REX['SEO42_CACHED_REDIRECTS']) && count($REX['SEO42_CACHED_REDIRECTS']) > 0) {
			if (seo42::isSubDirInstall()) {
				// remove subdir from request uri
				$requestUri = self::trimSubDir($_SERVER['REQUEST_URI']);
			} else {
				$requestUri = $_SERVER['REQUEST_URI'];
			}
			
			$redirect = false;
			
			if (array_key_exists($requestUri, $REX['SEO42_CACHED_REDIRECTS'])) {
				$redirectUri = $REX['SEO42_CACHED_REDIRECTS'][$requestUri];
				$redirect = true;
				
			} elseif ($REX['ADDON']['seo42']['settings']['redirects_allow_regex']) {
				if ($redirectUri = self::regexRedirect($requestUri)) {			
					$redirect = true;
				}
			}

			if ($redirect) {
				if (seo42::isSubDirInstall()) {
					// add subdir to target url
					$targetUrl = '/' . seo42::getServerSubDir() . $redirectUri;
				} else {
					$targetUrl = $redirectUri;
				}

				if (strpos($targetUrl, 'http') === false) {
					$location = seo42::getServerUrl()  . ltrim($targetUrl, '/');
				} else {
					$location = $targetUrl;
				}
	
				header('HTTP/1.1 301 Moved Permanently');
			 	header('Location: ' . $location);

				exit;
			}
		}
	}
	
	public static function regexRedirect($requestUri) {
		global $REX;

		$regexArray = preg_grep('/\*/', array_keys($REX['SEO42_CACHED_REDIRECTS']));
		
		foreach($regexArray as $link) {
			// all * replace with "([\w.-]+)" regex
			$preg = str_replace('\*', '([\w.-]+)', preg_quote($link));
			
			if (preg_match('#'.$preg.'#', $requestUri, $matches)) {
				$url = $REX['SEO42_CACHED_REDIRECTS'][$link];
				
				// check if any variables in the Target-Url
				if (preg_match_all('/\{(\d)\}/', $url, $match)) {			
					
					foreach($match[0] as $key => $value) {						
						$url = str_replace($value, $matches[$match[1][$key]], $url);						
					}
					
				}
				
				return $url;
				
			}
		}
	}

	public static function trimSubDir($string) {
		return '/' . substr($string, strlen('/' . seo42::getServerSubDir()));
	}

	public static function requestUriFix() { // for iis only
		if (!isset($_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

			if (isset($_SERVER['QUERY_STRING'])) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
	}

	public static function getInheritedClang($clang) {
		global $REX;

		if (isset($REX['ADDON']['seo42']['settings']['lang'][$clang]['rewrite_mode']) && isset($REX['ADDON']['seo42']['settings']['lang'][$clang]['inherit_from_clang']) && $REX['ADDON']['seo42']['settings']['lang'][$clang]['rewrite_mode'] == SEO42_REWRITEMODE_INHERIT) {
			return $REX['ADDON']['seo42']['settings']['lang'][$clang]['inherit_from_clang'];
		} else {
			return $clang;
		}
	}

	public static function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);

		if ($pos !== false) {
		    $subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	public static function str_replace_last($search, $replace, $subject) {
		$pos = strrpos($subject, $search);

		if ($pos !== false) {
		    $subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	public static function getCustomUrl($urlWithoutSlash) {
		return '/' . $urlWithoutSlash;
	}

	public static function hasHtaccessSubDirRewriteBase() {
		global $REX;

		$rewriteBaseWithoutSubDir = 'RewriteBase /';
		$rewriteBaseStartString = 'RewriteBase';
		$htaccessRoot = $REX['FRONTEND_PATH'] . '/.htaccess';

		if (file_exists($htaccessRoot)) {
			$line = self::getLineWithString($htaccessRoot, $rewriteBaseStartString);

			if ($line != -1) {
				$htaccessRewriteBase = trim($line, " \t\r\n");
				$commentPos = strpos($htaccessRewriteBase, '#');

				if ($commentPos === false && $rewriteBaseWithoutSubDir != $htaccessRewriteBase) {
					return true;
				}
			}
		}

		return false;
	}

	public static function getLineWithString($fileName, $str) {
		$lines = file($fileName);

		foreach ($lines as $lineNumber => $line) {
		    if (strpos($line, $str) !== false) {
		        return $line;
		    }
		}

		return -1;
	}

	public static function getLangSettingsMsg() {
		global $REX, $I18N;

		if (!isset($REX['ADDON']['seo42']['settings']['lang']) || seo42::getLangCount() != count($REX['ADDON']['seo42']['settings']['lang'])) {
			$icon = '<span title="' . $I18N->msg('seo42_setup_langcount_error') . '" class="seo42-tooltip status exclamation">&nbsp;</span>';
		} else {
			$icon = '';
		}

		return '<span class="rex-form-read" id="lang_hint">' . $I18N->msg('seo42_setup_lang_settings_hint') . '</span>' . $icon;
	}

	public static function emptySEODataAfterClangAdded($params) {
		global $REX;

		$newClangId = $params['id'];
		
		$sql = rex_sql::factory();
		//$sql->debugsql = true;
		$sql->setQuery('UPDATE ' . $REX['TABLE_PREFIX'] . 'article SET seo_title = "", seo_description = "", seo_keywords = "", seo_custom_url = "", seo_canonical_url = "", seo_noindex = "", seo_ignore_prefix = "" WHERE clang = ' . $newClangId);
	}

	public static function parseInternalUrl($url) {
		global $REX;

		$sanitizedUrl = ltrim($url, './');
		$sanitizedUrlParts = explode('/', $sanitizedUrl);

		for ($i = 0; $i < count($sanitizedUrlParts); $i++) {
			$sanitizedUrlParts[$i] = seo42_parse_article_name($sanitizedUrlParts[$i], $REX['ARTICLE_ID'], $REX['CUR_CLANG']);
		}

		$sanitizedUrl = implode('/', $sanitizedUrlParts);
		$sanitizedUrl = strtolower($sanitizedUrl);
		$sanitizedUrl = str_replace('-htm', '.htm', $sanitizedUrl);

		return $sanitizedUrl;
	}

	public static function sendHeadersForArticleOnly() {
		global $REX;

		if ($REX['ADDON']['seo42']['settings']['send_header_x_ua_compatible']) {
			header('X-UA-Compatible: IE=Edge');
		}
	}

	public static function addRemoveRootCatUrlType($params) {
		global $REX;

		self::addUrlType(6, $REX['ADDON']['seo42']['settings']['remove_root_cats_for_categories'], $params);
	}

	public static function addNoUrlType($params) {
		global $REX;

		self::addUrlType(5, $REX['ADDON']['seo42']['settings']['no_url_for_categories'], $params);
	}

	public static function addUrlType($typeId, $execludeIds, $params) {
		global $REX;

		if (isset($params['category_id'])) {
			// category with startarticle created
			$curCatId = $params['category_id'];
		} else {
			// normal article created
			$curCatId = $params['re_id'];
		}

		if (in_array($curCatId, $execludeIds)) {
			$sql = rex_sql::factory();
			//$sql->debugsql = 1;
			$sql->setTable($REX['TABLE_PREFIX'] . "article");
			$sql->setWhere("id=" . $params['id']);

			$sql->setValue('seo_custom_url', '{"url_type":' . $typeId . ',"url_clone":false}');
			$sql->setValue('updatedate',  time());

			// do db update
			$sql->update();
		}
	}

	public static function checkDir($dir) {
		global $REX, $I18N;

		$path = $dir;

		if (!@is_dir($path)) {
			@mkdir($path, $REX['DIRPERM'], true);
		}

		if (!@is_dir($path)) {
			if ($REX['REDAXO']) {
				return $I18N->msg('seo42_install_make_dir', $dir);
			}
		} elseif (!@is_writable($path . '/.')) {
			if ($REX['REDAXO']) {
				return $I18N->msg('seo42_install_perm_dir', $dir);
			}
		}
		
		return '';
	}

	public static function checkDirForFile($fileWithPath) {
		$pathInfo = pathinfo($fileWithPath);

		return self::checkDir($pathInfo['dirname']);
	}

	public static function convertVarType($originalValue, $newValue) {
		switch (gettype($originalValue)) {
			case 'string':
				return trim($newValue);
				break;
			case 'integer':
				return intval($newValue);
				break;
			case 'boolean':
				return (bool) $newValue;
				break;
			case 'array':
				if ($newValue == '') {
					return array();
				} else {
					return explode(SEO42_ARRAY_DELIMITER, $newValue);
				}
				break;
			default:
				return $newValue;
				
		}
	}

	public static function noDoubleContentRedirect() {
		global $REX;

		if ($REX['ADDON']['seo42']['settings']['no_double_content_redirects'] == SEO42_NO_DOUBLE_CONTENT_REDIRECT_NONE) {
			// do nothing
			return;
		} elseif ($REX['ADDON']['seo42']['settings']['no_double_content_redirects_availability'] == SEO42_NO_DOUBLE_CONTENT_REDIRECT_AVAILABILITY_FRONTEND && $REX['REDAXO']) {
			// do nothing
			return;
		} elseif (isset($REX['SETUP']) && $REX['SETUP']) {
			// do nothing
			return;
		} else {
			// todo: here now seo42 methods can be used!
			$urlParts = parse_url($REX['SERVER']);

			if (isset($urlParts['scheme'])) {
				$protocol = $urlParts['scheme'];
			} else {
				$protocol = 'http';
			}

			if (isset($urlParts['host'])) {
				$server = $urlParts['host'];
			} else {
				$server = $REX['SERVER'];
			}

			$location = '';
			$serverHost = self::getServerHost();
			$requestUri = $_SERVER['REQUEST_URI'];

			// check for possible protocol only redirect
			if (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] != $protocol) {
				$location = $protocol . '://' . $serverHost . $requestUri;
			}

			switch ($REX['ADDON']['seo42']['settings']['no_double_content_redirects']) {
				case SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONE_DOMAIN_ONLY:
					// one domain only (when website manager ist installed this redirect is not allowed)
					if ($serverHost != $server) {
						// don't redirect if server url is empty, or default value or not full url
						if (self::isWebsiteUrlValid(seo42::getServerUrl())) {
							$location = $protocol . '://' . $server . $requestUri;
						}
					}

					break;
				case SEO42_NO_DOUBLE_CONTENT_REDIRECT_NON_WWW_TO_WWW:
					// non-www to www
					if (preg_match('/^[^.]+\.[^.]+$/', $serverHost, $hits)) {
						$location = $protocol . '://www.' . $hits[0] . $requestUri;
					}

					break;
				case SEO42_NO_DOUBLE_CONTENT_REDIRECT_WWW_TO_NON_WWW:
					// www to non-www
					if (preg_match('/^www\.(.*)$/', $serverHost, $hits)) {
						$location = $protocol . '://' . substr($hits[0], 4) . $requestUri;
					}

					break;
				case SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONLY_HTTPS:
					// https only
					$urlParts = parse_url($serverHost);

					if (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'http') {
						$location = 'https://' . $serverHost . $requestUri;
					}

					break;
			}

			if ($location != '') {
				header('HTTP/1.1 301 Moved Permanently');
			 	header('Location: ' . $location);

				exit;
			}
		}
	}

	public static function getServerHost() {
		// return $_SERVER['SERVER_NAME'];
		return $_SERVER['HTTP_HOST']; 
	}

	public static function implodeArray($array) {
		return implode(SEO42_ARRAY_DELIMITER, $array); 
	}

	public static function startsWith($haystack, $needle) {
		return $needle === "" || strpos($haystack, $needle) === 0;
	}

	public static function endsWith($haystack, $needle) {
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}

	public static function isWebsiteUrlValid($url) {
		if ($url != '' && $url != 'www.redaxo.org' && self::startsWith($url, 'http') && self::endsWith($url, '/')) {
			return true;
		} else {
			return false;
		}
	}
}
