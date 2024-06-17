<?php
declare(strict_types=1);

namespace App\App\Service;

use App\App\Model\OrderModel;
use Exception;
use Nette\Utils\DateTime;
use stdClass;
use App\App\Model\Types;
class OrderService
{
    
    public OrderModel $orderModel;
    public Types $types;
    
    public function __construct(OrderModel $orderModel, Types $types)
    {
        $this->orderModel = $orderModel;
        $this->types = $types;
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
    
    /**
     * @param string $id
     * @param string $new_status
     * @return void
     * @throws Exception
     */
    public function changeOrderStatus(string $id, string $new_status) : void
    {
        $order = $this->orderModel->getOrder($id);
        $order->status->id = $new_status;
        $order->status->name = $this->types->getStatus($new_status);
        
        $this->orderModel->saveOrderData($order);
    
    }
}