<?php

if (isset($REX['USER']) && !$REX['USER']->isAdmin() && $REX['USER']->hasPerm('seo42[tools_only]')) {
	$startSubpage = 'tools';
} elseif (isset($REX['USER']) && !$REX['USER']->isAdmin() && $REX['USER']->hasPerm('seo42[redirects_only]')) {
	$startSubpage = 'redirects';
} else {
	$startSubpage = 'start';
}

$myself = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string') != '' ? rex_request('subpage', 'string') : $startSubpage;
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$section_id = rex_request('section_id', 'string');
$section_class = rex_request('section_class', 'string');
$highlight = rex_request('highlight', 'string');
$myroot = $REX['INCLUDE_PATH'] . '/addons/' . $myself;

// includes
require_once($myroot.'/classes/class.seo42_rewrite.inc.php');

// layout top
require($REX['INCLUDE_PATH'] . '/layout/top.php');

// title
rex_title($REX['ADDON']['name'][$myself] . ' <span style="font-size:14px; color:silver;">' . $REX['ADDON']['version'][$myself] . '</span>', $REX['ADDON'][$myself]['SUBPAGES']);

// subpages
switch($subpage){
	case '':
		$subpage = $startSubpage;
	case 'start':
	case 'settings':
	case 'redirects':
	case 'tools':
	case 'setup':
	case 'help':
		$local_path = '/addons/' . $myself . '/pages/';
		break;
	default:
		$local_path = '/addons/' . $myself . '/plugins/' . $subpage . '/pages/';
}

require $REX['INCLUDE_PATH'] . $local_path . $subpage . '.inc.php';
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	if (!jQuery.ui) {
		$('head').append('<script type="text/javascript" src="../<?php echo $REX['MEDIA_ADDON_DIR']; ?>/<?php echo rex_request('page'); ?>/jquery-ui.min.js" />');
	}

    $('.seo42-tooltip[title]').qtip({
		style: {
			classes: 'qtip-default qtip-rounded qtip-shadow'
		},
		content: {
			title: '<?php echo $I18N->msg('seo42_tooltip_headline'); ?>'
		}
	});

	$('.seo42-info-tooltip[title]').qtip({
		style: {
			classes: 'qtip-light qtip-rounded qtip-shadow'
		},
		content: {
			title: '<?php echo $I18N->msg('seo42_tooltip_info_headline'); ?>'
		}
	});
});
</script>

<?php
// layout bottom
require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

