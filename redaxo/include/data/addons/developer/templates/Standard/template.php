<?php
header('Content-Type: text/html; charset=utf-8');



error_reporting(E_ALL); // error_reporting(0);

if ($this->getValue("article_id") == $REX['NOTFOUND_ARTICLE_ID']) {
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
}

// OFFLINE ARTIKEL UMLEITEN
if (!isset($_SESSION[$REX['INSTNAME']]['UID']) or $_SESSION[$REX['INSTNAME']]['UID']=='')
{
    if ($this->getValue('status') == 0) {
        if ($this->getValue('startpage') == 0) {
            // Weiterleitung für Artikel
            header ('HTTP/1.1 301 Moved Permanently');
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
            exit;
        } else {
            // Weiterleitung für Kategorien
            header ('HTTP/1.1 301 Moved Permanently');
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
            exit;
        }
    }
}


?><!doctype html>
  <html lang="<?php echo seo42::getLangCode(); ?>">
  <head>
    <meta charset="utf-8" />
    <base href="<?php echo seo42::getBaseUrl(); ?>" />
    <title><?php echo seo42::getTitle(); ?></title>
    <meta name="description" content="<?php echo seo42::getDescription(); ?>" />
    <meta name="keywords" content="<?php echo seo42::getKeywords(); ?>" />
    <meta name="robots" content="<?php echo seo42::getRobotRules();?>" />
    <meta name="HandheldFriendly" content="True">

    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="<?php
    echo min42::getCombinedCSSMinFile("screen.less", array(
        "responsive.less",
        "print.less"
    ));
    ?>">

    <link rel="stylesheet" href="<?php echo seo42::getCSSFile("../fonts/awesome/less/font-awesome.less"); ?>" type="text/css" media="screen,print" />


    <link rel="shortcut icon" href="<?php echo seo42::getImageFile("favicon.ico"); ?>" type="image/x-icon" />
    <link rel="canonical" href="<?php echo seo42::getCanonicalUrl(); ?>" />
    <?php echo seo42::getLangTags(); ?>



<script type="text/javascript" src="<?php
    echo min42::getCombinedJSMinFile("default.js", array(
        "/vendor/jquery-1.11.1.min.js",
        "/vendor/respimage.min.js",
        "domscript.js"
    ));
?>"></script>

</head>

<?php if ($REX['START_ARTICLE_ID'] == $this->getValue("article_id")) {
  	echo '<body id="home">'.PHP_EOL;
  } else {
  	echo '<body>'.PHP_EOL;
  }
?>
<!--[if lt IE 9]>
  <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
 <header>


    <?php // Breadcrumb - phone

    $detect = new Mobile_Detect;
    if( $detect->isMobile() && !$detect->isTablet() ){

         $P = explode("|",$this->getValue("path").$this->getValue("article_id")."|");
           if ($P[2] ) {

              $nav = rex_navigation::factory();

              echo '
              <div class="container" >
                <section id="breadcrumb" >
                  <ul class="rex-breadcrumb">
                     '.$nav->getBreadcrumb('Start',TRUE,0).'
                  </ul>
                </section>
              </div>
              <script>
                $("html, body").animate({ scrollTop: "35px" }, 400);
              </script>
              '.PHP_EOL;
            }
      }
        ?>




<div class="container">

<strong>Logo</strong>
<a class="logo" href="./" title="### link auf dem logo ###">### link auf dem logo ###</a>
<br/><br/>
<strong>Header Nav</strong>
<?php



    if(!function_exists('navIconCallback')){
        function navIconCallback($cat, $depth, &$li, &$a){
            $articleObject = OOArticle::getArticleById($cat->getValue('id'));
            if(is_object($articleObject)) {
                if($articleObject->getValue('art_fonticon') != ''){
                  $a['class'][] = 'fa '.$articleObject->getValue('art_fonticon');
//                  $li['class'][] = 'fa '.$articleObject->getValue('art_fonticon');
                }
            }
         //  print_r($a);

            return $a;
        }
    }


    $nav = rex_navigation::factory();
    $nav->addFilter("cat_navigationstyp","/\|header\|/","regex");
    $nav->addCallback('navIconCallback', 1);
    $headerNav = $nav->get(0,-1,TRUE,TRUE);
  unset($nav);

    echo $headerNav;



?>

<strong>Main Nav</strong>
<?php
  $nav = rex_navigation::factory();
  $nav->addFilter("cat_navigationstyp","/\|main\|/","regex");
  $nav_main = $nav->get(0,-1,TRUE,TRUE);
  unset($nav);
  echo $nav_main;
?>

<br/><br/>
<strong>Inhalt</strong>
REX_ARTICLE[]
<br/><br/>

<?php // Backlink
  if ($this->getValue("art_backlink") == '|1|') {
    echo '<a href="javascript:history.back();">### zurueck ###</a>'.PHP_EOL;
  }
?>
<br/><br/>

<strong>Footer Nav</strong>
<?php
  $nav = rex_navigation::factory();
  $nav->addFilter("cat_navigationstyp","/\|footer\|/","regex");
  $nav_footer = $nav->get(0,1,TRUE,TRUE);
  unset($nav);
  echo $nav_footer;
?>
<br/><br/>
<a class="top" href="javascript:void(0);" >###nach oben###</a>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <!-- script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script -->
    </body>
</html>
