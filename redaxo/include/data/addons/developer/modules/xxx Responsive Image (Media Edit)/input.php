<?php
$objForm = new mform();
$objForm->addMediaField(1,array('types'=>'gif,jpg,png','preview'=>0,'category'=>0,'label'=>'Datei'));


echo $objForm->show_mform();
?>
