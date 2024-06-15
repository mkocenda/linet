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

		$router[] = $appRouter = new RouteList("App");
        /** Defaultní směrování na presenter */
		$appRouter[] = new Route("", "Orders:");
		$appRouter[] = new Route("orders/", "Orders:");
		$appRouter[] = new Route("orders/edit/{id}", "Orders:");
        $appRouter[] = new Route("api/v1/api-list/", "ApiJson:apiList");

		return $router;
	}

}
