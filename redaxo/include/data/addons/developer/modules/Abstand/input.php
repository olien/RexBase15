<?php

$objForm = new mform();

// TEXT

$objForm->addHtml('<div id="text">');
$objForm->addTextField(1,array('label'=>'Abstand in PX','style'=>'width:500px'));
$objForm->addDescription('Sofern das Feld leer gelassen wird wird ein default Abstand von : 50px benutzt');
$objForm->addHtml('</div>');


echo $objForm->show_mform();

?>

