<?php
declare(strict_types=1);

namespace App\App\Presenter;

use App\App\Model\OrderModel;
use App\App\Model\CustomerModel;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Ublaboo\DataGrid\DataGrid;
use App\App\Model\Types;

/**
 * Presenter pro výpis
 */
class OrdersPresenter extends BasePresenter
{
    public $orderModel;
    public $customerModel;
    public $id;
    
    public function __construct(OrderModel $orderModel, CustomerModel $customerModel)
    {
        $this->orderModel =$orderModel;
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
        $grid->setDataSource($this->orderModel->listAllrecords());
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
            'partner'=>$order->contract->name,
            'status'=>$order->status->id,
        ));
        
        $form->onSuccess[] = [$this, 'saveData'];
        return $form;
    }
    
    public function saveData(Form $form, ArrayHash $data)
    {
        try {
        
        } catch (\Exception $e)
        {
        
        }
    }
}
