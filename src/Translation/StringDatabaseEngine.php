<?php

namespace EVFramework\Translation;

use Berthe\DAL\DbReader;
use Berthe\DAL\DbWriter;
use Berthe\DAL\Writer;

class StringDatabaseEngine extends \Translation_Storage_Abstract implements \Translation_Storage_Interface
{
    /**
     * @var DbReader
     */
    protected $reader;

    /**
     * @var DbWriter
     */
    protected $writer;

    /**
     * @param DbReader $reader
     */
    public function setReader(DbReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param DbWriter $writer
     */
    public function setWriter(DbWriter $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @param string $key
     * @param string $lang
     * @return string
     */
    protected function makeKey($key)
    {
        return md5($key);
    }

    public function get($key, $lang)
    {
        $dbKey = $this->makeKey($key);
        $sql = <<<SQL
SELECT
    value
FROM
    translations_engine
WHERE
    md5key = ?
    AND lang = ?
SQL;
        $value = $this->reader->fetchOne($sql, array($dbKey, $lang));
        if ($value) {
            return $value;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $sql = <<<SQL
SELECT
    md5key,
    lang,
    key,
    value
FROM
    translations_engine
ORDER BY
    md5key ASC,
    lang ASC
SQL;

        $resultSet = $this->reader->fetchAll($sql);

        $output = array();
        foreach ($resultSet as $row) {
            if (!array_key_exists($row['key'], $output)) {
                $output[$row['key']] = array();
            }

            $output[$row['key']][$row['lang']] = $row['value'];
        }

        return $output;
    }

    public function set($key, $lang, $value)
    {
        try {
            $dbKey = $this->makeKey($key);
            $delete = <<<SQL
DELETE FROM
    translations_engine
WHERE
    md5key = ?
    AND lang = ?
SQL;
            $this->writer->query($delete, array($dbKey, $lang));
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        try {
            $insert = <<<SQL
INSERT INTO
    translations_engine
    (md5key, lang, key, value)
VALUES
    (?, ?, ?, ?)
SQL;
            $this->writer->query($insert, array($dbKey, $lang, $key, $value));
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteKeys($keys)
    {
        $key_str = implode(', ', $keys);

        $sql = <<<SQL
DELETE FROM
    translations_engine
WHERE
    key
IN
    ($key_str)
SQL;

        try {
            $this->writer->query($sql);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return true;
    }

    public function invert($value, $lang)
    {
        $sql = <<<SQL
SELECT
    key
FROM
    translations_engine
WHERE
    value = ?
    AND lang = ?
SQL;
        $key = $this->reader->fetchOne($sql, array($value, $lang));
        if ($key) {
            return $key;
        } else {
            return false;
        }
    }
}
