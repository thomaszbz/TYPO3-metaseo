<?php

/*
 *  Copyright notice
 *
 *  (c) 2015 Markus Blaschke <typo3@markus-blaschke.de> (metaseo)
 *  (c) 2013 Markus Blaschke (TEQneers GmbH & Co. KG) <blaschke@teqneers.de> (tq_seo)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

namespace Metaseo\Metaseo\Utility;

/**
 * Database utility
 */
class DatabaseUtility
{

    ###########################################################################
    # Query functions
    ###########################################################################

    /**
     * Get row
     *
     * @param   string $query SQL query
     *
     * @return array
     */
    public static function getRow($query)
    {
        $ret = null;

        $res = self::query($query);
        if ($res) {
            if ($row = self::connection()
                ->sql_fetch_assoc($res)
            ) {
                $ret = $row;
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Execute sql query
     *
     * @param   string $query SQL query
     *
     * @return  resource
     * @throws  \Exception
     */
    public static function query($query)
    {
        $res = self::connection()
            ->sql_query($query);

        if (!$res || self::connection()
                ->sql_errno()
        ) {
            // SQL statement failed
            $errorMsg = 'SQL Error: ' . self::connection()
                    ->sql_error() . ' [errno: ' . self::connection()
                    ->sql_errno() . ']';

            if (defined('TYPO3_cliMode')) {
                throw new \Exception($errorMsg);
            } else {
                debug('SQL-QUERY: ' . $query, $errorMsg, __LINE__, __FILE__);
            }

            $res = null;
        }

        return $res;
    }

    /**
     * Get current database connection
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    public static function connection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    /**
     * Free sql result
     *
     * @param resource $res SQL resource
     */
    public static function free($res)
    {
        if ($res && $res !== true) {
            self::connection()
                ->sql_free_result($res);
        }
    }

    /**
     * Get All
     *
     * @param  string $query SQL query
     *
     * @return array
     */
    public static function getAll($query)
    {
        $ret = array();

        $res = self::query($query);
        if ($res) {
            while ($row = self::connection()
                ->sql_fetch_assoc($res)) {
                $ret[] = $row;
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Get All with index (first value)
     *
     * @param  string $query    SQL query
     * @param  string $indexCol Index column name
     *
     * @return array
     */
    public static function getAllWithIndex($query, $indexCol = null)
    {
        $ret = array();

        $res = self::query($query);
        if ($res) {
            while ($row = self::connection()
                ->sql_fetch_assoc($res)) {
                if ($indexCol === null) {
                    // use first key as index
                    $index = reset($row);
                } else {
                    $index = $row[$indexCol];
                }

                $ret[$index] = $row;
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Get List
     *
     * @param  string $query SQL query
     *
     * @return array
     */
    public static function getList($query)
    {
        $ret = array();

        $res = self::query($query);
        if ($res) {
            while ($row = self::connection()
                ->sql_fetch_row($res)) {
                $ret[$row[0]] = $row[1];
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Get column
     *
     * @param  string $query SQL query
     *
     * @return array
     */
    public static function getCol($query)
    {
        $ret = array();

        $res = self::query($query);
        if ($res) {
            while ($row = self::connection()
                ->sql_fetch_row($res)) {
                $ret[] = $row[0];
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Get column
     *
     * @param  string $query SQL query
     *
     * @return array
     */
    public static function getColWithIndex($query)
    {
        $ret = array();

        $res = self::query($query);
        if ($res) {
            while ($row = self::connection()
                ->sql_fetch_row($res)) {
                $ret[$row[0]] = $row[0];
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Get count (from query)
     *
     * @param  string $query SQL query
     *
     * @return integer
     */
    public static function getCount($query)
    {
        $query = 'SELECT COUNT(*) FROM (' . $query . ') tmp';

        return self::getOne($query);
    }

    ###########################################################################
    # Quote functions
    ###########################################################################

    /**
     * Get one
     *
     * @param  string $query SQL query
     *
     * @return mixed
     */
    public static function getOne($query)
    {
        $ret = null;

        $res = self::query($query);
        if ($res) {
            if ($row = self::connection()
                ->sql_fetch_assoc($res)
            ) {
                $ret = reset($row);
            }
            self::free($res);
        }

        return $ret;
    }

    /**
     * Exec query (INSERT)
     *
     * @param  string $query SQL query
     *
     * @return integer        Last insert id
     */
    public static function execInsert($query)
    {
        $ret = false;

        $res = self::query($query);

        if ($res) {
            $ret = self::connection()
                ->sql_insert_id();
            self::free($res);
        }

        return $ret;
    }

    /**
     * Exec query (DELETE, UPDATE etc)
     *
     * @param  string $query SQL query
     *
     * @return integer        Affected rows
     */
    public static function exec($query)
    {
        $ret = false;

        $res = self::query($query);

        if ($res) {
            $ret = self::connection()
                ->sql_affected_rows();
            self::free($res);
        }

        return $ret;
    }

    /**
     * Sanitize field for sql usage
     *
     * @param   string $field SQL Field/Attribut
     *
     * @return  string
     */
    public static function sanitizeSqlField($field)
    {
        return preg_replace('/[^_a-zA-Z0-9\.]/', '', $field);
    }

    ###########################################################################
    # Helper functions
    ###########################################################################

    /**
     * Sanitize table for sql usage
     *
     * @param  string $table SQL Table
     *
     * @return string
     */
    public static function sanitizeSqlTable($table)
    {
        return preg_replace('/[^_a-zA-Z0-9]/', '', $table);
    }

    /**
     * Add condition to query
     *
     * @param  array|string $condition Condition
     *
     * @return string
     */
    public static function addCondition($condition)
    {
        $ret = ' ';

        if (!empty($condition)) {
            if (is_array($condition)) {
                $ret .= ' AND (( ' . implode(" )\nAND (", $condition) . ' ))';
            } else {
                $ret .= ' AND ( ' . $condition . ' )';
            }
        }

        return $ret;
    }

    /**
     * Create condition WHERE field IN (1,2,3,4)
     *
     * @param  string $field SQL field
     * @param  array $values Values
     * @param  boolean $required Required
     *
     * @return string
     */
    public static function conditionIn($field, $values, $required = true)
    {
        if (!empty($values)) {
            $quotedValues = self::quoteArray($values, 'pages');

            $ret = $field . ' IN (' . implode(',', $quotedValues) . ')';
        } else {
            if ($required) {
                $ret = '1=0';
            } else {
                $ret = '1=1';
            }
        }

        return $ret;
    }

    /**
     * Quote array with values
     *
     * @param   array $valueList Values
     * @param   string $table    Table
     *
     * @return  array
     */
    public static function quoteArray($valueList, $table = null)
    {
        $ret = array();
        foreach ($valueList as $k => $v) {
            $ret[$k] = self::quote($v, $table);
        }

        return $ret;
    }

    ###########################################################################
    # SQL warpper functions
    ###########################################################################

    /**
     * Quote value
     *
     * @param   string $value Value
     * @param   string $table Table
     *
     * @return  string
     */
    public static function quote($value, $table = null)
    {
        if ($table === null) {
            $table = 'Pages';
        }

        if ($value === null) {
            return 'NULL';
        }

        return self::connection()
            ->fullQuoteStr($value, $table);
    }

    /**
     * Create condition WHERE field NOT IN (1,2,3,4)
     *
     * @param  string $field SQL field
     * @param  array $values Values
     * @param  boolean $required Required
     *
     * @return string
     */
    public static function conditionNotIn($field, $values, $required = true)
    {
        if (!empty($values)) {
            $quotedValues = self::quoteArray($values, 'pages');

            $ret = $field . ' NOT IN (' . implode(',', $quotedValues) . ')';
        } else {
            if ($required) {
                $ret = '1=0';
            } else {
                $ret = '1=1';
            }
        }

        return $ret;
    }

    /**
     * Build condition
     *
     * @param  array $where Where condition
     *
     * @return string
     */
    public static function buildCondition($where)
    {
        $ret = ' ';

        if (!empty($where)) {
            $ret = ' ( ' . implode(' ) AND ( ', $where) . ' ) ';
        }

        return $ret;
    }
}
