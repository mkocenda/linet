<?php
declare(strict_types=1);

namespace App\App\Service;

use App\App\Model\OrderModel;
use Exception;
use Nette\Utils\DateTime;
use stdClass;

class OrderService
{
    
    public OrderModel $orderModel;
    
    public function __construct(OrderModel $orderModel)
    {
        $this->orderModel = $orderModel;
    }
    
    /**
     * @param stdClass $data
     * @return void
     * @throws Exception
     */
    public function saveData(stdClass $data) : void
    {
       /** @var DateTime $deliveryAt */
       $deliveryAt = $data->deliveryAt;
       $data->deliveryAt = $deliveryAt->format('Y-m-d H:m:sp');
       $this->orderModel->saveOrderData($data);
    }
}