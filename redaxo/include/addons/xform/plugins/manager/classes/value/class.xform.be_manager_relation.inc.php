<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_be_manager_relation extends rex_xform_abstract
{
    static $xform_list_values = array();

    protected $relation;

    function enterObject()
    {
        global $REX, $I18N;

        // ---------- CONFIG & CHECK

        $this->relation = array();
        $this->relation['source_table'] = $this->params['main_table']; // "rex_em_data_" wegcutten
        $this->relation['label'] = $this->getElement(2);  // HTML Bezeichnung

        $this->relation['target_table'] = $this->getElement('table'); // Zieltabelle
        $this->relation['target_field'] = $this->getElement('field'); // Zielfield welches angezeigt wird.

        $this->relation['relation_type'] = (int) $this->getElement(5); // select single = 0 / select multiple = 1 / popup single = 2 / popup multiple = 3
        if ($this->relation['relation_type'] > 4) {
            $this->relation['relation_type'] = 0;
        }

        $this->relation['eoption'] = (int) $this->getElement(6); // "Leer" Option

        $this->relation['size'] = (int) $this->getElement(8); // boxsize
        if ($this->relation['size'] < 1) {
            $this->relation['size'] = 5;
        }

        if ($this->relation['eoption'] != 1) {
            $this->relation['eoption'] = 0;
        }
        $this->relation['disabled'] = false;

        // ---------- Datensatz existiert bereits, Values aus verknüpfungstabelle holen
        if ($this->params['main_id'] > 0 && $this->params['send'] == 0) {
            $values = array();
            if (trim($this->getValue()) != '') {
                $values = explode(',', $this->getValue());
            } elseif ($this->getElement('relation_table')) {
                $values = $this->getRelationTableValues();
            }
            $this->setValue($values);
            // echo '<pre>++ ';var_dump($this->getValue());echo '</pre>';
        }


        // ---------- connected, fix values
        if (isset($this->params['rex_xform_set'][$this->getName()]) && !is_array($this->params['rex_xform_set'][$this->getName()])) {

            $values = $this->getValue();
            $values[] = $this->params['rex_xform_set'][$this->getName()];
            $this->setValue($values);
            $this->relation['disabled'] = true;
        }


        // ---------- Value angleichen -> immer Array mit IDs daraus machen
        if (!is_array($this->getValue())) {

            if (trim($this->getValue()) == '') {
                $this->setValue(array());
            } else {
                $this->setValue(explode(',', $this->getValue()));
            }
        }

        // ---------- (array) $this->getValue()
        // echo '<hr /><pre>'; var_dump($this->getValue()); echo '</pre>';

        // ---------- Filter

        $filter = array();
        if ($rawFilter = $this->getElement('filter')) {
            $rawFilter = preg_split('/\v+/', $rawFilter);
            $setValue = function ($key, $value) use (&$filter) {
                if (false !== strpos($key, '.')) {
                    list($key1, $key2) = explode('.', $key, 2);
                    $filter[$key1][$key2] = $value;
                } else {
                    $filter[$key] = $value;
                }
            };
            foreach ($rawFilter as $f) {
                $f = explode('=', $f, 2);
                if (2 === count($f)) {
                    $key = trim($f[0]);
                    $value = trim($f[1]);
                    if (preg_match('/^###(.+)###$/', $value, $matches)) {
                        $value = $matches[1];
                        if (false !== strpos($value, '.')) {
                            $value = explode('.', $value);
                            $relation = rex_xform_manager_table::getRelation($this->params['main_table'], $value[0]);
                            $value[0] = $this->getValueForKey($value[0]);
                            if ($value[0] && $relation) {
                                $relationSql = rex_sql::factory();
                                //$relationSql->debugsql = true;
                                $tables = '`' . $relationSql->escape($relation['table']) . '` t0';
                                for ($i = 1; $i < count($value) - 1; ++$i) {
                                    $relation = rex_xform_manager_table::getRelation($relation['table'], $value[$i]);
                                    $tables .= ' LEFT JOIN `' . $relationSql->escape($relation['table']) . '` t' . $i . ' ON t' . $i . '.id = t' . ($i - 1) . '.`' . $relationSql->escape($value[$i]) . '`';
                                }
                                $relationSql->setQuery('SELECT t' . ($i-1) . '.`' . $relationSql->escape($value[$i]) . '` FROM ' . $tables . ' WHERE t0.id = ' . (int) $value[0]);
                                if ($relationSql->getRows()) {
                                    $setValue($key, $relationSql->getValue($value[$i]));
                                }
                            }
                        } elseif ($value = $this->getValueForKey($value)) {
                            $setValue($key, $value);
                        }
                    } else {
                        $setValue($key, $value);
                    }
                }
            }
        }
        if (isset($this->params['rex_xform_set'][$this->getName()]) && is_array($this->params['rex_xform_set'][$this->getName()])) {
            $filter = array_merge($filter, $this->params['rex_xform_set'][$this->getName()]);
        }

        // ---------- check values
        $options = array();
        $valueName = '';
        $values = array();
        if (count($this->getValue()) > 0) {
            $listValues = self::getListValues($this->relation['target_table'], $this->relation['target_field'], $filter);
            foreach ($this->getValue() as $v) {
                if (isset($listValues[$v])) {
                    $values[] = $v;
                    $options[$v] = $listValues[$v] . ' [id=' . $v . ']';
                    $valueName = $options[$v];
                }
            }

            $this->setValue($values);
        }

        // ---------- (array) $this->getValue()
        // echo '<pre>'; var_dump($this->getValue()); echo '</pre>';


        // ---------- empty option ?

        if ($this->params['send'] == 1 && $this->relation['eoption'] == 0 && count($this->getValue()) == 0) {
            // Error. Fehlermeldung ausgeben
            $this->params['warning'][] = $this->params['error_class'];
            $this->params['warning_messages'][] = $this->getElement(7);
        }

        // --------------------------------------- Selectbox, single 0 or multiple 1

        if ($this->relation['relation_type'] < 2) {

            // ----- SELECT BOX
            $options = array();
            if ($this->relation['relation_type'] == 0 && $this->relation['eoption'] == 1) {
                $options[''] = '-';
            }
            foreach (self::getListValues($this->relation['target_table'], $this->relation['target_field'], $filter) as $id => $name) {
                if (strlen($name) > 50) {
                    $name = substr($name, 0, 45) . ' ... ';
                }
                $options[$id] = $name . ' [id=' . $id . ']';
            }

            $this->params['form_output'][$this->getId()] = $this->parse('value.be_manager_relation.tpl.php', compact('options'));

        }


        // ------------------------------------ POPUP, single, multiple 1-1, n-m

        if ($this->relation['relation_type'] == 2 || $this->relation['relation_type'] == 3) {

            $link = 'index.php?page=xform&subpage=manager&tripage=data_edit&table_name=' . $this->relation['target_table'];
            foreach ($filter as $key => $value) {
                $link .= '&rex_xform_filter[' . $key . ']=' . $value . '&rex_xform_set[' . $key . ']=' . $value;
            }
            $this->params['form_output'][$this->getId()] = $this->parse('value.be_manager_relation.tpl.php', compact('valueName', 'options', 'link'));

        }


        // --------------------------------------- POPUP, 1-n

        $addFilterParams = function (&$link, array $filter) use (&$addFilterParams) {
            foreach ($filter as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $addFilterParams($link, array($key . '][' . $k => $v));
                    }
                } else {
                    $link .= '&rex_xform_filter[' . $key . ']=' . $value . '&rex_xform_set[' . $key . ']=' . $value;
                }
            }
        };

        if ($this->relation['relation_type'] == 4) {
            $filter[$this->relation['target_field']] = $this->params['main_id'];
            $link = 'index.php?page=xform&subpage=manager&tripage=data_edit&table_name=' . $this->relation['target_table'];
            $addFilterParams($link, $filter);
            $this->params['form_output'][$this->getId()] = $this->parse('value.be_manager_relation.tpl.php', compact('valueName', 'options', 'link'));

        }


        // --------------------------------------- save

        $this->params['value_pool']['email'][$this->getName()] = stripslashes(implode(',', $this->getValue()));
        if (!$this->getElement('relation_table')) {
            $this->params['value_pool']['sql'][$this->getName()] = implode(',', array_unique($this->getValue()));
        }
    }




    // -------------------------------------------------------------------------

    /*
     * postAction wird nach dem Speichern ausgef�hrt
     * hier wird entsprechend der entities
     */
    function postAction()
    {
        global $REX;

        if (!$relationTable = $this->getElement('relation_table')) {
            return;
        }

        // $this->params["debug"] = TRUE;

        $source_id = -1;
        if (isset($this->params['value_pool']['email']['ID']) && $this->params['value_pool']['email']['ID'] > 0) {
            $source_id = (int) $this->params['value_pool']['email']['ID'];
        }
        if ($source_id < 1 && isset($this->params['main_id']) && $this->params['main_id'] > 0) {
            $source_id = (int) $this->params['main_id'];
        }

        if ($source_id < 1 || $this->params['main_table'] == '') {
            return false;
        }

        $relationTableField = $this->getRelationTableFields();
        if (!$relationTableField['source'] || !$relationTableField['target']) {
            return;
        }

        // ----- Value angleichen -> immer Array mit IDs daraus machen
        $values = array();
        if (!is_array($this->getValue())) {
            if (trim($this->getValue()) != '') {
                $values = explode(',', $this->getValue());
            }
        } else {
            $values = $this->getValue();
        }
        $values = array_map('intval', $values);

        $sql = rex_sql::factory();
        $sql->debugsql = $this->params['debug'];
        $relationTablePreEditValues = $this->getRelationTableValues();
        foreach ($values as $value) {
            if (!isset($relationTablePreEditValues[$value])) {
                $sql->setTable($relationTable);
                $sql->setValue($relationTableField['source'], $source_id);
                $sql->setValue($relationTableField['target'], $value);
                $sql->insert();
            }
        }
        $sql->flushValues();
        $sql->setTable($relationTable);
        $sql->setWhere('`' . $sql->escape($relationTableField['source']) . '`=' . $source_id . ' AND `' . $sql->escape($relationTableField['target']) . '` NOT IN (' . implode(',', $values) . ')');
        $sql->delete();

    }

    // -------------------------------------------------------------------------


    /*
     * Allgemeine Beschreibung
     */
    function getDescription()
    {
        // label,bezeichnung,tabelle,tabelle.feld,relationstype,style,no_db
        // return "be_em_relation -> Beispiel: ";
        return '';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'be_manager_relation',
            'values' => array(
                'name'         => array( 'type' => 'name',    'label' => 'Name' ),
                'label'        => array( 'type' => 'text',    'label' => 'Bezeichnung'),
                'table'        => array( 'type' => 'table',   'label' => 'Ziel Tabelle'),
                'field'        => array( 'type' => 'text',    'label' => 'Ziel Tabellenfeld(er) zur Anzeige oder Zielfeld'),
                'type'         => array( 'type' => 'select',  'label' => 'Mehrfachauswahl', 'default' => '', 'definition' => array('0' => 'select (single)', '1' => 'select (multiple)', '2' => 'popup (single)', '3' => 'popup (multiple)' , '4' => 'popup (multiple 1-n)') ), // ,popup (multiple / relation)=4
                'empty_option' => array( 'type' => 'boolean', 'label' => 'Mit "Leer-Option"' ),
                'empty_value'  => array( 'type' => 'text',    'label' => 'Fehlermeldung wenn "Leer-Option" nicht aktiviert ist.'),
                'size'         => array( 'type' => 'text', 'name' => 'boxheight',    'label' => 'Höhe der Auswahlbox'),
                'filter'       => array( 'type' => 'textarea', 'label' => 'Filter'),
                'relation_table' => array( 'type' => 'table', 'label' => 'Relationstabelle', 'empty_option' => 1),
            ),
            'description' => 'Hiermit kann man Verkn&uuml;pfungen zu anderen Tabellen setzen',
            'dbtype' => 'text',
            'hooks' => array(
                'preCreate' => function ($field) {
                    return empty($field['relation_table']) && '4' != $field['type'];
                }
            ),
        );
    }

    static function getListValue($params)
    {
        // TODO Relation table berücksichtigen

        $listValues = self::getListValues($params['params']['field']['table'], $params['params']['field']['field']);
        $return = array();
        foreach (explode(',', $params['value']) as $value) {
            if (isset($listValues[$value])) {
                $return[] = $listValues[$value];
            }
        }

        return implode('<br />', $return);
    }

    private static function getListValues($table, $field, array $filter = array())
    {
        $filterHash = sha1(json_encode($filter));
        if (!isset(self::$xform_list_values[$table][$field][$filterHash])) {
            self::$xform_list_values[$table][$field][$filterHash] = array();
            $db = rex_sql::factory();
            //$db->debugsql = true;
            $where = '';
            $join = '';
            $joinIndex = 1;
            if ($filter) {
                $where = array();
                foreach ($filter as $key => $value) {
                    if (!is_array($value)) {
                        $where[] = 't0.`' . $db->escape($key) . '` = "' . $db->escape($value) . '"';
                    } elseif ($relation = rex_xform_manager_table::getRelation($table, $key)) {
                        $join .= ' LEFT JOIN `' . $db->escape($relation['table']) . '` t' . $joinIndex . ' ON t0.`' . $db->escape($key) . '` = t' . $joinIndex . '.id';
                        foreach ($value as $k => $v) {
                            $where[] = 't' . $joinIndex . '.`' . $db->escape($k) . '` = "' . $db->escape($v) . '"';
                        }
                        $joinIndex++;
                    }
                }
                $where = ' WHERE ' . implode(' AND ', $where);
            }
            $concat = self::getNameConcatFields($field);
            $fields = array();
            foreach ($concat as $c) {
                if ($c['field']) {
                    $fields[] = 't0.`' . mysql_real_escape_string($c['name']) . '`';
                }
            }
            $tableDefinition = rex_xform_manager_table_api::getTable($table);
            $order = 't0.`' . $db->escape($tableDefinition['list_sortfield'] ?: 'id') . '` ' . ($tableDefinition['list_sortorder'] ?: 'ASC');
            $db_array = $db->getArray('select t0.id, ' . implode(', ', $fields) . ' from `' . $db->escape($table) . '` t0' . $join . $where . ' ORDER BY ' . $order);
            foreach ($db_array as $entry) {
                $value = '';
                foreach ($concat as $c) {
                    if ($c['field']) {
                        $v = $entry[$c['name']];
                        if ($relation = rex_xform_manager_table::getRelation($table, $c['name'])) {
                            $relationListValues = self::getListValues($relation['table'], $relation['field']);
                            if (isset($relationListValues[$v])) {
                                $v = $relationListValues[$v];
                            }
                        }
                        $value .= $v;
                    } else {
                        $value .= $c['name'];
                    }
                }
                self::$xform_list_values[$table][$field][$filterHash][$entry['id']] = $value;
            }
        }
        return self::$xform_list_values[$table][$field][$filterHash];
    }

    private static function getNameConcatFields($field)
    {
        preg_match_all('/(?:^|(?<=,))\s*((\'|")(.*?)\2|[^\'"\s].*?)\s*(?:(?=,)|$)/', $field, $matches, PREG_SET_ORDER);
        $concat = array();
        foreach ($matches as $match) {
            if (isset($match[2])) {
                $concat[] = array(
                    'field' => false,
                    'name' => $match[3],
                );
            } else {
                $concat[] = array(
                    'field' => true,
                    'name' => $match[1],
                );
            }
        }
        if (empty($concat)) {
            return array(array(
                'field' => true,
                'name' => 'id',
            ));
        }
        return $concat;
    }

    protected function getRelationTableFields()
    {
        return rex_xform_manager_table::getRelationTableFields(
            $this->getElement('relation_table'),
            $this->params['main_table'],
            $this->getElement('table')
        );
    }

    protected function getRelationTableValues()
    {
        $values = array();
        $relationTableFields = $this->getRelationTableFields();
        if ($relationTableFields['source'] && $relationTableFields['target']) {
            $sql = rex_sql::factory();
            $sql->debugsql = $this->params['debug'];
            $sql->setQuery('
                SELECT `' . $sql->escape($relationTableFields['target']) . '` as id
                FROM `' . $sql->escape($this->getElement('relation_table')) . '`
                WHERE `' . $sql->escape($relationTableFields['source']) . '` = ' . (int) $this->params['main_id']
            );
            while ($sql->hasNext()) {
                $id = $sql->getValue('id');
                $values[$id] = $id;
                $sql->next();
            }
        }
        return $values;
    }

}
