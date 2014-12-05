<h3>Ausgabe Beispiel von Table Manger Daten inkl. Verlinkung.</h3>
<small>url_control (hier wird auch das Ziel definiert) / xForm Klasse beachten</small>

<?php
$id = url_generate::getId('rex_test');

if ($id > 0) {

    $datas = rex_sql::factory()->getArray('SELECT * FROM rex_test WHERE id = "' . mysql_real_escape_string($id). '"');

    if (count($datas) > 0) {
        $data = current($datas);
        echo '<br/><br/>'.$data['name'].'<br/>'.PHP_EOL;
    }

} else {
    $datas = rex_sql::factory()->getArray('SELECT * FROM rex_test');

    if (count($datas) > 0) {

        echo '<p><strong>Verlinkung auf eigene Seite</strong></p>'.PHP_EOL;

        foreach ($datas as $data) {

            echo 'Details:<a href="' . url_generate::getUrlById('rex_test', $data['id']) . '">' . $data['name'] . '</a> | Anmeldung: <a href="/ausgabe-beispiele-formular.html?tid='.$data['id'].'">' . $data['name'] . '</a><br/>';

        }

    }

}
?>

