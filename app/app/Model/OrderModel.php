<?php
declare(strict_types=1);

namespace App\App\Model;

use stdClass;
class OrderModel extends JSONDBModel
{
    
    /**
     * @return array
     */
    public function getAllRecords() : array
    {
        return $this->loadData();
    }
    
    /**
     * @return array
     */
    public function getDataForGrid()
    {
        $records = $this->getAllRecords();
        $data = array();
        foreach ($records as $key=>$record){
            $tmpData = new stdClass();
            $tmpData->id = $record->id;
            $tmpData->orderNumber = $record->orderNumber;
            $tmpData->createdAt = $record->createdAt;
            $tmpData->requestedDeliveryAt = $record->requestedDeliveryAt;
            $tmpData->customer = $record->customer->name;
            $tmpData->contract = $record->contract->name;
            $tmpData->status = $record->status->name;
            $tmpData->statusCreatedAt = $record->status->createdAt;
            $data[$key] = $tmpData;
        }
        return $data;
    }
    
    /**
     * @param int $id
     * @return mixed|null
     */
    public function getOrder(int $id)
    {
        foreach ($this->getAllRecords() as $record)
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
        $records = $this->getAllRecords();
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