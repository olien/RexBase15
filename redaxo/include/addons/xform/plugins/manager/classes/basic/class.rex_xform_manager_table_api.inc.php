<?php

class rex_xform_manager_table_api
{

    static $table_fields = array('status', 'name', 'description', 'list_amount', 'list_sortfield', 'list_sortorder', 'prio', 'search', 'hidden', 'export', 'import');
    static $debug = false;

    // ---------- TABLES

    public static function setTable(array $table, array $table_fields = array())
    {

        if (!isset($table['table_name'])) {
            throw new Exception('table[table_name] must be set');
        }
        $table_name = $table['table_name'];

        $currentTable = self::getTable($table_name);

        if (count($currentTable) == 0) {

            // Insert
            $table_insert = new rex_sql;
            $table_insert->debugsql = self::$debug;
            $table_insert->setTable(rex_xform_manager_table::$db_table_table);
            $table_insert->setValue('table_name', $table_name);

            if (!isset($table['name']) || $table['name'] == '') {
                $table['name'] = $table['table_name'];
            }

            foreach (self::$table_fields as $field) {
                if (isset($table[$field])) {
                    $table_insert->setValue($field, $table[$field]);
                }
            }
            if (!isset($table['prio'])) {
                $table_insert->setValue('prio', rex_xform_manager_table::getMaximumTablePrio() + 1);
            }
            $table_insert->insert();

        } else {

            // Update
            foreach (self::$table_fields as $field) {
                if (isset($table[$field])) {
                    $currentTable[$field] = $table[$field];
                }
            }

            if (!isset($table['name']) || $table['name'] == '') {
                $table['name'] = $table['table_name'];
            }

            $table_update = new rex_sql;
            $table_update->debugsql = self::$debug;
            $table_update->setTable(rex_xform_manager_table::$db_table_table);
            $table_update->setWhere('table_name = "' . mysql_real_escape_string($table_name) . '"');

            foreach (self::$table_fields as $field) {
                if (isset($table[$field])) {
                    $table_update->setValue($field, $table[$field]);
                }
            }
            $table_update->update();

        }

        if (count($table_fields) > 0) {
            foreach ($table_fields as $field) {
                self::setTableField($table_name, $field);
            }
        }

        self::generateTablesAndFields();

        return self::getTable($table_name);

    }

    public static function setTables(array $tables)
    {
        foreach ($tables as $table) {
            self::setTable($table);
        }
    }

    public static function getTable( $table_name )
    {

        $t = rex_sql::factory();
        $t->debugsql = self::$debug;
        $tables = $t->getArray('select * from ' . rex_xform_manager_table::$db_table_table . ' where table_name="' . mysql_real_escape_string($table_name) . '"');

        if (count($tables) > 1) {
            throw new Exception('only one tabledefinition is allowed. ' . count($tables) . ' are found [' . $table_name . '');

        } elseif (count($tables) == 1) {
            return $tables[0];

        } else {
            return array();

        }

    }

    public static function exportTableset( $table_name )
    {
        $export = array();
        $export_table = rex_xform_manager_table_api::getTable( $table_name );
        $export_fields = rex_xform_manager_table_api::getTableFields( $table_name );

        $export[$export_table['table_name']] = array(
            'table' => $export_table,
            'fields' => $export_fields,
        );

        return json_encode($export);

    }

    public static function importTablesets( $tableset_content )
    {
        $tableset_content = json_decode($tableset_content, true);
        foreach($tableset_content as $table) {
          if (!isset($table["table"]) || !isset($table["fields"])) {
              throw new Exception('json format wrong');
          }
          $settable = $table["table"];
          $fields = $table["fields"];
          rex_xform_manager_table_api::setTable($settable, $fields);
        }
        rex_xform_manager_table_api::generateTablesAndFields();
        return true;
    }

    public static function exportTablesets( $table_names )
    {
        $export = array();
        foreach($table_names as $table_name) {
            $export_table = rex_xform_manager_table_api::getTable( $table_name );
            $export_fields = rex_xform_manager_table_api::getTableFields( $table_name );
            $export[$export_table['table_name']] = array(
            'table' => $export_table,
            'fields' => $export_fields,
            );
        }

        return json_encode($export);

    }




    public static function getTables()
    {

        $t = rex_sql::factory();
        $t->debugsql = self::$debug;
        return $t->getArray('select * from ' . rex_xform_manager_table::$db_table_table . ' order by prio');

    }


    public static function removeTable($table_name)
    {
        $t = rex_sql::factory();
        $t->debugsql = self::$debug;
        $t->setQuery('delete from ' . rex_xform_manager_table::$db_table_table . ' where table_name="' . mysql_real_escape_string($table_name) . '"');

        $remove_fields = self::getTableFields($table_name, array());
        foreach ($remove_fields as $remove_field) {
            self::removeTablefield($table_name, $remove_field);
        }

    }




    // ---------- FIELDS

    public static function setTableField($table_name, array $table_field)
    {
        if ($table_name == '') {
            throw new Exception('table_name must be set');
        }

        if (count($table_field) == 0) {
            throw new Exception('field must be a filled array');
        }

        $fieldIdentifier = array(
            'type_id' => $table_field['type_id'],
            'type_name' => $table_field['type_name'],
            'name' => $table_field['name']
        );

        $currentFields = self::getTableFields($table_name, $fieldIdentifier);

        // validate specials
        if ($table_field['type_id'] == 'validate') {
            $table_field['list_hidden'] = 1;
            $table_field['search'] = 0;
        }

        self::createMissingFieldColumns($table_field);

        if (count($currentFields) > 1) {
            throw new Exception('more than one field found for table: ' . $table_name . ' with Fieldidentifier: ' . implode(', ', $fieldIdentifier) . '');

        } elseif (count($currentFields) == 0) {

            // Insert
            $field_insert = new rex_sql;
            $field_insert->debugsql = self::$debug;
            $field_insert->setTable(rex_xform_manager_table::$db_field_table);
            $field_insert->setValue('table_name', $table_name);

            foreach ($table_field as $field_name => $field_value) {
                $field_insert->setValue($field_name, $field_value);
            }
            if (!isset($table['prio'])) {
                $field_insert->setValue('prio', rex_xform_manager_table::getMaximumPrio($table_name) + 1);
            }
            $field_insert->insert();

        } else {

            // Update
            $currentField = $currentFields[0];
            foreach ($table_field as $field_name => $field_value) {
                $currentField[$field_name] = $field_value;
            }

            $field_update = new rex_sql;
            $field_update->debugsql = self::$debug;
            $field_update->setTable(rex_xform_manager_table::$db_field_table);

            $add_where = array();
            foreach ($fieldIdentifier as $field => $value) {
                $add_where[] = '`' . mysql_real_escape_string($field) . '`="' . mysql_real_escape_string($table_name) . '"';
            }

            $where = 'table_name="' . mysql_real_escape_string($table_name) . '"';
            if (count($add_where) > 0) {
                $where .= ' and (' . implode(' and ', $add_where) . ') ';

            }

            $field_update->setWhere($where);

            foreach ($table_field as $field_name => $field_value) {
                $field_update->setValue($field_name, $field_value);
            }
            $field_update->update();

        }

    }

    public static function getTableFields($table_name, array $fieldIdentifier = array())
    {

        $add_where = array();
        foreach ($fieldIdentifier as $field => $value) {
            $add_where[] = '`' . mysql_real_escape_string($field) . '`="' . mysql_real_escape_string($value) . '"';
        }

        $where = ' where table_name="' . mysql_real_escape_string($table_name) . '"';
        if (count($add_where) > 0) {
            $where .= ' and (' . implode(' and ', $add_where) . ') ';

        }

        $f = rex_sql::factory();
        $f->debugsql = self::$debug;
        return $f->getArray('select * from ' . rex_xform_manager_table::$db_field_table . $where . ' order by prio');

    }

    public static function removeTablefield($table_name, array $fieldIdentifier)
    {

        $add_where = array();
        foreach ($fieldIdentifier as $field => $value) {
            $add_where[] = '`' . mysql_real_escape_string($field) . '`="' . mysql_real_escape_string($value) . '"';
        }

        $where = ' where table_name="' . mysql_real_escape_string($table_name) . '"';
        if (count($add_where) > 0) {
            $where .= ' and (' . implode(' and ', $add_where) . ') ';

        }

        $f = rex_sql::factory();
        $f->debugsql = self::$debug;
        return $f->getArray('delete from ' . rex_xform_manager_table::$db_field_table . $where);

    }



    // ---------- MIGRATION und Erstellung

    public static function migrateTable($table_name, $convert_id = false)
    {
        global $REX;
        $columns = rex_sql::showColumns($table_name);

        if (count($columns) == 0) {
            throw new Exception( '`' . $table_name . '` does not exists or no fields available');

        }

        $table = array(
            'table_name' => $table_name,
            'status' => 1
        );

        $autoincrement = array();
        foreach ($columns as $column) {
            if ($column['extra'] == 'auto_increment') {
                $autoincrement = $column;
            }
        }

        if (count($autoincrement) > 0 && $autoincrement['name'] == 'id') {
            // everything is ok

        } elseif ($convert_id && count($autoincrement) > 1) {
            rex_sql::factory()->setQuery('ALTER TABLE `' . mysql_real_escape_string($table_name) . '` CHANGE `' . mysql_real_escape_string($autoincrement['name']) . '` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ');
            $columns = rex_sql::showColumns($table_name);

        } else {
            throw new Exception( '`id`-field with auto_increment is missing.');

        }

        self::setTable($table);

        foreach ($columns as $column) {
            if ($column['name'] != 'id') {
                self::migrateField($table_name, $column);

            }

        }

    }

    static function migrateField($table_name, $column)
    {
        if ($column['name'] == 'id') {
            return array();
        }

        $fields = array();

        preg_match('@^(.*)\((.*)\)@i', $column['type'], $r);

        if (isset($r[1])) {
            $column['clean_type'] = $r[1];
            $column['length'] = $r[2];
        } else {
            $column['clean_type'] = $column['type'];
            $column['length'] = null;
        }

        switch ($column['clean_type']) {

            case 'varchar':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'text',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );

                $fields[] = array(
                    'type_id' => 'validate',
                    'type_name' => 'size_range',
                    'name' => $column['name'],
                    'max' => $column['length'],
                    'message' => 'error: size max in ' . $column['name'] . ' is ' . $column['length']
                );

                if (preg_match('/(?:^|_)e?mail(?:address|adresse)?(?:_|$)/', $column['name'])) {
                    $fields[] = array(
                        'type_id' => 'validate',
                        'type_name' => 'type',
                        'name' => $column['name'],
                        'type' => 'email',
                        'not_required' => 'YES' === $column['null'],
                        'message' => $column['name'] . ' must be a valid email address',
                    );
                }

                break;

            case 'char':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'text',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );

                /*
                $fields[] = array(
                  'type_id' => 'validate',
                  'type_name' => 'size',
                  'name' => $column["name"],
                  'size' => $column['length'],
                  'message' => 'error: size max in '.$column["name"].' is '.$column['length']
                );
                */

                break;

            case 'enum':
                $options = array_map(function ($option) {
                    $option = trim($option, '\'" ');
                    return $option . '=' . $option;
                }, explode(',', $column['length']));

                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'select',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'options' => implode(',', $options),
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );

                break;

            case 'set':
                $options = array_map(function ($option) {
                    $option = trim($option, '\'" ');
                    return $option . '=' . $option;
                }, explode(',', $column['length']));

                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'select',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'options' => implode(',', $options),
                    'default' => (string) $column['default'],
                    'multiple' => 1,
                    'no_db' => 0
                );

                break;

            case 'tinyint':
                if (1 == $column['length']) {
                    $sql = rex_sql::factory();
                    $sql->setQuery('SELECT * FROM `' . $sql->escape($table_name) . '` WHERE `' . $sql->escape($column['name']) . '` NOT IN (0, 1) LIMIT 1');
                    if (!$sql->getRows()) {
                        $fields[] = array(
                            'type_id' => 'value',
                            'type_name' => 'checkbox',
                            'name' => $column['name'],
                            'label' => $column['name'],
                            'default' => (string) $column['default'],
                            'no_db' => 0
                        );
                        break;
                    }
                }
                // no break
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'bigint':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'text',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );

                $fields[] = array(
                    'type_id' => 'validate',
                    'type_name' => 'type',
                    'name' => $column['name'],
                    'type' => 'int',
                    'not_required' => 'YES' === $column['null'],
                    'message' => $column['name'] . ' must be an integer',
                );

                break;

            case 'float':
            case 'double':
            case 'decimal':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'text',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );

                $fields[] = array(
                    'type_id' => 'validate',
                    'type_name' => 'type',
                    'name' => $column['name'],
                    'type' => 'float',
                    'not_required' => 'YES' === $column['null'],
                    'message' => $column['name'] . ' must be a float',
                );
                break;

            case 'date':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'date',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );
                break;

            case 'time':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'time',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );
                break;

            case 'datetime':
            case 'timestamp':
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'datetime',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );
                break;

            case 'blob':
            case 'tinyblob':
            case 'mediumblob':
            case 'longblob':
            case 'year':
            case 'binary':
            case 'varbinary':
                // do nothing.
                break;

            case 'text':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
            default:
                $fields[] = array(
                    'type_id' => 'value',
                    'type_name' => 'textarea',
                    'name' => $column['name'],
                    'label' => $column['name'],
                    'default' => (string) $column['default'],
                    'no_db' => 0
                );
                break;

        }

        foreach ($fields as $field) {
            self::setTableField($table_name, $field);
        }

    }

    static function createMissingFieldColumns($field)
    {
        $columns = array();
        foreach (rex_sql::showColumns(rex_xform_manager_table::$db_field_table) as $column) {
            $columns[$column['name']] = true;
        }

        $alterTable = array();
        foreach ($field as $column => $value) {
            if (!isset($columns[$column])) {
                $alterTable[] = 'ADD `' . mysql_real_escape_string($column) . '` TEXT NOT NULL';
            }
            $columns[$column] = true;
        }

        if (count($alterTable)) {
            $alter = rex_sql::factory();
            $alter->debugsql = self::$debug;
            $alter->setQuery('ALTER TABLE `' .  rex_xform_manager_table::$db_field_table . '` ' . implode(',', $alterTable));
        }

    }

    static function generateTablesAndFields($delete_old = false)
    {

        $types = rex_xform::getTypeArray();
        foreach (self::getTables() as $table) {

            $c = rex_sql::factory();
            $c->debugsql = self::$debug;
            $c->setQuery('CREATE TABLE IF NOT EXISTS `' . $table['table_name'] . '` ( `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY )');

            // remember fields, create and in case delete
            $c->setQuery('SHOW COLUMNS FROM `' . $table['table_name'] . '`');
            $saved_columns = $c->getArray();

            foreach (self::getTableFields($table['table_name']) as $field) {
                $type_name = $field['type_name'];
                $type_id = $field['type_id'];

                if ($type_id == 'value') {
                    $type_label = $field['name'];
                    $dbtype = $types[$type_id][$type_name]['dbtype'];

                    if ($dbtype != 'none' && $dbtype != '') {
                        if (
                            isset($types[$type_id][$type_name]['hooks']['preCreate']) &&
                            false === call_user_func($types[$type_id][$type_name]['hooks']['preCreate'], $field)
                        ) {
                            continue;
                        }
                        $add_column = true;
                        foreach ($saved_columns as $uu => $vv) {
                            if ($vv['Field'] == $type_label) {
                                $add_column = false;
                                unset($saved_columns[$uu]);
                                break;
                            }
                        }

                        if ($add_column) {
                            $c->setQuery('ALTER TABLE `' . $table['table_name'] . '` ADD `' . $type_label . '` ' . $dbtype . ' NOT NULL');
                        }
                    }

                }

            }

            if ($delete_old === true) {
                foreach ($saved_columns as $uu => $vv) {
                    if ($vv['Field'] != 'id') {
                        $c->setQuery('ALTER TABLE `' . $table['table_name'] . '` DROP `' . $vv['Field'] . '` ');
                    }
                }
            }

        }
    }


}
