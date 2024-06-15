<?php
declare(strict_types=1);

namespace App\App\Model;

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
     * @throws \Exception
     */
    public function saveOrderData(\stdClass $data)
    {
        $records = $this->listAllRecords();
        $types = new Types();
        foreach ($records as $key=>$record)
        {
            if ($record->id == $data->id) {
                $order = $this->getOrder($record->id);
                $order->orderNumber = $data->orderNumber;
                $order->requestedDeliveryAt = $data->deliveryAt;
                $order->contract->name = $data->contract;
                $order->status->id = $data->status;
                $order->status->name = $types->getStatus($data->status);
                
                $records[$key] = $order;
            }
        }
        $this->saveData($records);
    }
    
}