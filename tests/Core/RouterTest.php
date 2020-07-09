<?php

namespace Core;

use App\Core\Exception\RouteNotFoundException;
use App\Core\Router;
use Exception;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../../app/Core/Paths.php';
    }

    public function testGet()
    {
        $route = '/route-for-tests/get';
        $controller = 'MainController';
        $action = 'index';
        Router::get($route, $controller, $action);

        $testRoute = Router::run($route);
        $this->assertTrue(in_array('GET', $testRoute['method']));
        $this->assertTrue(in_array('HEAD', $testRoute['method']));
        $this->assertNotTrue(in_array('POST', $testRoute['method']));
        $this->assertNotTrue(in_array('PUT', $testRoute['method']));
        $this->assertNotTrue(in_array('PATCH', $testRoute['method']));
        $this->assertNotTrue(in_array('DELETE', $testRoute['method']));
    }

    public function testPost()
    {
        $route = '/route-for-tests/post';
        $controller = 'MainController';
        $action = 'index';
        Router::post($route, $controller, $action);

        $testRoute = Router::run($route);
        $this->assertNotTrue(in_array('GET', $testRoute['method']));
        $this->assertNotTrue(in_array('HEAD', $testRoute['method']));
        $this->assertTrue(in_array('POST', $testRoute['method']));
        $this->assertNotTrue(in_array('PUT', $testRoute['method']));
        $this->assertNotTrue(in_array('PATCH', $testRoute['method']));
        $this->assertNotTrue(in_array('DELETE', $testRoute['method']));
    }

    public function testPatch()
    {
        $route = '/route-for-tests/patch';
        $controller = 'MainController';
        $action = 'index';
        Router::patch($route, $controller, $action);

        $testRoute = Router::run($route);
        $this->assertNotTrue(in_array('GET', $testRoute['method']));
        $this->assertNotTrue(in_array('HEAD', $testRoute['method']));
        $this->assertNotTrue(in_array('POST', $testRoute['method']));
        $this->assertTrue(in_array('PUT', $testRoute['method']));
        $this->assertTrue(in_array('PATCH', $testRoute['method']));
        $this->assertNotTrue(in_array('DELETE', $testRoute['method']));
    }

    public function testSetDefaultController()
    {
        $controller = 'MainController.php';
        Router::setDefaultController($controller);
        $this->assertSame($controller, Router::getDefaultController());
        $this->assertNotSame('', Router::getDefaultController());
    }

    public function testSetDefaultAction()
    {
        $action = 'index';
        Router::setDefaultAction($action);
        $this->assertSame($action, Router::getDefaultAction());
        $this->assertNotSame('', Router::getDefaultAction());
    }

    public function testDelete()
    {
        $route = '/route-for-tests/delete';
        $controller = 'MainController';
        $action = 'index';
        Router::delete($route, $controller, $action);

        $testRoute = Router::run($route);
        $this->assertNotTrue(in_array('GET', $testRoute['method']));
        $this->assertNotTrue(in_array('HEAD', $testRoute['method']));
        $this->assertNotTrue(in_array('POST', $testRoute['method']));
        $this->assertNotTrue(in_array('PUT', $testRoute['method']));
        $this->assertNotTrue(in_array('PATCH', $testRoute['method']));
        $this->assertTrue(in_array('DELETE', $testRoute['method']));
    }

    public function testGetRouteByName()
    {
        $route = '/route-for-tests/get_by_name';
        $controller = 'MainController';
        $action = 'index';
        $name = 'name';
        $nameNotFound = 'name-not-found';
        Router::get($route, $controller, $action, $name);

        try {
            $testRoute = Router::getRouteByName($name);
            $this->assertSame($route, $testRoute);
            Router::getRouteByName($nameNotFound);
        } catch (Exception $e) {
            $this->assertSame(RouteNotFoundException::class, get_class($e));
        }
    }

    public function testRun()
    {
        $route = '/route-for-tests/get_params';
        $controller = 'MainController';
        $action = 'index';
        $name = 'name';
        Router::get($route, $controller, $action, $name);

        $testRoute = Router::run($route);
        $this->assertSame($controller, $testRoute['class']);
        $this->assertSame($action, $testRoute['action']);
        $this->assertSame($name, $testRoute['name']);
    }
}
