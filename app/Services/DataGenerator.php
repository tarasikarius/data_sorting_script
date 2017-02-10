<?php

namespace App\Services;

class DataGenerator
{
    const RESOURCE_FILE = 'hotels.csv';
    const DATA_DIR = __DIR__ . '/../../data';

    /**
     * @param $filters
     * @param $format
     * @return bool
     */
    public function generateFile($filters, $format)
    {
        $data = $this->parseCSV();
        $filteredData = $this->dataFilter($data, $filters);

        switch ($format) {
            case 'sqlite':
                $newFile = $this->sqliteFileGenerate($filteredData);
                break;
            default:
                $newFile = $this->jsonFileGenerate($filteredData);
        }
        return $newFile;
    }

    /**
     * @param array $data
     * @param array $filters
     * @return array
     */
    private function dataFilter(array $data, array $filters)
    {
        $result = [];

        foreach ($data as $item) {
            foreach ($filters as $filter => $value) {
                if (!$value) {
                    continue;
                }
                if ($item[$filter] == $value) {
                    $result[] = $item;
                    continue 2;
                }
            }
        }

        return $result;
    }

    /**
     * @return array|bool
     */
    private function parseCSV()
    {
        $resource = self::DATA_DIR . '/' . self::RESOURCE_FILE;
        $length = strlen(file_get_contents($resource));
        if (($handle = fopen($resource, "r")) == false) {
            return false;
        }

        $firstRow = true;
        $fields = [];
        $result = [];

        while (($data = fgetcsv($handle, $length)) !== false) {
            if ($firstRow) {
                $fields = $data;
                $firstRow = false;
                continue;
            }

            $result[] = array_combine($fields, $data);
        }
        fclose($handle);

        return $result;
    }

    /**
     * @param $dir
     */
    private function createDirIfNotExists($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
    }

    /**
     * @param $data
     * @return string
     */
    private function jsonFileGenerate($data)
    {
        $this->createDirIfNotExists(self::DATA_DIR . '/json');

        $fileName = self::DATA_DIR . '/json/' . date('d.m.y-H_i_s') . '.json';
        $handler = fopen($fileName, 'w');
        fwrite($handler, json_encode($data));
        fclose($handler);

        return $fileName;
    }

    /**
     * @param $data
     * @return bool|string
     */
    private function sqliteFileGenerate($data)
    {
        $this->createDirIfNotExists(self::DATA_DIR . '/sqlite');
        $fileName = self::DATA_DIR . '/sqlite/' . date('d.m.y-H_i_s') . '.db';

        $db = new \SQLite3($fileName, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        if (!$db->exec('CREATE TABLE hotels (id integer, name varchar(50), url varchar(50), stars integer)')) {
            return false;
        }

        foreach ($data as $item) {
            $sql = "INSERT INTO hotels (name, url, stars) 
                    VALUES('{$item['name']}', '{$item['url']}', {$item['stars']})
             ";
            $db->exec($sql);
        }
        
        return $fileName;
    }



}
