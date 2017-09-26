<?php

namespace LaraSpells\Template\AdminLte;

use LaraSpells\Generator\Commands\SchemaBasedCommand;
use LaraSpells\Generator\Template;

class AdminLteTemplate extends Template
{

    protected $authController = 'AuthController';
    protected $dashboardController = 'DashboardController';

    public function __construct(SchemaBasedCommand $command)
    {
        parent::__construct($command);
        $this->directory = realpath(__DIR__);
    }

    public function getSchemaResolver()
    {
        return new SchemaResolver;
    }

    public function beforeGenerateCruds(array $tables)
    {
        $routeName = $this->getSchema()->getRouteName();
        $this->addConfigMenu($routeName.'dashboard', 'Dashboard', ['icon' => 'fa-dashboard']);
        $this->getRouteCrud()->setMiddleware('auth');
        $this->addAuthRoutes();
        $this->addDashboardRoute();
        $this->generateAuthController();
        $this->generateDashboardController();
    }

    protected function addAuthRoutes()
    {
        $routePrefix = $this->getSchema()->getRoutePrefix();
        $routeGenerator = $this->getRouteCollector();
        $routePrefix = $this->getSchema()->getRoutePrefix();
        $routeName = $this->getSchema()->getRouteName();
        $routeDomain = $this->getSchema()->getRouteDomain();

        if (!$this->hasRouteNamed($routeName.'auth.form-login')) {
            $group = $routeGenerator->addRouteGroup([
                'name' => $routeName.'auth.',
                'prefix' => $routePrefix.'/auth',
                'domain' => $routeDomain
            ]);

            $group->addRoute('get', 'login', $this->authController.'@showLoginForm', [
                'name' => 'form-login'
            ]);

            $group->addRoute('post', 'login', $this->authController.'@login', [
                'name' => 'login'
            ]);

            $group->addRoute('get', 'logout', $this->authController.'@logout', [
                'name' => 'logout'
            ]);

            $routeFormLogin = $routeName.'auth.form-login';
            $this->addSuggestion("Change your unauthenticated redirect url in 'app/Exceptions/Handler.php' to route('$routeFormLogin')");
        }
    }

    protected function addDashboardRoute()
    {
        $routeName = $this->getSchema()->getRouteName(); 
        $this->getRouteCrud()->addRoute('get', '/', $this->dashboardController.'@pageDashboard', [
            'name' => 'dashboard'
        ]);
    }

    protected function generateAuthController()
    {
        $routePrefix = $this->getSchema()->getRoutePrefix();
        $routeName = $this->getSchema()->getRouteName(); 
        $controllerNamespace = $this->getSchema()->getControllerNamespace();
        $stub = file_get_contents(__DIR__.'/stubs/AuthController.stub');

        $result = $this->renderStub($stub, [
            'controller_namespace' => $controllerNamespace,
            'view_login' => $this->getSchema()->getView('auth.login'),
            'path_dashboard' => '/'.$routePrefix,
            'route_login' => $routeName.'auth.form-login'
        ]);

        $this->putController($this->authController, $result);
    }

    protected function generateDashboardController()
    {
        $stub = file_get_contents(__DIR__.'/stubs/DashboardController.stub');
        $controllerNamespace = $this->getSchema()->getControllerNamespace();

        $result = $this->renderStub($stub, [
            'controller_namespace' => $controllerNamespace,
            'view_dashboard' => $this->getSchema()->getView('dashboard.dashboard'),
        ]);

        $this->putController($this->dashboardController, $result);
    }

}
