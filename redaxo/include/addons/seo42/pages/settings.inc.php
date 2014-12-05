<?php
require_once($REX['INCLUDE_PATH'] . '/addons/seo42/langpresets.inc.php');

$myself = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

// save settings
if ($func == 'update') {
	$settings = (array) rex_post('settings', 'array', array());
	$langSettings = (array) rex_post('lang_settings', 'array', array());
	
	// type conversion normal settings
	foreach ($REX['ADDON']['seo42']['settings'] as $key => $value) {
		if ($key != 'lang') { // lang is extra, see below
			if (isset($settings[$key])) {
				$settings[$key] = seo42_utils::convertVarType($value, $settings[$key]);
			}
		}
	}

	// replace settings
	$REX['ADDON']['seo42']['settings'] = array_merge((array) $REX['ADDON']['seo42']['settings'], $settings);

	// type conversion lang settings
	foreach ($REX['CLANG'] as $clangId => $clangName) {
		if (isset($langSettings[$clangId])) {
			foreach ($langSettings[$clangId] as $key => $value) {
				if (isset($langSettings[$clangId][$key]) && isset($REX['ADDON']['seo42']['settings']['lang'][0][$key])) {
					$langSettings[$clangId][$key] = seo42_utils::convertVarType($REX['ADDON']['seo42']['settings']['lang'][0][$key], $langSettings[$clangId][$key]);
				}
			}
		}
	}

	// replace lang settings
	unset($REX['ADDON']['seo42']['settings']['lang']);
	$REX['ADDON']['seo42']['settings']['lang'] = $langSettings;

	// update settings file
	seo42_utils::updateSettingsFile();

	// update pathlist
	seo42_generate_pathlist('');
}

// url ending select box
$url_ending_select = new rex_select();
$url_ending_select->setSize(1);
$url_ending_select->setName('settings[url_ending]');
$url_ending_select->addOption('.html','.html');
$url_ending_select->addOption('/','/');
$url_ending_select->addOption($I18N->msg('seo42_settings_url_ending_without'), '');
$url_ending_select->setAttribute('style','width:70px;');
$url_ending_select->setSelected($REX['ADDON'][$myself]['settings']['url_ending']);

// home url select box
$ooa = OOArticle::getArticleById($REX['START_ARTICLE_ID']);

if ($ooa) {
  $homename = strtolower($ooa->getName());
} else {
  $homename = 'Startartikel';
}

unset($ooa);

$homeurl_select = new rex_select();
$homeurl_select->setSize(1);
$homeurl_select->setName('settings[homeurl]');
$homeurl_select->addOption(seo42::getServerUrl().$homename.'.html',0);
$homeurl_select->addOption(seo42::getServerUrl(),1);
$homeurl_select->addOption(seo42::getServerUrl().'lang-slug/',2);
$homeurl_select->setAttribute('style','width:250px;');
$homeurl_select->setSelected($REX['ADDON'][$myself]['settings']['homeurl']);

// lang slug select box
if (count($REX['CLANG']) > 1) {
  $hide_langslug_select = new rex_select();
  $hide_langslug_select->setSize(1);
  $hide_langslug_select->setName('settings[hide_langslug]');
  $hide_langslug_select->addOption($I18N->msg('seo42_settings_langslug_all'),-1);

  foreach($REX['CLANG'] as $id => $str) {
    $hide_langslug_select->addOption($I18N->msg('seo42_settings_langslug_noslug') . ' '.$str,$id);
  }

  $hide_langslug_select->setSelected($REX['ADDON'][$myself]['settings']['hide_langslug']);
  $hide_langslug_select = '
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="hide_langslug">' . $I18N->msg('seo42_settings_langslug') . '</label>
                '.$hide_langslug_select->get().'
                </p>
          </div><!-- /rex-form-row -->';
} else {
  $hide_langslug_select = '';
}

// home lang select box
if (count($REX['CLANG']) > 1) {
  $homelang_select = new rex_select();
  $homelang_select->setSize(1);
  $homelang_select->setName('settings[homelang]');

  foreach($REX['CLANG'] as $id => $str) {
    $homelang_select->addOption($str,$id);
  }

  $homelang_select->setSelected($REX['ADDON'][$myself]['settings']['homelang']);
  $homelang_select->setAttribute('style','width:70px;margin-left:20px;');
  $homelang_box = '
              <span style="margin:0 4px 0 4px;display:inline-block;width:100px;text-align:right;">
                ' . $I18N->msg('seo42_settings_language') . '
              </span>
              '.$homelang_select->get().'
              ';
} else {
  $homelang_box = '';
}

$auto_redirects_select = new rex_select();
$auto_redirects_select->setSize(1);
$auto_redirects_select->setName('settings[auto_redirects]');
$auto_redirects_select->addOption($I18N->msg('seo42_settings_auto_redirects_0'), SEO42_AUTO_REDIRECT_NONE);
$auto_redirects_select->addOption($I18N->msg('seo42_settings_auto_redirects_1'), SEO42_AUTO_REDIRECT_ARTICLE_ID);
$auto_redirects_select->addOption($I18N->msg('seo42_settings_auto_redirects_2'), SEO42_AUTO_REDIRECT_URL_REWRITE);
$auto_redirects_select->addOption($I18N->msg('seo42_settings_auto_redirects_3'), SEO42_AUTO_REDIRECT_URL_REWRITE_R3);
$auto_redirects_select->setSelected($REX['ADDON'][$myself]['settings']['auto_redirects']);

if (seo42_utils::isWebsiteUrlValid(seo42::getServerUrl())) {
	$serverString = seo42::getServer();
} else {
	$serverString = $I18N->msg('seo42_settings_no_double_content_redirects_1_invalid');
}

$no_double_content_redirects_select = new rex_select();
$no_double_content_redirects_select->setSize(1);
$no_double_content_redirects_select->setName('settings[no_double_content_redirects]');
$no_double_content_redirects_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_0'), SEO42_NO_DOUBLE_CONTENT_REDIRECT_NONE);
$no_double_content_redirects_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_1') . ' [' . $serverString . ']', SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONE_DOMAIN_ONLY);
$no_double_content_redirects_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_2'), SEO42_NO_DOUBLE_CONTENT_REDIRECT_NON_WWW_TO_WWW);
$no_double_content_redirects_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_3'), SEO42_NO_DOUBLE_CONTENT_REDIRECT_WWW_TO_NON_WWW);
$no_double_content_redirects_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_4'), SEO42_NO_DOUBLE_CONTENT_REDIRECT_ONLY_HTTPS);
$no_double_content_redirects_select->setSelected($REX['ADDON'][$myself]['settings']['no_double_content_redirects']);

$no_double_content_redirects_availability_select = new rex_select();
$no_double_content_redirects_availability_select->setSize(1);
$no_double_content_redirects_availability_select->setName('settings[no_double_content_redirects_availability]');
$no_double_content_redirects_availability_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_availability_1'), 1);
$no_double_content_redirects_availability_select->addOption($I18N->msg('seo42_settings_no_double_content_redirects_availability_0'), 0);
$no_double_content_redirects_availability_select->setSelected($REX['ADDON'][$myself]['settings']['no_double_content_redirects_availability']);

?>

<div class="rex-addon-output">
  <div class="rex-form">

  <form action="index.php" method="post">
    <input type="hidden" name="page" value="seo42" />
    <input type="hidden" name="subpage" value="<?php echo $subpage; ?>" />
    <input type="hidden" name="func" value="update" />

      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_main_section'); ?></legend>
        <div class="rex-form-wrapper slide">

            <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="rewriter"><?php echo $I18N->msg('seo42_settings_rewriter'); ?></label>
					<input type="hidden" name="settings[rewriter]" value="0" />
					<input type="checkbox" name="settings[rewriter]" id="rewriter" value="1" <?php if ($REX['ADDON']['seo42']['settings']['rewriter']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="url_ending"><?php echo $I18N->msg('seo42_settings_url_ending'); ?></label>
               <?php echo $url_ending_select->get(); ?>
            </p>
          </div>

          <?php echo $hide_langslug_select; ?>

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="homeurl"><?php echo $I18N->msg('seo42_settings_startpage'); ?></label>
                <?php echo $homeurl_select->get(); ?>
                <?php echo $homelang_box; ?>
            </p>
          </div>

		</div>
       </fieldset>

    <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_redirects_section'); ?></legend>
        <div class="rex-form-wrapper slide">

       <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="no_double_content_redirects"><?php echo $I18N->msg('seo42_settings_no_double_content_redirects'); ?></label>
               <?php echo $no_double_content_redirects_select->get(); ?>
            </p>
          </div>

          <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="no_double_content_redirects_availability"><?php echo $I18N->msg('seo42_settings_no_double_content_redirects_availability'); ?></label>
					<?php echo $no_double_content_redirects_availability_select->get(); ?>
				</p>
			</div>

		 <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="auto_redirects"><?php echo $I18N->msg('seo42_settings_auto_redirects'); ?></label>
               <?php echo $auto_redirects_select->get(); ?>
            </p>
          </div>
 
          <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="smart_redirects"><?php echo $I18N->msg('seo42_settings_smart_redirects'); ?></label>
					<input type="hidden" name="settings[smart_redirects]" value="0" />
					<input type="checkbox" name="settings[smart_redirects]" id="smart_redirects" value="1" <?php if ($REX['ADDON']['seo42']['settings']['smart_redirects']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

          <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="redirects_allow_regex"><?php echo $I18N->msg('seo42_settings_redirects_allow_regex'); ?></label>
					<input type="hidden" name="settings[redirects_allow_regex]" value="0" />
					<input type="checkbox" name="settings[redirects_allow_regex]" id="redirects_allow_regex" value="1" <?php if ($REX['ADDON']['seo42']['settings']['redirects_allow_regex']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

        </div>
    </fieldset>



      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_lang_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="global_special_chars"><?php echo $I18N->msg('seo42_settings_global_special_chars'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['global_special_chars']; ?>" name="settings[global_special_chars]" class="rex-form-text pipes" id="global_special_chars">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="global_special_chars_rewrite"><?php echo $I18N->msg('seo42_settings_global_special_chars_rewrite'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['global_special_chars_rewrite']; ?>" name="settings[global_special_chars_rewrite]" class="rex-form-text pipes" id="global_special_chars_rewrite">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="urlencode_whitespace_replace"><?php echo $I18N->msg('seo42_settings_urlencode_whitespace_replace'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace']; ?>" name="settings[urlencode_whitespace_replace]" class="rex-form-text" id="urlencode_whitespace_replace">
				</p>
			</div>


			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="urlencode_lowercase"><?php echo $I18N->msg('seo42_settings_urlencode_lowercase'); ?></label>
					<input type="hidden" name="settings[urlencode_lowercase]" value="0" />
					<input type="checkbox" name="settings[urlencode_lowercase]" id="urlencode_lowercase" value="1" <?php if ($REX['ADDON']['seo42']['settings']['urlencode_lowercase']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

        </div>
    </fieldset>


			<?php

			foreach ($REX['CLANG'] as $clangId => $clangName) {
				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['code'])) {
					$code = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['code'];
				} else {
					$code = '';
				}

				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['original_name'])) {
					$originalName = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['original_name'];
				} else {
					$originalName = '';
				}

				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['rewrite_mode'])) {
					$rewriteMode = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['rewrite_mode'];
				} else {
					$rewriteMode = SEO42_REWRITEMODE_SPECIAL_CHARS;
				}

				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['special_chars'])) {
					$specialChars = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['special_chars'];
				} else {
					$specialChars = '';
				}

				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['special_chars_rewrite'])) {
					$specialCharsRewrite = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['special_chars_rewrite'];
				} else {
					$specialCharsRewrite = '';
				}

				if (isset($REX['ADDON']['seo42']['settings']['lang'][$clangId]['inherit_from_clang'])) {
					$inheritFromClang = $REX['ADDON']['seo42']['settings']['lang'][$clangId]['inherit_from_clang'];
				} else {
					$inheritFromClang = 0;
				}
			?>

			<fieldset class="rex-form-col-1">
			<legend><?php echo $I18N->msg('seo42_settings_langname_section');?> <?php echo $clangName; ?></legend>
			<div class="rex-form-wrapper slide">

			<a href="#" class="preset-button" data-vertical-offset="-14" data-dropdown="#dropdown-<?php echo $clangId; ?>"><?php echo $I18N->msg('seo42_settings_lang_presets'); ?></a>

			<div id="dropdown-<?php echo $clangId; ?>" class="dropdown dropdown-relative">
				<ul class="dropdown-menu" data-clang="<?php echo $clangId; ?>">
					<?php
					foreach ($REX['SEO42_LANG_PRESETS'] as $key => $value) {
						echo '<li data-langpreset-id="' . $key . '"><a href="#' . $key . '">' . $value['original_name'] . '</a></li>';
					}
					?>
				</ul>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="lang_settings_<?php echo $clangId; ?>_code"><?php echo $I18N->msg('seo42_settings_lang_code'); ?></label>
					<input type="text" value="<?php echo $code; ?>" name="lang_settings[<?php echo $clangId; ?>][code]" class="rex-form-text" id="lang_settings_<?php echo $clangId; ?>_code">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="lang_settings_<?php echo $clangId; ?>_original_name"><?php echo $I18N->msg('seo42_settings_lang_original_name'); ?></label>
					<input type="text" value="<?php echo $originalName; ?>" name="lang_settings[<?php echo $clangId; ?>][original_name]" class="rex-form-text" id="lang_settings_<?php echo $clangId; ?>_original_name">
				</p>
			</div>

		
			<?php
			$rewrite_mode_select = new rex_select();
			$rewrite_mode_select->setSize(1);
			$rewrite_mode_select->setName('lang_settings[' . $clangId . '][rewrite_mode]');
			$rewrite_mode_select->setAttribute('id', 'lang_settings_' . $clangId . '_rewrite_mode');
			$rewrite_mode_select->setAttribute('class', 'rewrite_mode');
			$rewrite_mode_select->setAttribute('data-clang', $clangId);
			$rewrite_mode_select->addOption($I18N->msg('seo42_settings_lang_rewrite_mode_0'), SEO42_REWRITEMODE_SPECIAL_CHARS);
			$rewrite_mode_select->addOption($I18N->msg('seo42_settings_lang_rewrite_mode_1'), SEO42_REWRITEMODE_URLENCODE);
			$rewrite_mode_select->addOption($I18N->msg('seo42_settings_lang_rewrite_mode_2'), SEO42_REWRITEMODE_INHERIT);
			$rewrite_mode_select->setSelected($rewriteMode);
			?>

	     <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="lang_settings_<?php echo $clangId; ?>_rewrite_mode"><?php echo $I18N->msg('seo42_settings_lang_rewrite_mode'); ?></label>
               <?php echo $rewrite_mode_select->get(); ?>
            </p>
          </div>

			<div class="rex-form-row rex-form-element-v1" id="lang_settings_<?php echo $clangId; ?>_special_chars_row">
				<p class="rex-form-text">
					<label for="lang_settings_<?php echo $clangId; ?>_special_chars"><?php echo $I18N->msg('seo42_settings_lang_special_chars'); ?></label>
					<input type="text" value="<?php echo $specialChars; ?>" name="lang_settings[<?php echo $clangId; ?>][special_chars]" class="rex-form-text pipes" id="lang_settings_<?php echo $clangId; ?>_special_chars">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1" id="lang_settings_<?php echo $clangId; ?>_special_chars_rewrite_row">
				<p class="rex-form-text">
					<label for="lang_settings_<?php echo $clangId; ?>_special_chars_rewrite"><?php echo $I18N->msg('seo42_settings_lang_special_chars_rewrite'); ?></label>
					<input type="text" value="<?php echo $specialCharsRewrite; ?>" name="lang_settings[<?php echo $clangId; ?>][special_chars_rewrite]" class="rex-form-text pipes" id="lang_settings_<?php echo $clangId; ?>_special_chars_rewrite">
				</p>
			</div>

			<?php
			$inherit_from_clang_select = new rex_select();
			$inherit_from_clang_select->setSize(1);
			$inherit_from_clang_select->setName('lang_settings[' . $clangId . '][inherit_from_clang]');
			$inherit_from_clang_select->setAttribute('id', 'lang_settings_' . $clangId . '_inherit_from_clang');

			foreach ($REX['CLANG'] as $clangIdTemp => $clangName) {
				if (count($REX['CLANG']) == 1 || $clangIdTemp != $clangId) {
					$inherit_from_clang_select->addOption($clangName, $clangIdTemp);
				}
			}

			$inherit_from_clang_select->setSelected($inheritFromClang);
			?>

	     <div class="rex-form-row" id="lang_settings_<?php echo $clangId; ?>_inherit_from_clang_row">
            <p class="rex-form-col-a rex-form-select">
              <label for="lang_settings_<?php echo $clangId; ?>_inherit_from_clang"><?php echo $I18N->msg('seo42_settings_lang_inherit_from_clang'); ?></label>
               <?php echo $inherit_from_clang_select->get(); ?>
            </p>
          </div>

		</div>
		</fieldset>


			<?php
			}

			?>


    <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_resource_section'); ?></legend>
        <div class="rex-form-wrapper slide">

          	<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="css_dir"><?php echo $I18N->msg('seo42_settings_css_dir'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['css_dir']; ?>" name="settings[css_dir]" class="rex-form-text" id="css_dir">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="js_dir"><?php echo $I18N->msg('seo42_settings_js_dir'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['js_dir']; ?>" name="settings[js_dir]" class="rex-form-text" id="js_dir">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="images_dir"><?php echo $I18N->msg('seo42_settings_images_dir'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['images_dir']; ?>" name="settings[images_dir]" class="rex-form-text" id="images_dir">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="icons_dir"><?php echo $I18N->msg('seo42_settings_icons_dir'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['icons_dir']; ?>" name="settings[icons_dir]" class="rex-form-text" id="icons_dir">
				</p>
			</div>

		</div>
       </fieldset>

      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_urls_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="seo_friendly_image_manager_urls"><?php echo $I18N->msg('seo42_settings_seo_friendly_image_manager_urls'); ?></label>
					<input type="hidden" name="settings[seo_friendly_image_manager_urls]" value="0" />
					<input type="checkbox" name="settings[seo_friendly_image_manager_urls]" id="seo_friendly_image_manager_urls" value="1" <?php if ($REX['ADDON']['seo42']['settings']['seo_friendly_image_manager_urls']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="full_urls"><?php echo $I18N->msg('seo42_settings_full_urls'); ?></label>
					<input type="hidden" name="settings[full_urls]" value="0" />
					<input type="checkbox" name="settings[full_urls]" id="full_urls" value="1" <?php if ($REX['ADDON']['seo42']['settings']['full_urls']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="allow_article_id"><?php echo $I18N->msg('seo42_settings_allow_article_id'); ?></label>
					<input type="hidden" name="settings[allow_article_id]" value="0" />
					<input type="checkbox" name="settings[allow_article_id]" id="allow_article_id" value="1" <?php if ($REX['ADDON']['seo42']['settings']['allow_article_id']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="ignore_root_cats"><?php echo $I18N->msg('seo42_settings_ignore_root_cats'); ?></label>
					<input type="hidden" name="settings[ignore_root_cats]" value="0" />
					<input type="checkbox" name="settings[ignore_root_cats]" id="ignore_root_cats" value="1" <?php if ($REX['ADDON']['seo42']['settings']['ignore_root_cats']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

            <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="url_whitespace_replace"><?php echo $I18N->msg('seo42_settings_url_whitespace_replace'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['url_whitespace_replace']; ?>" name="settings[url_whitespace_replace]" class="rex-form-text" id="url_whitespace_replace">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="url_start"><?php echo $I18N->msg('seo42_settings_url_start'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['url_start']; ?>" name="settings[url_start]" class="rex-form-text" id="url_start">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="url_start_subdir"><?php echo $I18N->msg('seo42_settings_url_start_subdir'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['url_start_subdir']; ?>" name="settings[url_start_subdir]" class="rex-form-text" id="url_start_subdir">
				</p>
			</div>

		</div>
       </fieldset>

      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_auto_url_types_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="remove_root_cats_for_categories"><?php echo $I18N->msg('seo42_settings_remove_root_cats_for_categories'); ?></label>
					<input type="text" value="<?php echo seo42_utils::implodeArray($REX['ADDON']['seo42']['settings']['remove_root_cats_for_categories']); ?>" name="settings[remove_root_cats_for_categories]" class="rex-form-text tags" id="remove_root_cats_for_categories">
				</p>
			</div>


			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="no_url_for_categories"><?php echo $I18N->msg('seo42_settings_no_url_for_categories'); ?></label>
					<input type="text" value="<?php echo seo42_utils::implodeArray($REX['ADDON']['seo42']['settings']['no_url_for_categories']); ?>" name="settings[no_url_for_categories]" class="rex-form-text tags" id="no_url_for_categories">
				</p>
			</div>


		</div>
       </fieldset>


		<fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_canonical_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="include_query_params"><?php echo $I18N->msg('seo42_settings_include_query_params'); ?></label>
					<input type="hidden" name="settings[include_query_params]" value="0" />
					<input type="checkbox" name="settings[include_query_params]" id="include_query_params" value="1" <?php if ($REX['ADDON']['seo42']['settings']['include_query_params']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="ignore_query_params"><?php echo $I18N->msg('seo42_settings_ignore_query_params'); ?></label>
					<input type="text" value="<?php echo seo42_utils::implodeArray($REX['ADDON']['seo42']['settings']['ignore_query_params']); ?>" name="settings[ignore_query_params]" class="rex-form-text tags" id="ignore_query_params">
				</p>
			</div>


		</div>
       </fieldset>



	<fieldset class="rex-form-col-1">
      <legend><?php echo $I18N->msg('seo42_settings_download_section'); ?></legend>
      <div class="rex-form-wrapper slide">


		<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="force_download_for_filetypes"><?php echo $I18N->msg('seo42_settings_force_download_for_filetypes'); ?></label>
					<input type="text" value="<?php echo seo42_utils::implodeArray($REX['ADDON']['seo42']['settings']['force_download_for_filetypes']); ?>" name="settings[force_download_for_filetypes]" class="rex-form-text tags" id="force_download_for_filetypes">
				</p>
			</div>

		</div>
       </fieldset>



      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_header_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="send_header_x_ua_compatible"><?php echo $I18N->msg('seo42_settings_send_header_x_ua_compatible'); ?></label>
					<input type="hidden" name="settings[send_header_x_ua_compatible]" value="0" />
					<input type="checkbox" name="settings[send_header_x_ua_compatible]" id="send_header_x_ua_compatible" value="1" <?php if ($REX['ADDON']['seo42']['settings']['send_header_x_ua_compatible']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="fix_image_manager_cache_control_header"><?php echo $I18N->msg('seo42_settings_fix_image_manager_cache_control_header'); ?></label>
					<input type="hidden" name="settings[fix_image_manager_cache_control_header]" value="0" />
					<input type="checkbox" name="settings[fix_image_manager_cache_control_header]" id="fix_image_manager_cache_control_header" value="1" <?php if ($REX['ADDON']['seo42']['settings']['fix_image_manager_cache_control_header']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

		</div>
       </fieldset>


     <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_sitemap_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="static_sitemap_priority"><?php echo $I18N->msg('seo42_settings_static_sitemap_priority'); ?></label>
					<input type="hidden" name="settings[static_sitemap_priority]" value="0" />
					<input type="checkbox" name="settings[static_sitemap_priority]" id="static_sitemap_priority" value="1" <?php if ($REX['ADDON']['seo42']['settings']['static_sitemap_priority']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

		  <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="xml-sitemap"><?php echo $I18N->msg('seo42_settings_sitemap_link'); ?></label>
              <span class="rex-form-read" id="xml-sitemap"><a href="<?php echo seo42::getBaseUrl(); ?>sitemap.xml" target="_blank"><?php echo seo42::getBaseUrl(); ?>sitemap.xml</a></span>
            </p>
          </div>

        </div>
      </fieldset>

      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_robots_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="no_robots_txt_auto_disallow"><?php echo $I18N->msg('seo42_settings_no_robots_txt_auto_disallow'); ?></label>
					<input type="hidden" name="settings[no_robots_txt_auto_disallow]" value="0" />
					<input type="checkbox" name="settings[no_robots_txt_auto_disallow]" id="no_robots_txt_auto_disallow" value="1" <?php if ($REX['ADDON']['seo42']['settings']['no_robots_txt_auto_disallow']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="robots"><?php echo $I18N->msg('seo42_settings_robots_additional'); ?></label>
              <textarea name="settings[robots]" rows="2"><?php echo stripslashes($REX['ADDON'][$myself]['settings']['robots']); ?></textarea>
            </p>
          </div>

		  <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="robots-txt"><?php echo $I18N->msg('seo42_settings_robots_link'); ?></label>
              <span class="rex-form-read" id="robots-txt"><a href="<?php echo seo42::getBaseUrl(); ?>robots.txt" target="_blank"><?php echo seo42::getBaseUrl(); ?>robots.txt</a></span>
            </p>
          </div>

        </div>
      </fieldset>

      <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_google_site_verification_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="google_site_verification_filename"><?php echo $I18N->msg('seo42_settings_google_site_verification_filename'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['google_site_verification_filename']; ?>" name="settings[google_site_verification_filename]" class="rex-form-text" id="google_site_verification_filename">
				</p>
			</div>

        </div>
      </fieldset>

    <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_html_section'); ?></legend>
        <div class="rex-form-wrapper slide">


	      <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="robots_follow_flag"><?php echo $I18N->msg('seo42_settings_robots_follow_flag'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['robots_follow_flag']; ?>" name="settings[robots_follow_flag]" class="rex-form-text" id="robots_follow_flag">
				</p>
			</div>

	      <div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="robots_archive_flag"><?php echo $I18N->msg('seo42_settings_robots_archive_flag'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['robots_archive_flag']; ?>" name="settings[robots_archive_flag]" class="rex-form-text" id="robots_archive_flag">
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-text">
					<label for="title_delimiter"><?php echo $I18N->msg('seo42_settings_title_delimiter'); ?></label>
					<input type="text" value="<?php echo $REX['ADDON']['seo42']['settings']['title_delimiter']; ?>" name="settings[title_delimiter]" class="rex-form-text" id="title_delimiter">
				</p>
			</div>

        </div>
      </fieldset>

    <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_ui_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="seopage"><?php echo $I18N->msg('seo42_settings_seopage'); ?></label>
					<input type="hidden" name="settings[seopage]" value="0" />
					<input type="checkbox" name="settings[seopage]" id="seopage" value="1" <?php if ($REX['ADDON']['seo42']['settings']['seopage']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="title_preview"><?php echo $I18N->msg('seo42_settings_title_preview'); ?></label>
					<input type="hidden" name="settings[title_preview]" value="0" />
					<input type="checkbox" name="settings[title_preview]" id="title_preview" value="1" <?php if ($REX['ADDON']['seo42']['settings']['title_preview']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="no_prefix_checkbox"><?php echo $I18N->msg('seo42_settings_no_prefix_checkbox'); ?></label>
					<input type="hidden" name="settings[no_prefix_checkbox]" value="0" />
					<input type="checkbox" name="settings[no_prefix_checkbox]" id="no_prefix_checkbox" value="1" <?php if ($REX['ADDON']['seo42']['settings']['no_prefix_checkbox']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="custom_canonical_url"><?php echo $I18N->msg('seo42_settings_custom_canonical_url'); ?></label>
					<input type="hidden" name="settings[custom_canonical_url]" value="0" />
					<input type="checkbox" name="settings[custom_canonical_url]" id="custom_canonical_url" value="1" <?php if ($REX['ADDON']['seo42']['settings']['custom_canonical_url']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="noindex_checkbox"><?php echo $I18N->msg('seo42_settings_noindex_checkbox'); ?></label>
					<input type="hidden" name="settings[noindex_checkbox]" value="0" />
					<input type="checkbox" name="settings[noindex_checkbox]" id="noindex_checkbox" value="1" <?php if ($REX['ADDON']['seo42']['settings']['noindex_checkbox']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="urlpage"><?php echo $I18N->msg('seo42_settings_urlpage'); ?></label>
					<input type="hidden" name="settings[urlpage]" value="0" />
					<input type="checkbox" name="settings[urlpage]" id="urlpage" value="1" <?php if ($REX['ADDON']['seo42']['settings']['urlpage']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="all_url_types"><?php echo $I18N->msg('seo42_settings_all_url_types'); ?></label>
					<input type="hidden" name="settings[all_url_types]" value="0" />
					<input type="checkbox" name="settings[all_url_types]" id="all_url_types" value="1" <?php if ($REX['ADDON']['seo42']['settings']['all_url_types']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="pagerank_checker"><?php echo $I18N->msg('seo42_settings_pagerank_checker'); ?></label>
					<input type="hidden" name="settings[pagerank_checker]" value="0" />
					<input type="checkbox" name="settings[pagerank_checker]" id="pagerank_checker" value="1" <?php if ($REX['ADDON']['seo42']['settings']['pagerank_checker']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="redirects"><?php echo $I18N->msg('seo42_settings_redirects'); ?></label>
					<input type="hidden" name="settings[redirects]" value="0" />
					<input type="checkbox" name="settings[redirects]" id="redirects" value="1" <?php if ($REX['ADDON']['seo42']['settings']['redirects']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>

        </div>
      </fieldset>



    <fieldset class="rex-form-col-1">
        <legend><?php echo $I18N->msg('seo42_settings_misc_section'); ?></legend>
        <div class="rex-form-wrapper slide">

			<div class="rex-form-row rex-form-element-v1">
				<p class="rex-form-checkbox">
					<label for="one_page_mode"><?php echo $I18N->msg('seo42_settings_one_page_mode'); ?></label>
					<input type="hidden" name="settings[one_page_mode]" value="0" />
					<input type="checkbox" name="settings[one_page_mode]" id="one_page_mode" value="1" <?php if ($REX['ADDON']['seo42']['settings']['one_page_mode']) { echo 'checked="checked"'; } ?>>
				</p>
			</div>
			
		</div>
       </fieldset>

      <fieldset class="rex-form-col-1">
        <div class="rex-form-wrapper">

          <div class="rex-form-row rex-form-element-v2">

            <p class="rex-form-submit">
              <input style="margin-top: 5px; margin-bottom: 5px;" class="rex-form-submit" type="submit" id="sendit" name="sendit" value="<?php echo $I18N->msg('seo42_settings_submit'); ?>" />
            </p>
          </div>

        </div>
      </fieldset>

  </form>
  </div>
</div>

<?php
unset($homeurl_select,$url_ending_select);
?>

<style type="text/css">
div.rex-form legend {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	width: 100%;
	cursor: pointer;
	border-bottom: 1px solid #fff;
	background: transparent url("../<?php echo $REX['MEDIA_ADDON_DIR']; ?>/seo42/arrows.png") no-repeat 7px 10px;
	padding-left: 19px;
}

div.rex-form legend:hover {
	background-color: #eee;
}

div.rex-form legend.open {
	background-position: 7px -36px;
}

.rex-form-wrapper.slide {
	display: none;
}

.pipes {
	font-family: Verdana, 'Trebuchet MS', Arial, sans-serif;
}

.preset-button {
	float: right;
	margin-right: 4px;
	margin-top: -23px;
	font-weight: bold;
	border-radius: 4px;
	padding: 2px 4px;
}

.preset-button:hover,
.preset-button.dropdown-open {
	background: #ccc;
	text-decoration: none !important;
}

.preset-button:after {
    color: #08c;
    content: "↓";
    font-size: 12px;
    font-weight: bold;
    margin-left: 3px;
	vertical-align: text-top;
}

div#rex-website .dropdown a:hover {
	text-decoration: none;
}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		// tag editor inputs fields
		$('input.tags').tagEditor({placeholder: "<?php echo $I18N->msg('seo42_settings_tag_editor_hint'); ?>"});

		// rewrite mode
		$('.rewrite_mode').change(function() {
			var curClang = $(this).attr('data-clang');

			if ($(this).val() == "<?php echo SEO42_REWRITEMODE_SPECIAL_CHARS; ?>") {
				$('#lang_settings_' + curClang + '_inherit_from_clang_row').hide();
				$('#lang_settings_' + curClang + '_special_chars_row').show();
				$('#lang_settings_' + curClang + '_special_chars_rewrite_row').show();
			} else if ($(this).val() == "<?php echo SEO42_REWRITEMODE_URLENCODE; ?>") {
				$('#lang_settings_' + curClang + '_special_chars_row').hide();
				$('#lang_settings_' + curClang + '_special_chars_rewrite_row').hide();
				$('#lang_settings_' + curClang + '_inherit_from_clang_row').hide();
			} else if ($(this).val() == "<?php echo SEO42_REWRITEMODE_INHERIT; ?>") {
				$('#lang_settings_' + curClang + '_special_chars_row').hide();
				$('#lang_settings_' + curClang + '_special_chars_rewrite_row').hide();
				$('#lang_settings_' + curClang + '_inherit_from_clang_row').show();				
			}
		});

		$('.rewrite_mode').change();

		// presets
		var langPresets = <?php echo json_encode($REX['SEO42_LANG_PRESETS']); ?>;

		$('ul.dropdown-menu li').click(function(e) { 
			var curClang = $(this).parent().attr('data-clang');
			var curLangPresetIndex = $(this).attr('data-langpreset-id');

			$('#lang_settings_' + curClang + '_code').val(langPresets[curLangPresetIndex]['code']);
			$('#lang_settings_' + curClang + '_original_name').val(langPresets[curLangPresetIndex]['original_name']);
			$('#lang_settings_' + curClang + '_rewrite_mode').val(langPresets[curLangPresetIndex]['rewrite_mode']);
			$('#lang_settings_' + curClang + '_special_chars').val(langPresets[curLangPresetIndex]['special_chars']);
			$('#lang_settings_' + curClang + '_special_chars_rewrite').val(langPresets[curLangPresetIndex]['special_chars_rewrite']);
			$('#lang_settings_' + curClang + '_inherit_from_clang').val(langPresets[curLangPresetIndex]['inherit_from_clang']);

			$('.rewrite_mode').change();
    	});

		// slide
		$('.rex-form-col-1 legend').click(function(e) { 
			$(this).toggleClass('open');
			$(this).next('.rex-form-wrapper.slide').slideToggle();
		});
	});
</script>


