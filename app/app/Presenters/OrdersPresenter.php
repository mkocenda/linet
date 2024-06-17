<?php
declare(strict_types=1);

namespace App\App\Presenter;

use App\App\Model\OrderModel;
use App\App\Service\OrderService;
use App\App\Model\CustomerModel;
use Exception;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use stdClass;
use Ublaboo\DataGrid\DataGrid;
use App\App\Model\Types;
use Tracy\ILogger;
use Ublaboo\DataGrid\Exception\DataGridException;

/**
 * Presenter pro výpis
 */
class OrdersPresenter extends BasePresenter
{
    public OrderModel $orderModel;
    
    public OrderService $orderService;
    
    public CustomerModel $customerModel;
    
    public ILogger $log;

    public int $id;
    
    public function __construct(OrderModel $orderModel, OrderService $orderService, CustomerModel $customerModel)
    {
        parent::__construct();
        $this->orderModel = $orderModel;
        $this->orderService = $orderService;
        $this->customerModel = $customerModel;
    }
    
    /**
     * @param int $id
     * @return void
     */
    public function actionEdit(int $id) : void
    {
        $this->id = $id;
    }
    
    /**
     * @param string $name
     * @return DataGrid
     * @throws DataGridException
     */
    public function createComponentGridList(string $name) : DataGrid
    {
        $grid = new DataGrid($this, $name);
        $grid->setDataSource($this->orderModel->getDataForGrid());
        $grid->setDefaultSort('id');
        $grid->addColumnText('orderNumber', 'OrderNumber');
        $grid->addColumnDateTime('createdAt', 'CreatedAt');
        $grid->addColumnDateTime('requestedDeliveryAt', 'RequestedDeliveryAt');
        $grid->addColumnText('customer', 'Customer');
        $grid->addColumnText('contract', 'Contract');
        $grid->addColumnStatus('status', 'Status')
            ->addOption('NEW','new')
            ->endOption()
            ->addOption('ACT','active')
            ->endOption()
            ->addOption('END','closed')
            ->endOption()
        ->onChange[] = [$this, 'changeStatus'];
        $grid->addColumnDateTime('statusCreatedAt', 'StatusCreatedAt');
        
        $grid->addAction('edit', 'Edit', 'edit',  ['id'])
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
    public function saveData(Form $form, stdClass $data) : void
    {
        try {
            $this->orderService->saveData($data);
        } catch (Exception $e)
        {
            $this->log->log('Chyba při ukládání dat z formuláře '.$e->getMessage(),'ERROR');
        }
        $this->redirect(':App:Orders:');
    }
    
    public function changeStatus(string $id, string $new_status)
    {
        try{
            $this->orderService->changeOrderStatus($id, $new_status);
        } catch (Exception $e){
            $this->log->log('Chyba při změně statusu objednávky', 'error');
        }
        
        if ($this->isAjax()) {
            $this['columnsGrid']->redrawItem($id);
        }
    }
}
