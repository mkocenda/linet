<?php
declare(strict_types=1);

namespace App\App\Service;

use App\App\Model\OrderModel;
use Nette\Utils\ArrayHash;
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
       $this->orderModel->saveOrderData($data);
    }
}