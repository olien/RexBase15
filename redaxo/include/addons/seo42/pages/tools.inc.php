<?php
require($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.seo42_tool.inc.php');
require($REX['INCLUDE_PATH'] . '/addons/seo42/classes/class.seo42_tool_manager.inc.php');

$func = rex_request('func', 'string');

if ($func == 'add_domain') {
	$REX['ADDON']['seo42']['settings']['pagerank_checker_unlock'] = true;

	seo42_utils::updateSettingsFile();
}

$googleIndexLink = 'http://www.google.com/search?q=site:' . seo42::getServerWithSubDir();;
?>

<?php if ($REX['ADDON']['seo42']['settings']['pagerank_checker']) { ?>
<div class="rex-addon-output">
	<h2 class="rex-hl2"><?php echo $I18N->msg('seo42_pr_tool'); ?></h2>
	<div class="rex-area-content">
		<div class="tool-icon"></div>
		<p><?php echo $I18N->msg('seo42_pr_tool_msg') . ' ' . seo42::getServerWithSubdir() ?>.</p>
		<p class="pr"><?php echo $I18N->msg('seo42_pr_tool_pagerank'); ?>: <span id="pagerank" class="info"><?php if ($REX['ADDON']['seo42']['settings']['pagerank_checker_unlock']) { echo $I18N->msg('seo42_pr_tool_pagerank_ready'); } else { echo $I18N->msg('seo42_tool_domain_not_unlocked'); } ?></span></p>
		
		<?php if ($REX['ADDON']['seo42']['settings']['pagerank_checker_unlock']) { ?>
		<p>
			<input id="pr-check" type="button" class="rex-form-submit" value="<?php echo $I18N->msg('seo42_pr_tool_button'); ?>" />
		</p>
		<?php } else { ?>
		<form action="index.php" method="post" class="domain-unlock-form">		
			<p id="domain-unlock">
				<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('seo42_tool_domain_unlock_button'); ?>" />
			</p>
			<input type="hidden" name="page" value="seo42" />
			<input type="hidden" name="subpage" value="tools" />
			<input type="hidden" name="func" value="add_domain" />
		</form>
		<?php } ?>
	</div>
</div>
<?php } ?>

<div class="rex-addon-output">
	<h2 class="rex-hl2"><?php echo $I18N->msg('seo42_show_index_tool'); ?></h2>
	<div class="rex-area-content">
		<div class="tool-icon"></div>
		<p><?php echo $I18N->msg('seo42_show_index_tool_msg', seo42::getServerWithSubdir()); ?></p>
		<p class="url"><?php echo $googleIndexLink; ?></p>

		<?php if ($REX['ADDON']['seo42']['settings']['pagerank_checker_unlock']) { ?>
		<p>
			<input id="show-index" type="button" class="rex-form-submit" value="<?php echo $I18N->msg('seo42_show_index_tool_button'); ?>" />
		</p>
		<?php } else { ?>
		<form action="index.php" method="post" class="domain-unlock-form">		
			<p id="domain-unlock">
				<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('seo42_tool_domain_unlock_button'); ?>" />
			</p>
			<input type="hidden" name="page" value="seo42" />
			<input type="hidden" name="subpage" value="tools" />
			<input type="hidden" name="func" value="add_domain" />
		</form>
		<?php } ?>
	</div>
</div>

<?php
$toolManager = new seo42_tool_manager();

$tool = new seo42_tool($I18N->msg('seo42_tool3'), $I18N->msg('seo42_tool3_desc'), 'http://www.google.com/webmasters/tools/');
$toolManager->addTool($tool);

$tool = new seo42_tool($I18N->msg('seo42_tool2'), $I18N->msg('seo42_tool2_desc'), 'http://www.google.com/webmasters/tools/submit-url');
$toolManager->addTool($tool);

if (!$REX['ADDON']['seo42']['settings']['pagerank_checker']) {
	$tool = new seo42_tool($I18N->msg('seo42_tool4'), $I18N->msg('seo42_tool4_desc'), 'http://www.gaijin.at/olsgprank.php');
	$toolManager->addTool($tool);
}

$tool = new seo42_tool($I18N->msg('seo42_tool9'), $I18N->msg('seo42_tool9_desc'), ' http://www.seobility.net/');
$toolManager->addTool($tool);

$tool = new seo42_tool($I18N->msg('seo42_tool6'), $I18N->msg('seo42_tool6_desc'), 'http://www.seitwert.de/#quick');
$toolManager->addTool($tool);

$tool = new seo42_tool($I18N->msg('seo42_tool8'), $I18N->msg('seo42_tool8_desc'), 'http://www.seomofo.com/snippet-optimizer.html');
$toolManager->addTool($tool);

$toolManager->printToolList($I18N->msg('seo42_tools_caption'));
?>

<style type="text/css">
table.rex-table th {
	font-size: 1.2em;
}

table.rex-table td {
	padding: 11px 5px;
}

table.rex-table td p {
	margin-top: 6px;
	color: #32353A;
}

table.rex-table td p.url,
p.url {
	color: grey;
}

.rex-table td a,
.rex-table td span {
	font-weight: bold;
}

div.rex-area-content p.pr {
	line-height: 24px;
	position: relative;
}

#pagerank {
	position: absolute;
	top: 0;
	margin-left: 5px;
	font-size: 17px;
}

#pagerank.loading {
	background: transparent url("../files/addons/seo42/loading.gif") no-repeat left 3px;
}

#pagerank.success,
#pagerank.info {
	background: transparent;
}

#pagerank.success {
	font-weight: bold;
}

#pagerank.info {
	font-style: italic;
	font-size: 100%;
}

.rex-hl2 {
	font-size: 1.2em;
}

#domain-unlock,
#pr-check,
#show-index {
	float: right;
	margin-bottom: 10px;
	margin-right: 5px;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery('#show-index').click(function() {
		newWindow('show_index', '<?php echo $googleIndexLink; ?>', 1000, 700, ',status=yes,resizable=yes');
        return false;
	});

	jQuery('#pr-check').click(function() {
		$('#pagerank').removeClass('info');
		$('#pagerank').removeClass('success');

		$('#pagerank').addClass('loading');
		$('#pagerank').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

		// ajax call for pagerank checker
		$.ajax({
			url: window.location.pathname + '?function=getpagerank&url=<?php echo seo42::getServerWithSubdir(); ?>',
			type : 'POST',
			success : function (result) {
				$('#pagerank').removeClass('loading');

				if (result === '') {
					$('#pagerank').addClass('info');
					$('#pagerank').html('<?php echo $I18N->msg('seo42_pr_tool_failure'); ?>');
				} else {
					$('#pagerank').addClass('success');
					$('#pagerank').html(result);
				}
			},
			error : function () {
				$('#pagerank').removeClass('loading');
				$('#pagerank').addClass('info');
				$('#pagerank').html('<?php echo $I18N->msg('seo42_pr_tool_failure'); ?>');
			}
		});
	});

	<?php if (!$REX['ADDON']['seo42']['settings']['pagerank_checker_unlock']) { ?>
		jQuery('.domain-unlock-form').submit(function() {
			if (confirm('<?php echo $I18N->msg('seo42_tool_domain_unlock_msg', seo42::getServerWithSubDir()); ?>')) {
				return true;
			}

			return false;
		});
	<?php } ?>
});
</script>


