<?php

namespace App\Presenter;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Nette\DI\Container @inject */
	public $container;
    
    private $config;
    
	public function startup()
	{
		parent::startup();
	}

	protected function beforeRender()
	{
	}


}
