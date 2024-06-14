<?php

namespace App;

use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{

	/**
	 * @return RouteList
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		$router[] = $appRouter = new RouteList("");
        /** Defaultní směrování na presenter */
		$appRouter[] = new Route("", "App:Orders:");
		$appRouter[] = new Route("/orders/", "App:Orders:");
		$appRouter[] = new Route("/orders/edit/{id}", "App:Orders:");

		return $router;
	}

}
