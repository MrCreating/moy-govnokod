<?php

namespace l\objects;

/**
 * DataBase class
 * Created for management users json file.
 */

class DataBase extends BaseObject
{
    protected string $dbName = '';

    private string $filePath = '';

    private array $contents = [];

    private EncryptManager $encryptManager;

    /**
     * @param string $dbName
     * @param array $params
     * @throws \Exception
     */
    public function __construct (string $dbName, array $params = [])
    {
        parent::__construct($params);

        if (empty($dbName)) {
            throw new \Exception('Failed to load empty DB');
        }

        $file = __DIR__ .'/../../data/' . $dbName . '.json';

        if (!file_exists($file)) {
            touch($file);
        }

        $this->filePath = $file;
        $this->dbName = $dbName;
        $this->encryptManager = EncryptManager::get($this->filePath);
        $this->contents = (array) json_decode($this->encryptManager->decryptFile(), true);
    }

    /**
     * Save file
     */
    public function __destruct ()
    {
        $finalData = json_encode($this->contents);

        $this->encryptManager->encryptData($finalData);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function insert (array $data = []): DataBase
    {
        $this->contents[] = $data;
        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function deleteByField (array $condition): DataBase
    {
        foreach ($this->contents as $i => $row) {
            foreach ($condition as $field => $value) {
                if (isset($row[$field]) && $row[$field] === $value) {
                    array_splice($this->contents, $i, 1);
                }
            }
        }
        return $this;
    }

    /**
     * @param string $field
     * @param $value
     * @return array
     */
    public function findBy (string $field, $value): array
    {
        return array_values(array_filter($this->contents, function ($item) use ($field, $value) {
            return isset($item[$field]) && $item[$field] === $value;
        }));
    }

    /**
     * @param string $updateField
     * @param $newValue
     * @param array $condition
     * @return $this
     */
    public function updateItemBy (string $updateField, $newValue, array $condition = []): DataBase
    {
        foreach ($this->contents as $i => $row) {
            foreach ($condition as $field => $value) {
                if (isset($row[$field]) && $row[$field] === $value) {
                    $this->contents[$i][$updateField] = $newValue;
                }
            }
        }
        return $this;
    }

    /**
     * @param string $field
     * @return int
     */
    public function i (string $field): int
    {
        $currentContent = $this->contents;

        usort($currentContent, function ($a, $b) use ($field) {
            return $a[$field] < $b[$field];
        });

        $lastIndex = isset($currentContent[0]) ? $currentContent[0][$field] : 0;
        return $lastIndex + 1;
    }

    /**
     * @param string $string
     * @return array
     */
    public function getManyByField(string $field): array
    {
        return array_values(array_filter($this->contents, function ($item) use ($field) {
            return isset($item[$field]);
        }));
    }

    /**
     * @return array
     */
    public function all (?string $updateKey = NULL, $updateValue = NULL): array
    {
        if (!is_null($updateKey)) {
            $this->contents[$updateKey] = $updateValue;
            return $this->contents;
        }

        return $this->contents;
    }
}
?>
