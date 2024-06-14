<?php

namespace App\Presenter;

use Nette;
use Tracy\ILogger;

class ErrorPresenter extends Nette\Application\UI\Presenter
{
	/** @var ILogger */
	private $logger;

	/** @var Nette\DI\Container @inject */
	public $container;

	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}
}
