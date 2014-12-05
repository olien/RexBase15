$image_widths['header_xs'] = 480;
$image_widths['header_sm'] = 768;
$image_widths['header_md'] = 992;
$image_widths['header_lg'] = 1200;

<?php

$image = 'REX_MEDIA[1]';

  $imagetype    = 'headerimage_desktop';
  $suffix       = '_header_md';


if ($REX["MOBILE"]->isTablet()) {
  $imagetype    = '_header_sm';
  $suffix =     '_header_sm';
} else if ($REX["MOBILE"]->isMobile()) {
  $imagetype    = '_header_xs';
  $suffix =     '_header_xs';
}

$parts = explode('.', $image);
$ext = array_pop($parts);

$new_name = implode('.',$parts) . $suffix . '.' . $ext;
$thumbnail = OOMedia::getMediaByFilename($new_name);
if ($thumbnail instanceof OOMedia) {
  $thumb = $new_name;
} else {
  $thumb = $image;
}

echo '<img style width="100%" src="index.php?rex_img_type='.$imagetype.'&amp;rex_img_file='.$thumb.'" alt="" />';


?>

<?php
/*
$image_widths['header_xs'] = 480;
$image_widths['header_sm'] = 768;
$image_widths['header_md'] = 992;
$image_widths['header_lg'] = 1200;

$image = 'REX_MEDIA[1]';

if ($image != '') {

    $o = OOMedia::getMediaByFilename($image);

    if ($o instanceof OOMedia) {

        $parts = pathinfo($image);
        $filename = $parts['filename'];
        $extension = $parts['extension'];

        $srcset = array();

        foreach ($image_widths as $breakpoint => $width) {

            $file = $filename . '_' . $breakpoint .'.' . $extension;

            $temp = OOMedia::getMediaByFilename($file);
            if ($temp instanceof OOMedia) {
                $srcset[] = '/files/' . $file . ' ' . $width . 'w';
            } else {
                $srcset[] = '/index.php?rex_img_type=' . $breakpoint . '&amp;rex_img_file=' . $image . ' ' . $width . 'w';
            }
        }

          echo '<img  style="width:100%" src="/files/' . $image . '" srcset="' . implode(',', $srcset) . '" alt="' . htmlspecialchars( $o->getTitle() ) . '" />';
    }


}
*/
?>
