<?php
declare(strict_types=1);

namespace App\App\Model;

use Nette\Utils\ArrayHash;
use Nette\Utils\Json;

class JSONDBModel
{

    public $JSONdata;
    public function __construct()
    {
        $this->JSONdata = file_get_contents(__DIR__.'/../../../data/orders-data.json');
    }
    
    
    /**
     * @return Json
     */
    public function loadData() : JSON
    {
        return $this->decode($this->data);
    }
    
    
    
    /**
     * @param ArrayHash $data
     * @return void
     */
    public function saveData(ArrayHash $data)
    {
    
    }
    
    
    /**
     * @param Json $value
     * @return array
     */
    private function encode(JSON $value) : array
    {
        $json = json_encode($value);
        if (json_last_error()) {
            throw new JsonException;
        }
        return $json;
    }
    
    /**
     * @param string $json
     * @return array
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