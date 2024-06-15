<?php
declare(strict_types=1);

namespace App\App\Presenter;

use App\App\Model\OrderModel;
use App\App\Service\OrderService;
use App\App\Model\CustomerModel;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Ublaboo\DataGrid\DataGrid;
use App\App\Model\Types;
use Tracy\ILogger;

/**
 * Presenter pro výpis
 */
class OrdersPresenter extends BasePresenter
{
    /** @var OrderModel  */
    public $orderModel;
    
    /** @var OrderService */
    public $orderService;
    
    /** @var CustomerModel  */
    public $customerModel;
    
    /** @var ILogger @inject */
    public $log;
    /** @var int */
    public $id;
    
    public function __construct(OrderModel $orderModel, OrderService $orderService, CustomerModel $customerModel)
    {
        $this->orderModel = $orderModel;
        $this->orderService = $orderService;
        $this->customerModel = $customerModel;
    }
    
    /**
     * @param int $id
     * @return void
     */
    public function actionEdit(int $id)
    {
        $this->id = $id;
    }
    
    /**
     * @param string $name
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGridList(string $name) : DataGrid
    {
        $grid = new DataGrid($this, $name);
        $grid->setDataSource($this->orderModel->listAllRecords());
        $grid->setDefaultSort('id');
        $grid->addColumnText('orderNumber', 'OrderNumber');
        $grid->addColumnDateTime('createdAt', 'CreatedAt');
        $grid->addColumnDateTime('requestedDeliveryAt', 'RequestedDeliveryAt');
        $grid->addColumnDateTime('customer', 'Customer')->setRenderer(function ($dataSource) {
            return $dataSource->customer->name;
        });
        $grid->addColumnDateTime('contract', 'Contract')->setRenderer(function ($dataSource) {
            return $dataSource->contract->name;
        });
        $grid->addColumnDateTime('status', 'Status')->setRenderer(function ($dataSource) {
            return $dataSource->status->name;
        });
        $grid->addColumnDateTime('statusCreatedAt', 'StatusCreatedAt')->setRenderer(function ($dataSource) {
            return $dataSource->status->createdAt;
        });
        
        $grid->addAction('edit', 'Edit', 'edit', ['id'])
            ->setTitle('Edit')
            ->setAlign('right');
        return $grid;
    }
    
    /**
     * @return Form
     */
    public function createComponentEditForm() : Form
    {
        $form = new Form();
        $form->addHidden('id',$this->id);
        $form->addText('orderNumber','OrderNumber');
        $form->addDateTime('deliveryAt','deliveryAt');
        $form->addSelect('customer','customer', $this->customerModel->getCustomers());
        $form->addSelect('contract','contract', Types::contractType);
        $form->addSelect('status','status', Types::STATUS);
        
        $form->addSubmit('submit','SUBMIT');
        $order = $this->orderModel->getOrder($this->id);
        $form->setDefaults(array('id'=>$this->id,
            'orderNumber'=>$order->orderNumber,
            'deliveryAt'=>$order->requestedDeliveryAt,
            'customer'=>$order->customer->id,
            'contract'=>$order->contract->name,
            'status'=>$order->status->id,
        ));
        
        $form->onSuccess[] = [$this, 'saveData'];
        return $form;
    }
    
    /**
     * @param Form $form
     * @param ArrayHash $data
     * @return void
     */
    public function saveData(Form $form, \stdClass $data) : void
    {
        try {
            $this->orderService->saveData($data);
        } catch (\Exception $e)
        {
            $this->log->log('Chyba při ukládání dat z formuláře '.$e->getMessage(),'ERROR');
        }
        $this->redirect(':App:Orders:');
    }
}
