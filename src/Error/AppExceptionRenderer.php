<?php
namespace App\Error;

use Cake\Controller\Controller;
use Cake\Error\ExceptionRenderer;
use Cake\Routing\Router;

class AppExceptionRenderer extends ExceptionRenderer
{
	protected function _getController()
	{
		$controller = new Controller();
		switch ($controller->getRequest()->getParam('plugin')) {
			case 'Admin':
				return new \Admin\Controller\ErrorController();
				break;

            default:
				return new \Theme\Controller\ErrorController();
				break;
		}
	}
}