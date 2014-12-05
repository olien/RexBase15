<?php

// register addon
$REX['ADDON']['rxid']['seo42'] = '0';
$REX['ADDON']['name']['seo42'] = 'SEO42';
$REX['ADDON']['version']['seo42'] = '4.1.0';
$REX['ADDON']['author']['seo42'] = 'Markus Staab, Wolfgang Huttegger, Dave Holloway, Jan Kristinus, jdlx, RexDude';
$REX['ADDON']['supportpage']['seo42'] = 'forum.redaxo.de';
$REX['ADDON']['perm']['seo42'] = 'seo42[]';

// permissions
$REX['PERM'][] = 'seo42[]';
$REX['PERM'][] = 'seo42[tools_only]';
$REX['PERM'][] = 'seo42[redirects_only]';
$REX['EXTPERM'][] = 'seo42[seo_default]';
$REX['EXTPERM'][] = 'seo42[seo_extended]';
$REX['EXTPERM'][] = 'seo42[url_default]';

// append lang file
if ($REX['REDAXO']) {
	$I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/seo42/lang/');
}

// includes
require_once($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.res42.inc.php');
require_once($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.nav42.inc.php');
require_once($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.seo42.inc.php');
require_once($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.seo42_utils.inc.php');

// consts
define('SEO42_ARRAY_DELIMITER', ',');
define('SEO42_DATA_DIR', $REX['INCLUDE_PATH'] . '/data/addons/seo42/');
define('SEO42_BACKUP_DIR', $REX['INCLUDE_PATH'] . '/data/addons/seo42/backup/');
define('SEO42_PATHLIST', $REX['GENERATED_PATH'] . '/files/seo42_pathlist.php');

define('SEO42_URL_TYPE_DEFAULT', 0); 
define('SEO42_URL_TYPE_INTERN_REPLACE_CLANG', 1); 
define('SEO42_URL_TYPE_USERDEF_INTERN', 2);
define('SEO42_URL_TYPE_MEDIAPOOL', 3);
define('SEO42_URL_TYPE_LANGSWITCH', 4); // should also be handled by navigation output.
define('SEO42_URL_TYPE_NONE', 5); // should also be handled by navigation output.
define('SEO42_URL_TYPE_REMOVE_ROOT_CAT', 6);
define('SEO42_URL_TYPE_INTERN_REPLACE', 7);
define('SEO42_URL_TYPE_CALL_FUNC', 8); // should also be handled by navigation output.
define('SEO42_URL_TYPE_USERDEF_EXTERN', 9);

define('SEO42_REWRITEMODE_SPECIAL_CHARS', 0);
define('SEO42_REWRITEMODE_URLENCODE', 1);
define('SEO42_REWRITEMODE_INHERIT', 2);

define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_NONE', 0);
define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONE_DOMAIN_ONLY', 1);
define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_NON_WWW_TO_WWW', 2);
define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_WWW_TO_NON_WWW', 3);
define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONLY_HTTPS', 4);

define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_AVAILABILITY_FRONTEND_BACKEND', 0);
define('SEO42_NO_DOUBLE_CONTENT_REDIRECT_AVAILABILITY_FRONTEND', 1);

define('SEO42_AUTO_REDIRECT_NONE', 0);
define('SEO42_AUTO_REDIRECT_ARTICLE_ID', 1);
define('SEO42_AUTO_REDIRECT_URL_REWRITE', 2);
define('SEO42_AUTO_REDIRECT_URL_REWRITE_R3', 3);

// default settings (user settings are saved in data dir!)
$REX['ADDON']['seo42']['settings'] = array(
	'rewriter' => true,
	'url_ending' => '.html',
	'hide_langslug' => 0,
	'homeurl' => 2,
	'homelang' => 0,
	'no_double_content_redirects' => SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONE_DOMAIN_ONLY,
	'no_double_content_redirects_availability' => SEO42_NO_DOUBLE_CONTENT_REDIRECT_AVAILABILITY_FRONTEND,
	'auto_redirects' => SEO42_AUTO_REDIRECT_NONE,
	'smart_redirects' => true,
	'redirects_allow_regex' => false,
	'css_dir' => '/resources/css/',
	'js_dir' => '/resources/js/',
	'images_dir' => '/resources/images/',
	'icons_dir' => '/resources/icons/',
	'seo_friendly_image_manager_urls' => true,
	'full_urls' => false,
	'allow_article_id' => false,
	'ignore_root_cats' => false,
	'url_whitespace_replace' => '-',
	'url_start' => '/',
	'url_start_subdir' => './',
	'remove_root_cats_for_categories' => array(),
	'no_url_for_categories' => array(),
	'include_query_params' => true,
	'ignore_query_params' => array(),
	'force_download_for_filetypes' => array(),
	'send_header_x_ua_compatible' => true,
	'fix_image_manager_cache_control_header' => false,
	'static_sitemap_priority' => true,
	'no_robots_txt_auto_disallow' => true,
	'robots' => '',
	'google_site_verification_filename' => '',
	'robots_follow_flag' => 'follow',
	'robots_archive_flag' => 'noarchive',
	'title_delimiter' => '-',
	'seopage' => true,
	'title_preview' => true,
	'no_prefix_checkbox' => false,
	'custom_canonical_url' => false,
	'noindex_checkbox' => false,
	'urlpage' => true,
	'all_url_types' => true,
	'pagerank_checker' => true,
	'redirects' => true,
	'one_page_mode' => false,
	'pagerank_checker_unlock' => false,
	'global_special_chars' => '',
	'global_special_chars_rewrite' => '',
	'urlencode_whitespace_replace' => '_',
	'urlencode_lowercase' => false,
	'lang' => array(
		0 => array(
			'code' => 'de',
			'original_name' => 'deutsch',
			'rewrite_mode' => SEO42_REWRITEMODE_SPECIAL_CHARS,
			'special_chars' => 'Ä|ä|Ö|ö|Ü|ü|ß|&',
			'special_chars_rewrite' => 'Ae|ae|Oe|oe|Ue|ue|ss|und',
			'inherit_from_clang' => 0
		)
	)
);

// overwrite default settings with user settings
seo42_utils::includeSettingsFile();

// include cached redirects
seo42_utils::includeRedirectsFile();

// pre init seo42 vars
seo42::init();

// fix for iis webserver: set request uri manually if not available
seo42_utils::requestUriFix();

// do redirects
seo42_utils::noDoubleContentRedirect();

if (!$REX['REDAXO']) {
	seo42_utils::redirect();	
}

// init
if (!$REX['SETUP']) {
	// auto mod rewrite, but not for redaxo system page
	if ($REX['REDAXO'] && rex_request('page') == 'specials') {
		// don't touch mod rewrite var
	} else {
		if ($REX['ADDON']['seo42']['settings']['rewriter']) {
			$REX['MOD_REWRITE'] = true;
		} else {
			$REX['MOD_REWRITE'] = false;
		}
	}

	// init seo42
	rex_register_extension('ADDONS_INCLUDED', 'seo42_utils::init', '', REX_EXTENSION_EARLY);

	// init res42
	rex_register_extension('ADDONS_INCLUDED', 'res42::init');

	// send additional headers if necessary
	rex_register_extension('OUTPUT_FILTER_CACHE', 'seo42_utils::sendHeaders');
}

if ($REX['REDAXO']) {
	// handels ajax request for google pagerank checker in tools section
	if ($REX['ADDON']['seo42']['settings']['pagerank_checker'] && isset($REX['USER']) && rex_request('function') == 'getpagerank') {
		require($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.google_pagerank_checker.inc.php');
		echo GooglePageRankChecker::getRank(rex_request('url'));
		exit;
	}

	// subpages
	if (isset($REX['USER']) && !$REX['USER']->isAdmin() && ($REX['USER']->hasPerm('seo42[tools_only]') || $REX['USER']->hasPerm('seo42[redirects_only]'))) {
		// add subpages for non admin users
		if ($REX['USER']->hasPerm('seo42[tools_only]')) {
			// add tools page only
			$REX['ADDON']['seo42']['SUBPAGES'][] = array('tools', $I18N->msg('seo42_tools'));
		}

		if ($REX['USER']->hasPerm('seo42[redirects_only]')) {
			// add redirects page only
			$REX['ADDON']['seo42']['SUBPAGES'][] = array('redirects', $I18N->msg('seo42_redirects'));
		}

		$REX['ADDON']['seo42']['SUBPAGES'][0][0] = '';
	} else {
		// add subpages
		$REX['ADDON']['seo42']['SUBPAGES'] = array(
			array('', $I18N->msg('seo42_start')),
			array('tools', $I18N->msg('seo42_tools'))
		);

		if ($REX['ADDON']['seo42']['settings']['redirects']) {
			array_push($REX['ADDON']['seo42']['SUBPAGES'], 
				array('redirects', $I18N->msg('seo42_redirects'))
			);
		}

		// plugins (will be autoloaded incl. language file)
		$plugins = OOPlugin::getAvailablePlugins('seo42');

		for ($i = 0; $i < count($plugins); $i++) {
            if (file_exists($REX['INCLUDE_PATH'] . '/addons/seo42/plugins/' . $plugins[$i] . '/pages/' . $plugins[$i]) ) {
				$I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/seo42/plugins/' . $plugins[$i] . '/lang/'); // make msg for subpage available at this point 
				array_push($REX['ADDON']['seo42']['SUBPAGES'], array($plugins[$i], $I18N->msg('seo42_' . $plugins[$i])));
            }
		}

		// rest of sub pages
		array_push($REX['ADDON']['seo42']['SUBPAGES'], 
			array('settings', $I18N->msg('seo42_settings')),
			array('setup', $I18N->msg('seo42_setup')),
			array('help', $I18N->msg('seo42_help'))
		);
	}

	// add css/js files to page header
	if (rex_request('page') == 'seo42') {
		rex_register_extension('PAGE_HEADER', 'seo42_utils::appendToPageHeader');
	}

	// check if seopage/urlpage needs to be enabled
	if (!$REX['ADDON']['seo42']['settings']['one_page_mode'] || ($REX['ADDON']['seo42']['settings']['one_page_mode'] && $REX['ARTICLE_ID'] == $REX['START_ARTICLE_ID'])) {
		if (isset($REX['USER']) && ($REX['USER']->isAdmin())) {
			// admins get everything :)

			if (!$REX['ADDON']['seo42']['settings']['one_page_mode']) { // url page not needed when in one page mode
				seo42_utils::enableURLPage(); // injection order is important
			}

			seo42_utils::enableSEOPage();
		} else {
			if (isset($REX['USER']) && $REX['USER']->hasPerm('seo42[url_default]')) {
				seo42_utils::enableURLPage();
			}

			if (isset($REX['USER']) && ($REX['USER']->hasPerm('seo42[seo_default]') || $REX['USER']->hasPerm('seo42[seo_extended]') || $REX['USER']->hasPerm('editContentOnly[]'))) {
				seo42_utils::enableSEOPage();
			}
		}
	}

	// fix article preview link as othewise not url types will show correct preview url
	rex_register_extension('PAGE_CONTENT_MENU', 'seo42_utils::fixArticlePreviewLink');

	// check for missing db fields after db import
	if (!$REX['SETUP']) {
		rex_register_extension('A1_AFTER_DB_IMPORT', 'seo42_utils::afterDBImport');
	}

	// if clang is added/deleted show message to the user that he should check his lang settings
	rex_register_extension('CLANG_ADDED', 'seo42_utils::showMsgAfterClangModified');
	rex_register_extension('CLANG_DELETED', 'seo42_utils::showMsgAfterClangModified');
	rex_register_extension('CLANG_UPDATED', 'seo42_utils::showMsgAfterClangModified');

	// don't clone seo data when new clang is added
	rex_register_extension('CLANG_ADDED', 'seo42_utils::emptySEODataAfterClangAdded');

	// inform user when article hat different url type
	if (rex_request('page') == 'content' && rex_request('mode') == 'edit' && rex_request('function') == '') {
		rex_register_extension('PAGE_CONTENT_OUTPUT', 'seo42_utils::showUrlTypeMsg');
	}

	// handle remove_root_cats_for_categories option
	if (count($REX['ADDON']['seo42']['settings']['remove_root_cats_for_categories']) > 0) {
		rex_register_extension('ART_ADDED', 'seo42_utils::addRemoveRootCatUrlType');
		rex_register_extension('CAT_ADDED', 'seo42_utils::addRemoveRootCatUrlType');
	}

	// handle no_url_for_categories option
	if (count($REX['ADDON']['seo42']['settings']['no_url_for_categories']) > 0) {
		rex_register_extension('ART_ADDED', 'seo42_utils::addNoUrlType');
		rex_register_extension('CAT_ADDED', 'seo42_utils::addNoUrlType');
	}
} else {
	// send additional headers for article if necessary
	rex_register_extension('OUTPUT_FILTER_CACHE', 'seo42_utils::sendHeadersForArticleOnly');

	// fix headers for image manager images if necessary
	if ($REX['ADDON']['seo42']['settings']['fix_image_manager_cache_control_header'] && (isset($_GET['rex_img_type']))) {
		header('Cache-Control: max-age=604800'); // 1 week
		header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 604800));
	}
}

