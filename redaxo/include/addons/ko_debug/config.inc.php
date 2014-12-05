<?php
/**
 * Debug Addon 
 * @author sven[ät]koalashome[punkt]de Sven Eichler
 * @package redaxo4
 */

// addon identifier
$mypage = "ko_debug";

$REX['ADDON']['rxid'][$mypage] = '81';

if ($REX['REDAXO']) {
  $I18N->appendFile($REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/');
}

$REX['ADDON']['page'][$mypage] = $mypage;    
$REX['ADDON']['name'][$mypage] = 'ko_Debug';
$REX['ADDON']['perm'][$mypage] = 'ko_debug[]';
$REX['ADDON']['version'][$mypage] = "1.3";
$REX['ADDON']['author'][$mypage] = "Sven (Koala) Eichler, cukabeka";
// $REX['ADDON']['supportpage'][$mypage] = "";

// add default perm for accessing the addon to user-administration
$REX['PERM'][] = 'ko_debug[]';

require_once dirname(__FILE__) .'/settings.inc.php';
include_once ('functions/function_session_check.inc.php');


if (!isset ($_SESSION)) {
	session_start();
}
checkInitiatedSession();


if ($REX['ADDON']['settings']['ko_debug']['debug'] && 
  rex_hasBackendSession() == 1) {
  include_once ('functions/function_debug.inc.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function Debug_Out() {
    return true;
  }
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function DBO() {
    return true;
  }
  /**
   * Dummyfunktion
   * 
   * Wenn Debug-Out deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function DebugOut() {
    return true;
  }
}


if ($REX['ADDON']['settings']['ko_debug']['krumo'] && 
    rex_hasBackendSession() == 1 &&
    version_compare(PHP_VERSION, '5.0.0', '>=')) {
  include_once ('krumo/class.krumo.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn krumo deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function krumo() {
    return true;
  }
}

if ($REX['ADDON']['settings']['ko_debug']['kint'] && 
    rex_hasBackendSession() == 1 &&
    version_compare(PHP_VERSION, '5.0.0', '>=')) {
  include_once ('kint/Kint.class.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn kint deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
   class Kint{
	  static function dump() {
	    return;
	  }
	  static function trace() {
	    return;
	  }
	  static function enabled() {
	    return;
	  }
   }
  function sd() {
    return;
  }
  function s() {
    return;
  }
  function dd() {
    return;
  }
  function d() {
    return;
  }
}
if ($REX['ADDON']['settings']['ko_debug']['ghost'] && 
    rex_hasBackendSession() == 1 &&
    version_compare(PHP_VERSION, '5.0.0', '>=')) {
  include_once ('functions/function_ghost_echo.inc.php');
} else {
  /**
   * Dummyfunktion
   * 
   * Wenn krumo deaktiviert wurde, so gibt es mit 
   * dieser Funktion keine Fehlermeldung bezüglich nicht 
   * vorhandener Funktionen.
   */
  function ghost_echo() {
    return;
  }
}
