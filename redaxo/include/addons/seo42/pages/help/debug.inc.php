<?php

$REX['REDAXO'] = false;
$REX['ADDON']['seo42']['settings']['include_query_params'] = false;

$debugOut = seo42::getDebugInfo($REX['START_ARTICLE_ID']);

$REX['REDAXO'] = true;
$REX['ADDON']['seo42']['settings']['include_query_params'] = true;

if ($debugOut) {
	echo $debugOut;
} else {
	echo '<strong>' . $I18N->msg('seo42_help_debug_article_wrong') . ' ' . $REX['START_ARTICLE_ID'] . '</strong>';
}

