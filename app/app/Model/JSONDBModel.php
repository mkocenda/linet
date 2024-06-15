<?php
declare(strict_types=1);

namespace App\App\Model;

use JsonException;

class JSONDBModel
{

    public string $JSONfile;
    public function __construct()
    {
        $this->JSONfile = __DIR__.'/../../../data/orders-data.json';
    }
    
    
    /**
     * @return array
     * @throws JsonException
     */
    public function loadData() : array
    {
        return $this->decode(file_get_contents($this->JSONfile));
    }
    
    
    /**
     * @param array $data
     * @return void
     * @throws JsonException
     */
    public function saveData(array $data) : void
    {
        file_put_contents($this->JSONfile, $this->encode($data));
    }
    
    
    /**
     * @param array $value
     * @return string
     * @throws JsonException
     */
    private function encode(array $value) : string
    {
        $json = json_encode($value);
        if (json_last_error()) {
            throw new JsonException();
        }
        return $json;
    }
    
    /**
     * @param string $json
     * @return array
     * @throws JsonException
     */
    private function decode(string $json) : array
    {
        $value = json_decode($json);
        if (json_last_error()) {
            throw new JsonException;
        }
        return $value;
    }
}