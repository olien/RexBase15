<?php

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

require($REX['INCLUDE_PATH'] . '/layout/top.php');

rex_title($REX['ADDON']['name'][$page] . ' <span style="font-size:14px; color:silver;">' . $REX['ADDON']['version'][$page] . '</span>');

// save settings
if ($func == 'update') {
	$settings = (array) rex_post('settings', 'array', array());

	rex_slice_status::replaceSettings($settings);
	rex_slice_status::updateSettingsFile();
}
?>

<div class="rex-addon-output">
	<div class="rex-form">

		<h2 class="rex-hl2"><?php echo $I18N->msg('slice_status_settings'); ?></h2>

		<form action="index.php" method="post">

			<fieldset class="rex-form-col-1">
				<div class="rex-form-wrapper">
					<input type="hidden" name="page" value="slice_status" />
					<input type="hidden" name="subpage" value="" />
					<input type="hidden" name="func" value="update" />

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-checkbox">
							<label for="ajax_mode"><?php echo $I18N->msg('slice_status_ajax_mode'); ?></label>
							<input type="hidden" name="settings[ajax_mode]" value="0" />
							<input type="checkbox" name="settings[ajax_mode]" id="ajax_mode" value="1" <?php if ($REX['ADDON']['slice_status']['settings']['ajax_mode']) { echo 'checked="checked"'; } ?>>
						</p>
					</div>

					<div class="rex-form-row">
						<p class="rex-form-col-a rex-form-select">
							<label for="menuitem_position"><?php echo $I18N->msg('slice_status_menuitem_position'); ?></label>
							<select name="settings[menuitem_position]" size="1" id="menuitem_position" class="rex-form-select">
								<option value="left" <?php if ($REX['ADDON']['slice_status']['settings']['menuitem_position'] == 'left') { echo 'selected="selected"'; } ?>><?php echo $I18N->msg('slice_status_left'); ?></option>
								<option value="right" <?php if ($REX['ADDON']['slice_status']['settings']['menuitem_position'] == 'right') { echo 'selected="selected"'; } ?>><?php echo $I18N->msg('slice_status_right'); ?></option>
							</select>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-col-a rex-form-read">
							<label for="css_hint"><?php echo $I18N->msg('slice_status_css_hint'); ?></label>
							<span class="rex-form-read" id="css_hint"><code>/files/addons/slice_status/slice_status.css</code></span>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-col-a rex-form-read">
							<label for="css_hint2"><?php echo $I18N->msg('slice_status_perm_msg'); ?></label>
							<span class="rex-form-read" id="css_hint2"><code>publishSlice[]</code></span>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v2">
						<p class="rex-form-submit">
							<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('slice_status_settings_save'); ?>" />
						</p>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<style type="text/css">
#rex-page-slice-status div.rex-form-row label {
	width: 240px !important; 
}

#rex-page-slice-status p.rex-form-submit {
	text-align: right;
}

#rex-page-slice-status div.rex-form div.rex-form-element-v2 p input.rex-form-submit {
	margin-left: 0;
	margin-right: 40px;
}
</style>

<?php require($REX['INCLUDE_PATH'] . '/layout/bottom.php'); ?>
