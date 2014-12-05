<?php

$search = array('(CHANGELOG.md)', '(LICENSE.md)', '(FAQ.md)', '(UPDATE.md)');
$replace = array('(index.php?page=seo42&subpage=help&chapter=changelog)', '(index.php?page=seo42&subpage=help&chapter=license)', '(index.php?page=seo42&subpage=help&chapter=faq)', '(index.php?page=seo42&subpage=help&chapter=update)');

echo seo42_utils::getHtmlFromMDFile('README.md', $search, $replace);

