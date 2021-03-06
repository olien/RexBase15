<?php
/**
 * Managed diverse Dinge
 * 
 * @author koala
 *
 */
class ko_debug_manager
{
  /**
   * Speichern der Einstellungen
   * 
   * @param 	array $settings
   * @return	mixed	FALSE im Fehlerfall, sonst die Anzahl geschriebener Bytes
   */
  function saveSettings($settings = array())
  {
    global $REX;
    $mypage = 'ko_debug';
    $REX['ADDON']['settings'][$mypage] = array_merge((array)$REX['ADDON']['settings'][$mypage], (array)$settings);
    $content = '';
    foreach ((array)$REX['ADDON']['settings'][$mypage] as $key=>$value)
      $content .= "\$REX['ADDON']['settings']['$mypage']['$key'] = \"".$value."\";\n";
    $file = $REX['INCLUDE_PATH']."/addons/$mypage/settings.inc.php";
    return rex_replace_dynamic_contents($file, $content);
  }

  function sync()
  {
    global $REX;
    $page = rex_request('page', 'string');
    $subpage = rex_request('subpage', 'string');
    $function = rex_request('function','string','');
    $save = rex_request('save','string','');

    if (($page == 'template' && ((($function=='add' || $function=='edit') && $save=='ja') || $function=='delete'))
      || ($page == 'module' && ((($function=='add' || $function=='edit') && $save=='1') || $function=='delete'))
      || ($page == 'import_export' && $subpage == 'import')
      || $page == 'developer') 
    {
      rex_register_extension('OUTPUT_FILTER_CACHE', array('rex_developer_manager', '_sync'));
    }
    else
    {
      rex_developer_manager::_sync();
    }
  }

  function _sync()
  {
    global $REX;
    if ($REX['ADDON']['settings']['developer']['templates'] 
      || $REX['ADDON']['settings']['developer']['modules']
      || $REX['ADDON']['settings']['developer']['actions'])
    {
      require_once $REX['INCLUDE_PATH'] .'/addons/developer/classes/class.rex_developer_synchronizer.inc.php';
      $sync = new rex_developer_synchronizer();
      if ($REX['ADDON']['settings']['developer']['templates'])
        $sync->syncTemplates();
      if ($REX['ADDON']['settings']['developer']['modules'])
        $sync->syncModules();
      if ($REX['ADDON']['settings']['developer']['actions'])
        $sync->syncActions();
    }
  }

  function deleteFiles($check = false, $deleteDir = false)
  {
    global $REX;
    require_once $REX['INCLUDE_PATH'] .'/addons/developer/classes/class.rex_developer_synchronizer.inc.php';
    $sync = new rex_developer_synchronizer();
    if (!$check || !$REX['ADDON']['settings']['developer']['templates'])
      $sync->deleteTemplateFiles($deleteDir);
    if (!$check || !$REX['ADDON']['settings']['developer']['modules'])
      $sync->deleteModuleFiles($deleteDir);
    if (!$check || !$REX['ADDON']['settings']['developer']['actions'])
      $sync->deleteActionFiles($deleteDir);
  }

  function checkDir($dir)
  {
    global $REX, $I18N;
    $path = $REX['INCLUDE_PATH'] .'/'. $dir;
    if (!@is_dir($path))
    {
      @mkdir($path, $REX['ADDON']['dirperm']['ko_debug'], true);
    }
    if (!@is_dir($path))
    {
      return $I18N->msg('developer_install_make_dir', $dir);
    }
    elseif (!@is_writable($path .'/.'))
    {
      return $I18N->msg('developer_install_perm_dir', $dir);
    }
    return '';
  }

  function deleteDir($dir)
  {
    global $REX;
    $path = $REX['INCLUDE_PATH'] .'/'. $dir;
    $files = array();
    $glob = glob($path .'/*');
    if (is_array($glob))
    {
      $files = array_flip($glob);
      unset($files[$path .'/templates']);
      unset($files[$path .'/modules']);
      unset($files[$path .'/actions']);
    }
    if (count($files) == 0)
    {
      rex_deleteDir($path, true);
    }
  }
}