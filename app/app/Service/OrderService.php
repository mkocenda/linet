<?php
declare(strict_types=1);

namespace App\App\Service;

use App\App\Model\OrderModel;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

class OrderService
{
    
    /** @var OrderModel */
    public $orderModel;
    
    public function __construct(OrderModel $orderModel)
    {
        $this->orderModel = $orderModel;
    }
    
    /**
     * @param \stdClass $data
     * @return void
     */
    public function saveData(\stdClass $data)
    {
       /** @var DateTime $deliveryAt */
       $deliveryAt = $data->deliveryAt;
       $data->deliveryAt = $deliveryAt->format('Y-m-d H:m:sp');
       $this->orderModel->saveOrderData($data);
    }
}