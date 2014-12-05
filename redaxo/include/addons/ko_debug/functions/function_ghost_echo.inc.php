<?php
/**
 * Debug Addon 
 * @author stefan[ät]magnetum[punkt]de cukabeka
 * @package redaxo4
 */

/**
 * Ghost_echo gibt beliebigen Output für Eingeloggte aus
 *
 * Aufrufbeispiel:
 * $a = array(1, 2, array("a", "b", "c"));
 * ghost_echo($a);
 * 
 * @param  mixed  auszugebene Variablendaten
 * @param  mixed  Anweisungen fuer die switch-Abfrage
 *                'sql' - speziell formatierte Ausgabe
 * @param  bool   0 (default): Ausgabe erfolgt per var_export()
 *                1: Ausgabe erfolgt per var_dump()
 */
function ghost_echo($input) {
  $return = '';
      #ob_start();
      $return .= ($input);
      #$return .= "\n<pre>".ob_get_contents().'</pre><br />'."\n";
      #ob_end_clean(); 

  #flush();
  
  // setze vor die Ausgabe einen deutlichen Hinweis auf die Debug-Ausgabe
  $return = '<span style="display:none;">DEBUGOUT ghost_echo: </span>'.$return."\n";
  // gib die Debuginfos aus
  return $return;

  #return true;
}


