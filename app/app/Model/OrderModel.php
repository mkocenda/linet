<?php
declare(strict_types=1);

namespace App\App\Model;

class OrderModel extends JSONDBModel
{
    
    /**
     * @return array
     */
    public function listAllrecords() : array
    {
        return $this->loadData();
    }
    
    /**
     * @param int $id
     * @return mixed|null
     */
    public function getOrder(int $id)
    {
        foreach ($this->listAllrecords() as $key=>$record)
        {
            if ($record->id === $id) return $record;
        }
        return null;
    }
    
}