<?php

declare(strict_types=1);

namespace App\App\Model;

class CustomerModel extends JSONDBModel
{
    
    /**
     * @return array
     */
    public function getCustomers() : array
    {
        $customerList = array();
        foreach ($this->loadData() as $record) {
            $customerList[$record->customer->id] = $record->customer->name;
        }
        return $customerList;
    }
    
    /**
     * @param int $id
     * @return array
     */
    public function getCustomer(int $id): array
    {
        return $this->getCustomers()[$id];
    }
}