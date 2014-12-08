<?php

if(OOAddon::isAvailable('ymobiledetect')) {

  $objForm = new mform();
  $objForm->addMediaField(1,array('types'=>'gif,jpg,png','preview'=>0,'category'=>0,'label'=>'Datei'));
  echo $objForm->show_mform();

} else {
  echo '
<div class="rex-message" style="display: inline-block;"><div class="rex-warning" style="font-size: 15px; padding: 0 0 0 50px;">Dieses Modul benötigt das "ymobiledetect" Addon.</div></div>';

}
?>


