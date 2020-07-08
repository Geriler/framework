<?php

namespace Core;

use App\Core\Router;
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
        $route = '/get';
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
        $route = '/post';
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
        $route = '/patch';
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
        $this->assertTrue($controller == Router::getDefaultController());
        $this->assertNotTrue('' == Router::getDefaultController());
    }

    public function testSetDefaultAction()
    {
        $action = 'index';
        Router::setDefaultAction($action);
        $this->assertTrue($action == Router::getDefaultAction());
        $this->assertNotTrue('' == Router::getDefaultAction());
    }

    public function testDelete()
    {
        $route = '/delete';
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
        $route = '/get_by_name';
        $controller = 'MainController';
        $action = 'index';
        $name = 'name';
        Router::get($route, $controller, $action, $name);

        $testRoute = Router::getRouteByName($name);
        $this->assertTrue($route == $testRoute);
    }

    public function testRun()
    {
        $route = '/get_params';
        $controller = 'MainController';
        $action = 'index';
        $name = 'name';
        Router::get($route, $controller, $action, $name);

        $testRoute = Router::run($route);
        $this->assertTrue($controller == $testRoute['class']);
        $this->assertTrue($action == $testRoute['action']);
        $this->assertTrue($name == $testRoute['name']);
    }
}
