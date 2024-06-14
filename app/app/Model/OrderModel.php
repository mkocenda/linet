<?php
declare(strict_types=1);

namespace App\App\Model;

use Nette\Utils\ArrayHash;
use Nette\Utils\Json;

class OrderModel extends JSONDBModel
{
    
    /**
     * @return array
     */
    public function listAllRecords() : array
    {
        return $this->loadData();
    }
    
    /**
     * @param int $id
     * @return mixed|null
     */
    public function getOrder(int $id)
    {
        foreach ($this->listAllRecords() as $record)
        {
            if ($record->id === $id) return $record;
        }
        return null;
    }
    
    /**
     * @param \stdClass $data
     * @return void
     */
    public function saveOrderData(\stdClass $data)
    {
        $records = $this->listAllRecords();
        foreach ($records as $key=>$record)
        {
            if ($record->id == $data->id) { $records[$key] = $data; bdump($records[$key]); }
        }
        $this->saveData($records);
    }
    
}