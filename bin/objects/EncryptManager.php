<?php

namespace l\objects;

class EncryptManager extends BaseObject
{
    protected string $filePath;
    protected string $key;

    public function __construct(string $filePath = '')
    {
        parent::__construct([]);

        if (!file_exists($filePath)) {
            throw new \Error('File not found.');
        }

        $this->key = getenv('DATABASE_DECRYPT_PASSWORD_PHRASE');
        $this->filePath = $filePath;
    }

    /**
     * @throws \Exception
     */
    public static function get (string $filePath): EncryptManager
    {
        return new self($filePath);
    }

    /**
     * @return string
     */
    public function decryptFile(): string
    {
        $data = file_get_contents($this->filePath);

        $hash = substr($data, 0, 32);
        $data = substr($data, 32);

        if ($this->md2Hash($data) === $hash) {
            return openssl_decrypt($data, 'aes-128-ecb', $this->key);
        }

        return '';
    }

    /**
     * @param string $finalData
     * @return void
     */
    public function encryptData(string $finalData): void
    {
        if (!file_exists($this->filePath)) {
            return;
        }

        $encryptedData = openssl_encrypt($finalData, 'aes-128-ecb', $this->key);
        $encryptedDataWithHash = $this->md2Hash($encryptedData) . $encryptedData;

        file_put_contents($this->filePath, $encryptedDataWithHash);
    }

    /**
     * @param $data
     * @return false|string
     */
    private function md2Hash($data)
    {
        return hash('md2', $data);
    }
}
