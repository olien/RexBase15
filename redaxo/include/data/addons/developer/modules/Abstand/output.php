<?php

	if ('REX_VALUE[1]' == '') {
		$abstand = 50;
	} else {
		$abstand = 'REX_VALUE[1]';
	}


if (!$REX['REDAXO']) {


	echo '<div class="abstand" style="height: '.$abstand.'px"></div>';



} else {


	echo '<table style="width: 100%;">'.PHP_EOL;
		echo '<tr>'.PHP_EOL;
		echo '<td style="padding: 5px; width: 100px; font-weight: bold;">Abstand</td>'.PHP_EOL;
		echo '<td style="padding: 5px;">'.$abstand.'px</td>'.PHP_EOL;
		echo '</tr>'.PHP_EOL;

	echo '</table>'.PHP_EOL;


}



?>


