<?php

if ('REX_MEDIA[1]') {

$image = 'REX_MEDIA[1]';

if ($REX["MOBILE"]->isMobile() && ! $REX["MOBILE"]->isTablet()) {
    $suffix = '_phone';
} else if ($REX["MOBILE"]->isTablet()) {
    $suffix = '_tablet';
} else {
    $suffix = '_desktop';
}

  $parts = explode('.', $image);
  $new_name = $parts[0] . $suffix . '.' . $parts[1];
  $thumbnail = OOMedia::getMediaByFilename($new_name);

if ($thumbnail instanceof OOMedia) {
    $thumb = $new_name;
  } else {
    $thumb = $image;
  }

  echo '<img src="/files/'.$thumb.'" alt="" width="100%">';


} else {
  echo 'Es wurde kein Bild angegeben';
}



?>

