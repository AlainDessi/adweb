<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testRouteGet()
    {
        $router = new Core\Routing\Router();
        $router->get('/homepage', 'ControllerTest@index', 'homepage');
        $testRoute = $router->getRouteAlias('homepage')->getAlias();
        $this->assertEquals('homepage', $testRoute);
    }

    public function testRoutePost()
    {
        $router = new Core\Routing\Router();
        $router->post('/homepage', 'ControllerTest@index', 'homepage.edit');
        $testRoute = $router->getRouteAlias('homepage.edit')->getAlias();
        $this->assertEquals('homepage.edit', $testRoute);
    }

    public function testRouteDelete()
    {
        $router = new Core\Routing\Router();
        $router->delete('/homepage', 'ControllerTest@index', 'homepage.destroy');
        $testRoute = $router->getRouteAlias('homepage.destroy')->getAlias();
        $this->assertEquals('homepage.destroy', $testRoute);
    }

    public function testRoutePut()
    {
        $router = new Core\Routing\Router();
        $router->put('/homepage', 'ControllerTest@index', 'homepage.update');
        $testRoute = $router->getRouteAlias('homepage.update')->getAlias();
        $this->assertEquals('homepage.update', $testRoute);
    }
}
