<?php

class rex_xform_text_aid extends rex_xform_abstract
{

	function enterObject()
	{
	global $REX;
		$this->label = $this->getElement[1];

		if ($this->value == "" && !$send)
		{
			if (isset($this->getElement[3])) $this->value = $this->getElement[3];
		}

		$wc = "";
		if (isset($warning["el_" . $this->getId()])) $wc = $warning["el_" . $this->getId()];

    $trainingscode = 'Kein Seminar ausgew&auml;hlt!';
    $auswahl2 = '';
    $aid = rex_request('aid','int','');
    $tid = rex_request('tid','int','');


	if ($aid == 0 AND $tid == 0 ) {
	    $trainingscode = 'Kein Seminar ausgew&auml;hlt!';
	}

	if ($aid == 0) {
		$aid = $tid;
	}




	$sql = rex_sql::factory();
	$sql->debugsql = 0; //Ausgabe Query

	$sql->setQuery('
		SELECT
		*,
		date_format(startdatum1,"%d.%m.%Y")	as neu_startdatum1,
		date_format(enddatum1, 	"%d.%m.%Y") as neu_enddatum1,
		date_format(startdatum2,"%d.%m.%Y") as neu_startdatum2,
		date_format(enddatum2, 	"%d.%m.%Y") as neu_enddatum2
		FROM rex_seminar_termine WHERE id = '.$aid
	);

	$termine_content = '';

    if ($sql->getRows()>0) {


    	// rex_seminare
    		$sql_seminar = rex_sql::factory();
			$sql_seminar->debugsql = 0; //Ausgabe Query

			$sql_seminar->setQuery('SELECT * FROM rex_seminare WHERE ID = '.$sql->getValue('seminar'));
			$trainingscode			= $sql_seminar->getValue('trainingscode');
			$seminarbezeichnung		= $sql_seminar->getValue('seminarbezeichnung');
			$hinweis				= $sql->getValue('hinweis');

       	// rex_ort

    		$ort_id = $sql->getValue('ort');

    		$sql_ort = rex_sql::factory();
			$sql_ort->debugsql = 0; //Ausgabe Query

			$sql_ort->setQuery('SELECT * FROM rex_seminare_ort WHERE ID = '.$ort_id);
			$ort	= $sql_ort->getValue('ort');




			if ($sql->getValue('neu_enddatum1') != '00.00.0000') {
				$termine_content .= $sql->getValue('neu_startdatum1').' - '.$sql->getValue('neu_enddatum1').'<br/>';
		    } else if ($sql->getValue('neu_startdatum1') != '00.00.0000') {
				$termine_content .= $sql->getValue('neu_startdatum1').'<br/>';
		    }


			if ($sql->getValue('neu_startdatum2') != '00.00.0000') {
				$termine_content .= $sql->getValue('neu_startdatum2').' - '.$sql->getValue('neu_enddatum2').'<br/>';
		    }

   			if ($hinweis != '') {
				$hinweis_content .= '<p class="links">Info</p><p class="rechts">'.$hinweis.'</p>';
			}


	}

		echo '<div class="terminanzeige">'.PHP_EOL;
			echo '<p class="links">Seminar</p><p class="rechts">'.$seminarbezeichnung.'</p>';
			echo '<p class="links">Ort</p><p class="rechts">'.$ort.'</p>';
			echo '<p class="links">Termin/e</p><p class="rechts">'.$termine_content.'</p>';
			echo $hinweis_content;

		echo '</div>'.PHP_EOL;


		$this->params["form_output"][$this->getElement(0)] = '
			<p class="formtext formlabel-'.$this->label.'">
				<label class="text ' . $wc . '" for="el_' . $this->id . '" >Trainingscode</label>
				<input type="text" class="text training inp_disabled ' . $wc . '" disabled="disabled" name="FORM[' .
				$this->params["form_name"] . '][el_' . $this->id . ']" id="el_' . $this->id . '" value="' .
				$trainingscode.'" />
			</p>
		';

		$this->params['value_pool']['email']['seminarbezeichnung'] = $seminarbezeichnung;
		$this->params['value_pool']['email']['seminartermine'] = $termine_content;
		$this->params['value_pool']['email']['seminarort'] = $ort;
		$this->params['value_pool']['email']['seminarhinweis'] = $hinweis;

		// $email_getElement[$this->getElement(0)] = $auswahl2;
		// if (!isset($this->getElement(3)) || $this->getElement(3) != "no_db") $sql_getElement[$this->getElement(0)] = $this->value;

	}

	function getDescription()
	{
		return "text -> Beispiel: text_aid|label|Bezeichnung|defaultwert|[no_db]";
	}
}
?>
