<hr/>

<?php

$image = 'REX_MEDIA[1]';

  $suffix = '_header_desktop';

if ($REX["MOBILE"]->isMobile()) {
  $suffix = '_header_mobil';
}

if ($REX["MOBILE"]->isTablet()) {
  $suffix = '_header_tablet';
}

$parts = explode('.', $image);
$new_name = $parts[0] . $suffix . '.' . $parts[1];
$thumbnail = OOMedia::getMediaByFilename($new_name);
if ($thumbnail instanceof OOMedia) {
  $thumb = $new_name;
} else {
  $thumb = $image;
}

echo '<img src="./files/'.$thumb.'"" alt="" />'


?>

<?php

$image = 'REX_MEDIA[1]';

  $suffix = '_header_tablet';

if ($REX["MOBILE"]->isMobile()) {
  $suffix = '_header_mobil';
}

if ($REX["MOBILE"]->isTablet()) {
  $suffix = '_header_tablet';
}

$parts = explode('.', $image);
$new_name = $parts[0] . $suffix . '.' . $parts[1];
$thumbnail = OOMedia::getMediaByFilename($new_name);
if ($thumbnail instanceof OOMedia) {
  $thumb = $new_name;
} else {
  $thumb = $image;
}

echo '<img src="./files/'.$thumb.'"" alt="" />'


?>


<?php

$image = 'REX_MEDIA[1]';

  $suffix = '_header_mobile';

if ($REX["MOBILE"]->isMobile()) {
  $suffix = '_header_mobil';
}

if ($REX["MOBILE"]->isTablet()) {
  $suffix = '_header_tablet';
}

$parts = explode('.', $image);
$new_name = $parts[0] . $suffix . '.' . $parts[1];
$thumbnail = OOMedia::getMediaByFilename($new_name);
if ($thumbnail instanceof OOMedia) {
  $thumb = $new_name;
} else {
  $thumb = $image;
}

echo '<img src="./files/'.$thumb.'"" alt="" />'


?>
