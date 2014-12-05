<?php

class SEO42Rewrite
{
  
  /* constructor */
  function SEO42Rewrite() {
    // do nothing
  }

  /**
  * RESOLVE()
  *
  * resolve url to ARTICLE_ID & CLANG,
  * resolve rewritten params back to GET/REQUEST
  */
  function resolve()
  {
    global $REX, $SEO42_URLS, $SEO42_IDS;

    if(!file_exists(SEO42_PATHLIST)) {
      seo42_generate_pathlist(array());
    } 

    require_once(SEO42_PATHLIST);

    if(!$REX['REDAXO'])
    {
      $article_id      = -1;

      $clang           = $REX['CUR_CLANG'];
      $start_id        = $REX['START_ARTICLE_ID'];
      $notfound_id     = $REX['NOTFOUND_ARTICLE_ID'];

      $install_subdir  = seo42::getServerSubDir(); // 42
      $homelang        = $REX['ADDON']['seo42']['settings']['homelang'];

      // TRY IMMEDIATE MATCH OF REQUEST_URI AGAINST PATHLIST..
      if(self::resolve_from_pathlist(ltrim($_SERVER['REQUEST_URI'],'/')))
      {
        return;
      } 


      // allow_article_id ?
      if ($REX['ADDON']['seo42']['settings']['allow_article_id'] && rex_get('article_id', 'int') > 0) {
        return self::setArticleId(rex_request('article_id', 'int'), rex_request('clang', 'int', $clang));
      }


      // IF NON_REWRITTEN URLS ALLOWED -> USE ARTICLE_ID FROM REQUEST
      if ($REX['ADDON']['seo42']['settings']['auto_redirects'] != SEO42_AUTO_REDIRECT_NONE && rex_get('article_id', 'int') > 0)
      {
        if ($REX['ADDON']['seo42']['settings']['auto_redirects'] == SEO42_AUTO_REDIRECT_ARTICLE_ID)
        {
          $artId = rex_request('article_id','int');
          $clangId = rex_request('clang','int',$clang);
          $article = OOArticle::getArticleById($artId, $clangId);

          if (OOArticle::isValid($article)) {
            $redirect = array('id'    =>$artId,
                              'clang' =>$clangId,
                              'status'=>301);
            return self::redirect($redirect); /*todo: include params*/
          }
        }
      }


      // GET PATH RELATIVE TO INTALL_SUBDIR ---------------> 42
      $path = ltrim($_SERVER['REQUEST_URI'], '/'); 

      if (seo42::isSubDirInstall()) {
        $path = substr($path, strlen($install_subdir));
		$path = ltrim($path, '/');
      }

      // TRIM STANDARD PARAMS
      if(($pos = strpos($path, '?')) !== false)
      {
        $path = substr($path, 0, $pos);
      }

      // TRIM ANCHORS
      if(($pos = strpos($path, '#')) !== false)
      {
        $path = substr($path, 0, $pos);
      }


      // RETRY RESOLVE VIA PATHLIST
      if(self::resolve_from_pathlist($path)) 
      {
        return;
      }

		// smart redirects option
		if ($REX['ADDON']['seo42']['settings']['smart_redirects']) {
			$requestUriWithCorrectUrlEnding = trim($_SERVER['REQUEST_URI'], '/') . $REX['ADDON']['seo42']['settings']['url_ending'];
				 
			if (isset($SEO42_URLS[$requestUriWithCorrectUrlEnding])) {
				$redirect = array('id' => $SEO42_URLS[$requestUriWithCorrectUrlEnding]['id'],
	                              'clang' => $SEO42_URLS[$requestUriWithCorrectUrlEnding]['clang'],
	                              'status' => 301);

				return self::redirect($redirect);
			}
		}

		// auto redirects 
		if ($REX['ADDON']['seo42']['settings']['auto_redirects'] == SEO42_AUTO_REDIRECT_URL_REWRITE || $REX['ADDON']['seo42']['settings']['auto_redirects'] == SEO42_AUTO_REDIRECT_URL_REWRITE_R3) {
			// smart redirects for old fashioned standard redaxo rewrite methods
			if ($REX['ADDON']['seo42']['settings']['auto_redirects'] == SEO42_AUTO_REDIRECT_URL_REWRITE) {
				preg_match('/\/(.*(\.))?((?P<clang>[0-9]+)(.*)\-(?P<id>[0-9]+))((\-|\.).*)/', $_SERVER['REQUEST_URI'], $url_params);
			} else {
				preg_match('/\/(.*(\.))?((?P<clang>[0-9]+)\-(?P<id>[0-9]+))((\-|\.).*)/', $_SERVER['REQUEST_URI'], $url_params);
			}

			if ($url_params !== false && isset($url_params['id']) && isset($url_params['clang'])) {
				$article = OOArticle::getArticleById($url_params['id'], $url_params['clang']);

				if (OOArticle::isValid($article)) {
					$redirect = array('id' => $url_params['id'],
									  'clang' => $url_params['clang'],
									  'status' => 301);

					return self::redirect($redirect);
				}
			}
		}


		// check for possible lang slug to load up correct language for 404 article
		$firstSlashPos = strpos($path, '/');

		if ($firstSlashPos !== false) {
			$possibleLangSlug = substr($path, 0, $firstSlashPos);
			$langSlugs = array();

			foreach ($REX['CLANG'] as $clangId => $clangName) {
				$langSlugs[] = seo42::getLangSlug($clangId);
			}

			$clangId = array_search($possibleLangSlug, $langSlugs);

			if ($clangId !== false) {
				$clang = $clangId;
				$REX['CUR_CLANG'] = $clang;
			}
		}

      // GET ID FROM EXTENSION POINT
      $ep = rex_register_extension_point('SEO42_ARTICLE_ID_NOT_FOUND', '');
      if(isset($ep['article_id']) && $ep['article_id'] > 0)
      {
        if(isset($ep['clang']) && $ep['clang'] > -1)
        {
          $clang = $ep['clang'];
        }
        return self::setArticleId($ep['article_id'],$clang);
      }

      // STILL NO MATCH -> 404
      seo42::set404ResponseFlag();

      self::setArticleId($notfound_id,$clang);
    }
  }

  /**
  * RESOLVE_FROM_PATHLIST()
  *
  * @param  $path  string  URL to look up in pathlist
  * @return        boolean
  */
  function resolve_from_pathlist($path)
  {
    global $SEO42_URLS;

    if(isset($SEO42_URLS[$path]))
    {
      $status = isset($SEO42_URLS[$path]['status']) ? $SEO42_URLS[$path]['status'] : 200;

      switch($status)
      {
        case 301:
        case 302:
        case 303:
        case 307:
          $redirect = array('id'    => $SEO42_URLS[$path]['id'],
                            'clang' => $SEO42_URLS[$path]['clang'],
                            'status'=> $status);
          self::redirect($redirect);
          return true;
        default:
          if(isset($SEO42_URLS[$path]['params']))
            self::populateGlobals($SEO42_URLS[$path]['params'],false);
          self::setArticleId($SEO42_URLS[$path]['id'],$SEO42_URLS[$path]['clang']);
          return true;
      }
    }
    return false;
  }


  /**
  * REWRITE()
  *
  * rewrite URL
  * @param $params from EP URL_REWRITE
  */
  function rewrite($params)
  {
    // URL ALREADY SET BY OTHER EXTENSION
    if($params['subject'] != '')
    {
      return $params['subject'];
    }


    // EP "SEO42_PRE_REWRITE"
    $url = rex_register_extension_point('SEO42_PRE_REWRITE', false, $params);
    if($url !== false)
    {
      return $url;
    }

    global $REX, $SEO42_IDS;

    $id             = $params['id'];
    $name           = $params['name'];
    $clang          = $params['clang'];
    $subdir         = ''; // 42 | $REX['ADDON']['seo42']['settings']['install_subdir']
    $notfound_id    = $REX['NOTFOUND_ARTICLE_ID'];

    // GET PARAMS STRING
    $urlparams = self::makeUrlParams($params);

    // GET URL FROM PATHLIST AND APPEND PARAMS

    if(isset($SEO42_IDS[$id]) && isset($SEO42_IDS[$id][$clang]))
    {
      $base_url = $SEO42_IDS[$id][$clang]['url'];
      $url      = $base_url.$urlparams;
      $notfound = false;
    }
    else
    {
      // RexDude
      $url = '';
	  $base_url = '';

	  if (!empty($SEO42_IDS)) {
          if (!isset($SEO42_IDS[$notfound_id][$clang]['url'])) {
            $clang = $REX['START_CLANG_ID'];
          }

	      $url = $base_url = $SEO42_IDS[$notfound_id][$clang]['url'];
	  }

      $notfound = true;
    }

    // URL START
	// 42
    if ($REX['REDAXO'] && !(rex_request('page', 'string') == 'seo42' && rex_request('subpage', 'string') == 'help')) { // for seo42 debug page urls should look like in frontend
		$subdir = '';
    } else {
		$subdir = seo42::getUrlStart() . $subdir;
    }

    // HACK: EP URL_REWRITE WON'T ACCEPT EMPTY STRING AS RETURN
    if($subdir == '' && $url == '')
    {
      $url = ' ';
    }

    // str_replace fixes a caching bug that appears while updating specific
    // modules/slices in the redaxo backend
    $url = str_replace('/redaxo/','/',$subdir.$url);

	// retrieve trimmend url
	$trimmedUrl = seo42::trimUrl($url);

	// external urls / javascript urls etc. so we have to remove the url start string
	if (!seo42_utils::isInternalCustomUrl($trimmedUrl)) {
		$url = $trimmedUrl;
	}

    // EP "SEO42_POST_REWRITE"
    $ep_params = array('article_id'     => $id,
                       'clang'          => $clang,
                       'notfound'       => $notfound,
                       'base_url'       => $base_url,
                       'subdir'         => $subdir,
                       'urlparams'      => $urlparams,
                       'params'         => $params['params'],
                       'divider'        => $params['divider']
                       );
    $url = rex_register_extension_point('SEO42_POST_REWRITE', $url, $ep_params);

    return $url;
  }



  /**
  * REDIRECT()
  *
  * redirect request
  * @param $redirect   (array) params passed through from EP
  */
  protected function redirect($redirect)
  {
    global $SEO42_IDS;

	$base = seo42::getServerUrl();
    $status   = isset($redirect['status']) ? $redirect['status'] : 200;
    $location = $base.$SEO42_IDS[$redirect['id']][$redirect['clang']]['url'];

    while(ob_get_level()){
      ob_end_clean();
    }

	if ($status == 301) {
		header('HTTP/1.1 301 Moved Permanently');
	} else {
	    header('HTTP/1.1 ' . $status);		
	}

    header('Location:' . $location);
    exit();
  }



  /**
  * SETARTICLEID()
  *
  * set ARTICLE_ID & CLANG in global var $REX
  * @param $art_id   article id
  * @param $clang_id language id
  */
  protected function setArticleId($art_id, $clang_id = -1)
  {
    global $REX;
    $REX['ARTICLE_ID'] = $art_id;
    if($clang_id > -1)
      $REX['CUR_CLANG'] = $clang_id;
  }



  /**
  * MAKEURLPARAMS()
  *
  * Create params string for url
  * @param $EPparams   (array) urlencoded params from rex_getUrl/URL_REWRITE
  */
  protected function makeUrlParams($EPparams)
  {
    global $REX;
    $divider        = $EPparams['divider'];
    $urlparams      = $EPparams['params'];

    // STANDARD PARAMS STRING
    $urlparams = $urlparams == '' ? '' : '?'.$urlparams;
    $urlparams = str_replace(array('/amp;','?&amp;','?&'),array('/','?','?'),$urlparams);

    return $urlparams;
  }



  /**
  * POPULATEGLOBALS()
  *
  * Populate GET/REQUEST Globals with params from either rex_getUrl/URL_REWRITE
  * (params will come urlencoded) or from pathlist (NOT urlencoded)
  * @param $vars   (array) resolved URL Parameters
  * @param $decode (bool)  urldecode vars yes/no
  */
  protected function populateGlobals($vars,$decode=true)
  {
    if(is_array($vars))
    {
      for($c=0;$c<count($vars);$c+=2)
      {
        if($vars[$c]!='')
        {
          $key = $decode ? urldecode($vars[$c])   : $vars[$c];
          $val = $decode ? urldecode($vars[$c+1]) : $vars[$c+1];

          if(strstr($key,'('))
          {
            $key = rtrim($key,')');
            $key = explode('(',$key);
          }

          if(is_array($key) && count($key)==2)
          {
            $_GET[$key[0]][$key[1]]     = $val;
            $_REQUEST[$key[0]][$key[1]] = $val;
          }
          else
          {
            $_GET[$key]     = $val;
            $_REQUEST[$key] = $val;
          }
        }
      }
    }
  }

}

// END OF CLASS -> OTHER FUNCTIONS
////////////////////////////////////////////////////////////////////////////////

/**
* SEO42_UNSET_PATHITEM()
*
* delete single article from path-arrays
*/
function seo42_unset_pathitem($id=false)
{
  global $SEO42_IDS, $SEO42_URLS;

  if($id)
  {
    unset($SEO42_IDS[$id]);

    foreach($SEO42_URLS as $k => $v)
    {
      if($v['id']==$id)
      {
        unset($SEO42_URLS[$k]);
        break;
      }
    }
  }
}


/**
* seo42_generate_pathlist()
*
* generiert die Pathlist, abhängig von Aktion
* @author markus.staab[at]redaxo[dot]de Markus Staab
* @package redaxo4.2
*/
function seo42_generate_pathlist($params)
{
  global $REX, $SEO42_IDS, $SEO42_URLS;

  // temporary community install workaround
  if (!isset($REX['ADDON']['seo42'])) {
    return;
  }

  // include pathlist file
  if(file_exists(SEO42_PATHLIST))
  {
    require_once (SEO42_PATHLIST);
  }

  // EXTENSION POINT "SEO42_PATHLIST_BEFORE_REBUILD"
  $subject = array('SEO42_IDS'=>$SEO42_IDS,'SEO42_URLS'=>$SEO42_URLS);
  rex_register_extension_point('SEO42_PATHLIST_BEFORE_REBUILD',$subject);

  $SEO42_IDS = array();
  $SEO42_URLS = array();
  $REX['SEO42_URL_CLONE'] = array();

    $db = new rex_sql();

     // REVISION FIX
    $db->setQuery('UPDATE '. $REX['TABLE_PREFIX'] .'article SET revision = 0 WHERE revision IS NULL;');
    $db->setQuery('UPDATE '. $REX['TABLE_PREFIX'] .'article_slice SET revision = 0 WHERE revision IS NULL;');

	if ($REX['ADDON']['seo42']['settings']['ignore_root_cats']) {
		$sqlQuery = 'SELECT `id`, `clang`, `path`, `startpage`,`seo_custom_url` FROM '. $REX['TABLE_PREFIX'] .'article WHERE re_id != 0 OR (re_id = 0 AND catname LIKE "") AND revision=0 OR revision IS NULL ORDER BY id';
	} else {
		$sqlQuery = 'SELECT `id`, `clang`, `path`, `startpage`,`seo_custom_url` FROM '. $REX['TABLE_PREFIX'] .'article WHERE revision=0 OR revision IS NULL ORDER BY id';
	}

	$db->setQuery($sqlQuery);

	// redirects start articles withou slash: /xx to /xx/
	if (count($REX['CLANG']) > 1 && $REX['ADDON']['seo42']['settings']['url_ending'] != '') {
		foreach ($REX['CLANG'] as $clangId => $clangName) {
			$langSlug = seo42::getLangSlug($clangId);

			if ($REX['ADDON']['seo42']['settings']['homelang'] != $clangId) {
				$SEO42_URLS[$langSlug]  = array ('id' => $REX['START_ARTICLE_ID'],'clang' => $clangId, 'status' => 301);
			}
		}
	}

    while($db->hasNext())
    {
      $pathname   = '';
      $id         = $db->getValue('id');
      $clang      = $db->getValue('clang');
      $path       = $db->getValue('path');

      // NORMALE URL ERZEUGUNG
      {
        // LANG SLUG
        if (count($REX['CLANG']) > 1 && $clang != $REX['ADDON']['seo42']['settings']['hide_langslug'])
        {
          $pathname = '';
          $pathname = seo42_appendToPath($pathname, seo42::getLangSlug($clang), $id, $clang); 
        }

        // pfad über kategorien bauen
        $path = trim($path, '|');
        if($path != '')
        {
          $path = explode('|', $path);
          foreach ($path as $p)
          {
            $ooc = OOCategory::getCategoryById($p, seo42_utils::getInheritedClang($clang));

            // PREVENT FATALS IN RARE CONDITIONS WHERE DB/CACHE ARE OUT OF SYNC
            if(!is_a($ooc,'OOCategory')){
              continue;
			} 

			// 42
			if ($REX['ADDON']['seo42']['settings']['ignore_root_cats'] && $ooc->getParentId() == 0) {
              continue;
            }

            $name = $ooc->getName();
            unset($ooc);

            $pathname = seo42_appendToPath($pathname, $name, $id, $clang);
          }
        }

		$ooa = OOArticle::getArticleById($id, seo42_utils::getInheritedClang($clang));

        // PREVENT FATALS IN RARE CONDITIONS WHERE DB/CACHE ARE OUT OF SYNC
        if(!is_a($ooa,'OOArticle')){
          $db->next();
          continue;
        } 

        if($ooa->isStartArticle())
        {
          $ooc = $ooa->getCategory();
          $catname = $ooc->getName();
          unset($ooc);
          $pathname = seo42_appendToPath($pathname, $catname, $id, $clang);
        }

        // url_schema: seo42
        if(!$ooa->isStartArticle())
        {
          // eigentlicher artikel anhängen
          $name = $ooa->getName();
          unset($ooa);
          $pathname = seo42_appendToPath($pathname, $name, $id, $clang);
        }

        // ALLGEMEINE URL ENDUNG
        $pathname = substr($pathname,0,strlen($pathname)-1).$REX['ADDON']['seo42']['settings']['url_ending'];

        // STARTSEITEN URL FORMAT
        if($db->getValue('id')    == $REX['START_ARTICLE_ID'] && 
           $db->getValue('clang') == $REX['ADDON']['seo42']['settings']['homelang'] && 
           ($REX['ADDON']['seo42']['settings']['homeurl'] == 1 ||
           $REX['ADDON']['seo42']['settings']['homeurl'] == 2))
        {
          $pathname = '';
        }
        elseif($REX['ADDON']['seo42']['settings']['homeurl'] == 2 &&
               $db->getValue('id') == $REX['START_ARTICLE_ID'] &&
               count($REX['CLANG']) > 1)
        {
          $pathname = seo42::getLangSlug($clang).'/';
        }

      }

      // UNSET OLD URL FROM $SEO42_URLS
      if(isset($SEO42_IDS[$id][$clang]['url']) && isset($SEO42_URLS[$SEO42_IDS[$id][$clang]['url']]))
        unset($SEO42_URLS[$SEO42_IDS[$id][$clang]['url']]);

      $SEO42_IDS[$id][$clang] = array('url' => $pathname);
      $SEO42_URLS[$pathname]  = array('id'  => (int) $id, 'clang' => (int) $clang);

      // get data from default lang if clone option is enabled for all other langs
      $jsonData = json_decode($db->getValue('seo_custom_url'), true);
      $articleId = $db->getValue('id');
      $clangId = $db->getValue('clang');

      if (isset($jsonData['url_clone']) && $jsonData['url_clone'] == true && $clangId == $REX['START_CLANG_ID']) {
        $REX['SEO42_URL_CLONE'][$articleId] = $jsonData;
      }

      $db->next();
    }




	// URL MANIPULATION BY SEO42
	// -----------------------------------------------------------------------------------------------------------

	$db->reset();
	
    for ($i = 0; $i < $db->getRows(); $i++) {
		$urlField = $db->getValue('seo_custom_url');
		$articleId = $db->getValue('id');
		$clangId = $db->getValue('clang');

		if ($urlField != '' || isset($REX['SEO42_URL_CLONE'][$articleId])) {
			$urlData = seo42_utils::getUrlTypeData($urlField);
			$jsonData = json_decode($urlData, true);

			if (isset($REX['SEO42_URL_CLONE'][$articleId]) && !isset($jsonData['url_type'])) {
				$jsonData = $REX['SEO42_URL_CLONE'][$articleId];
			}

			switch ($jsonData['url_type']) {
				case SEO42_URL_TYPE_DEFAULT:
					// do nothing
					break;
				case SEO42_URL_TYPE_USERDEF_INTERN:
					$customUrl = $jsonData['custom_url'];

					$SEO42_URLS[$customUrl] = $SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']];
					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]);

					$SEO42_IDS[$articleId][$clangId] = array('url' => $customUrl);

					break;
				case SEO42_URL_TYPE_USERDEF_EXTERN:
					$customUrl = $jsonData['custom_url'];

					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]);

					$SEO42_IDS[$articleId][$clangId] = array('url' => $customUrl);
					break;
				case SEO42_URL_TYPE_MEDIAPOOL:
					$customUrl = $REX['MEDIA_DIR'] . '/' . $jsonData['file'];

					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

					$SEO42_IDS[$articleId][$clangId] = array('url' => $customUrl);

					break;
				case SEO42_URL_TYPE_INTERN_REPLACE:
					$customArticleId = $jsonData['article_id'];

					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

					if (isset($SEO42_IDS[$customArticleId][$clangId]['url'])) {
			  			$SEO42_IDS[$articleId][$clangId] = array('url' => $SEO42_IDS[$customArticleId][$clangId]['url']);
					} else {
						$SEO42_IDS[$articleId][$clangId] = array('url' => '');
					}

					break;
				case SEO42_URL_TYPE_INTERN_REPLACE_CLANG:
					$customArticleId = $jsonData['article_id'];
					$customClangId = $jsonData['clang_id'];

					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

					if (isset($SEO42_IDS[$customArticleId][$customClangId]['url'])) {
			  			$SEO42_IDS[$articleId][$clangId] = array('url' => $SEO42_IDS[$customArticleId][$customClangId]['url']);
					} else {
						$SEO42_IDS[$articleId][$clangId] = array('url' => '');
					}

					break;
				case SEO42_URL_TYPE_REMOVE_ROOT_CAT:
					$curUrl = $SEO42_IDS[$articleId][$clangId]['url'];
					$newUrl = seo42_utils::removeRootCatFromUrl($curUrl, $clangId);

					if ($newUrl != '') {
						// same as SEO42_URL_TYPE_USERDEF_INTERN
						$SEO42_URLS[$newUrl] = $SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']];
						unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

						$SEO42_IDS[$articleId][$clangId] = array('url' => $newUrl);
					}			
					
					break;
				case SEO42_URL_TYPE_CALL_FUNC:
					if ($jsonData['no_url']) {
						unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 
					}

					break;
				case SEO42_URL_TYPE_LANGSWITCH:
					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

					break;
				case SEO42_URL_TYPE_NONE:
					unset($SEO42_URLS[$SEO42_IDS[$articleId][$clangId]['url']]); 

		  			$SEO42_IDS[$articleId][$clangId] = array('url' => '');
					break;	
			}

			unset($jsonData);
		}

		$db->next();
	}

	// -----------------------------------------------------------------------------------------------------------


  // EXTENSION POINT "SEO42_PATHLIST_CREATED"
  $subject = array('SEO42_IDS'=>$SEO42_IDS,'SEO42_URLS'=>$SEO42_URLS);
  $subject = rex_register_extension_point('SEO42_PATHLIST_CREATED',$subject);

  // EXTENSION POINT "SEO42_PATHLIST_FINAL" - READ ONLY
  rex_register_extension_point('SEO42_PATHLIST_FINAL',$subject);

  // ASSEMBLE, COMPRESS & WRITE PATHLIST TO FILE
  $pathlist_content = '$SEO42_IDS = '.var_export($subject['SEO42_IDS'],true).';'.PHP_EOL.'$SEO42_URLS = '.var_export($subject['SEO42_URLS'],true).';';

  $pathlist_content = seo42_compressPathlist($pathlist_content);

  rex_put_file_contents(SEO42_PATHLIST,'<?php'.PHP_EOL.$pathlist_content);

  // PURGE *.CONTENT CACHEFILES TO UPDATE INTERNAL LINKS CREATED BY replceLinks() in rex_article_base
  seo42_purgeCacheFiles();
}


/**
* SEO42_PURGECACHEFILES()
*
* selectively purge cache files by extension
* @param $type (string) cachefile extension
*/
function seo42_purgeCacheFiles($ext='.content')
{
  global $REX;

  $pattern = $REX['GENERATED_PATH'] . '/articles/*'.$ext; // uses new rex var introduced in REDAXO 4.5
  $purge_files = glob($pattern);

  if(is_array($purge_files) && count($purge_files)>0)
  {
    foreach ($purge_files as $file)
    {
      unlink($file);
    }
  }
}


/**
* SEO42_COMPRESSPATHLIST()
*
* replaces excessive linfeeds and whitespaces from var_export
* @param $str (string) the SEO42_PATHLIST as string
*/
function seo42_compressPathlist($str)
{
  global $REX;

  $compressMode = 1;

  switch($compressMode)
  {
    case 0:
      return $str;
      break;

    case 1:
      $matrix   = array(
        'array ('.PHP_EOL.'      \'' => 'array (\'',
        '=> '.PHP_EOL.'  array'      => '=> array',
        '=> '.PHP_EOL.'    array'    =>'=> array',
        ','.PHP_EOL.'    ),'         => ',),',
        '('.PHP_EOL.'    \''         => '(\'',
        ','.PHP_EOL.'    \''         => ',\'',
        ','.PHP_EOL.'  ),'           => ',),'
        );
      break;

    case 2:
      $matrix   = array(
        PHP_EOL => '',
        ' '     => ''
        );
    break;
  }

  return str_replace(array_keys($matrix),array_values($matrix),$str);
}


function seo42_appendToPath($path, $name, $article_id, $clang)
{
  global $REX;

  if ($name != '')
  {
    if (isset($REX['ADDON']['seo42']['settings']['lang'][$clang]['rewrite_mode']) && $REX['ADDON']['seo42']['settings']['lang'][$clang]['rewrite_mode'] == SEO42_REWRITEMODE_URLENCODE)
    {
      // trim stuff
      $name = trim($name, " \t\r\n.");
      $name = preg_replace('/ {2,}/', ' ', $name); // convert multiple spaces to one
      $name = str_replace(' ', $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace'], $name); // spaces
      $name = str_replace('/', $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace'], $name); // slashes
      $name = str_replace('-', $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace'], $name); // dashes
      $name = preg_replace('/'. $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace']. '{2,}/', $REX['ADDON']['seo42']['settings']['urlencode_whitespace_replace'], $name); // convert multiple whitespaces replacments to one

      // lowercase conversion
      if ($REX['ADDON']['seo42']['settings']['urlencode_lowercase']) {
        $name = mb_strtolower($name, 'UTF-8');
      }

      // finally do url encode
      $name = rawurlencode($name);
    }
    else
    {
      $name = strtolower(seo42_parse_article_name($name, $article_id, $clang));
      $name = str_replace('+',$REX['ADDON']['seo42']['settings']['url_whitespace_replace'],$name);
    }

    // SANITIZE LAST CHARACTER
    $name = rtrim($name,'-');

    $path .= $name.'/';
  }
  return $path;
}


/**
* re-implemented from Redaxo core with added EP
*
* replaces special chars in article name
* @param $name       (string) article name
* @param $article_id (string) article id
* @param $clang      (string) clang
*/
function seo42_parse_article_name($name, $article_id, $clang)
{
  global $REX, $I18N;

  static $firstCall = true;
  static $translation = array();

	if($firstCall) {
		$globalSpecialChars = explode('|', $REX['ADDON']['seo42']['settings']['global_special_chars']);
		$globalSpecialCharsRewrite = explode('|', $REX['ADDON']['seo42']['settings']['global_special_chars_rewrite']);

		foreach ($REX['CLANG'] as $clangId => $clangName) {
			$inheritedClangId = seo42_utils::getInheritedClang($clangId);

			if (isset($REX['ADDON']['seo42']['settings']['lang'][$inheritedClangId]['special_chars']) && isset($REX['ADDON']['seo42']['settings']['lang'][$inheritedClangId]['special_chars_rewrite'])) {
				$specialChars = explode('|', $REX['ADDON']['seo42']['settings']['lang'][$inheritedClangId]['special_chars']);
				$specialCharsRewrite = explode('|', $REX['ADDON']['seo42']['settings']['lang'][$inheritedClangId]['special_chars_rewrite']);
			} else {
				$specialChars = array();
				$specialCharsRewrite = array();
			}

			$translation[$clangId] = array(
				'search'  => array_merge($specialChars, $globalSpecialChars),
				'replace' => array_merge($specialCharsRewrite, $globalSpecialCharsRewrite)
			);
		}

		$firstCall = false;
	}

  // SANITIZE STUFF
  $name = trim($name, " \t\r\n-.");
  $name = str_replace('/', '-', $name);
  $name = str_replace('.', '-', $name);

  $parsedName =
    // + durch - ersetzen
    str_replace('+','-',
        // ggf uebrige zeichen url-codieren
        urlencode(
          // mehrfach hintereinander auftretende spaces auf eines reduzieren
          preg_replace('/ {2,}/',' ',
            // alle sonderzeichen raus
            preg_replace('/[^a-zA-Z_\-0-9 ]/', '',
              // sprachspezifische zeichen umschreiben
              str_replace($translation[$clang]['search'], $translation[$clang]['replace'], $name)
            )
          )
        )
    );

	$parsedName = trim($parsedName, "-"); // "• articlename" was "-articlename"

	// SANITIZE MULTIPLE "-" IN PATHNAME
	$parsedName = preg_replace('/[-]{1,}/', $REX['ADDON']['seo42']['settings']['url_whitespace_replace'], $parsedName);

    return $parsedName;
}
