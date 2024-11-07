<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute("api","Api:getOrganization");
		$router->addRoute('admin', 'admin:admin');
		$router->addRoute('page/show/<id>', 'Page:show');
		$router->addRoute('content/show/<id>','Content:default');

		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}
