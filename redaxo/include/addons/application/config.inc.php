<?php
$mypage = "application";

$REX['ADDON']['rxid'][$mypage] = '';
$REX['ADDON']['name'][$mypage] = '';
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['version'][$mypage] = '';
$REX['ADDON']['author'][$mypage] = '';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage] = $mypage . "[]";
$REX['PERM'][] = $mypage . "[]";


// ---------- XForm values/action/validations einbinden
if (is_dir($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/xform')) {

    function rex_application_xform($params) {
        global $REX;
        $mypage = 'application';

        $dirs = array('action', 'validate', 'value');

        foreach ($dirs as $dir) {

            if (is_dir($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/xform/classes/' . $dir)) {

                $REX['ADDON']['xform']['classpaths'][$dir][] = $REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/xform/classes/' . $dir . '/';

            }
        }

        $dirs = array('templates');

        foreach ($dirs as $dir) {

            if (is_dir($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/xform/' . $dir)) {

                $REX['ADDON']['xform']['templatepaths'][$dir] = $REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/xform/' . $dir . '/';

            }
        }

    }

    rex_register_extension('ADDONS_INCLUDED', 'rex_application_xform');

}
