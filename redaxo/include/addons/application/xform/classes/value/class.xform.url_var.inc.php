<?php


class rex_xform_url_var extends rex_xform_abstract
{

    function enterObject()
    {

        if ($this->getValue() == '' && !$this->params['send']) {
            $this->setValue($this->getElement(3));
        }


    $test = 'Kein Eintrag ausgew&auml;hlt!';

    $tid = rex_request('tid','int','');


	if ($tid != 0 ) {

	$sql = rex_sql::factory();
	$sql->debugsql = 0; //Ausgabe Query

	$sql->setQuery('
		SELECT * FROM rex_test WHERE id = '.$tid
	);


    if ($sql->getRows()>0) {
			$test	= $sql->getValue('name');
    }



	}



		$this->params["form_output"][$this->getElement(0)] = '
			<p class="formtext formlabel-'.$this->label.'">
				<label class="text" for="el_' . $this->id . '" >'.$this->label.'</label>
				<input type="text" class="text training inp_disabled" disabled="disabled" name="FORM[' .
				$this->params["form_name"] . '][el_' . $this->id . ']" id="el_' . $this->id . '" value="' .
				$test.'" />
			</p>
		';

		$this->params['value_pool']['email']['vars'] = $test;







    }

    function getDescription()
    {
        return 'url_var -> Beispiel: url_var|name|label|defaultwert';
    }
}
