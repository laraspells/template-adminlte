<?php

namespace LaraSpells\Template\AdminLte;

use LaraSpells\Generator\Commands\SchemaBasedCommand;
use LaraSpells\Generator\Generators\ControllerGenerator;
use LaraSpells\Generator\Generators\ViewCreateGenerator;
use LaraSpells\Generator\Generators\ViewEditGenerator;
use LaraSpells\Generator\Schema\Table;
use LaraSpells\Generator\Template;
use LaraSpells\Template\AdminLte\Generators\FormModelControllerGenerator;
use LaraSpells\Template\AdminLte\Generators\FormModelViewCreateGenerator;
use LaraSpells\Template\AdminLte\Generators\FormModelViewEditGenerator;

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

    public function beforeGenerateEachCrud(Table $table)
    {
        if (true === $table->get('form_model')) {
            $this->setGeneratorInstance(ControllerGenerator::class, new FormModelControllerGenerator($table));
            $this->setGeneratorInstance(ViewCreateGenerator::class, new FormModelViewCreateGenerator($table));
            $this->setGeneratorInstance(ViewEditGenerator::class, new FormModelViewEditGenerator($table));
        }
    }

    public function beforeGenerateCruds(array $tables)
    {
        $routeName = $this->getSchema()->getRouteName();
        $this->addConfigMenu($routeName.'dashboard', 'Dashboard', ['icon' => 'fa-dashboard']);
        $this->addAuthRoutes();
        $this->addDashboardRoute();
        $this->generateAuthController();
        $this->generateDashboardController();
    }

    protected function addAuthRoutes()
    {
        $routePrefix = $this->getSchema()->getRoutePrefix();
        $routeGenerator = $this->getRouteCollector();
        $routeName = $this->getSchema()->getRouteName();
        $routeDomain = $this->getSchema()->getRouteDomain();

        if (!$this->hasRouteNamed($routeName.'auth.form-login')) {
            $group = $routeGenerator->addRouteGroup([
                'name' => $routeName.'auth.',
                'prefix' => $routePrefix.'/auth',
                'domain' => $routeDomain,
                'namespace' => $this->getRouteNamespace()
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
        $routePrefix = $this->getSchema()->getRoutePrefix();
        $routeGenerator = $this->getRouteCollector();
        $routeName = $this->getSchema()->getRouteName('dashboard');
        $routeDomain = $this->getSchema()->getRouteDomain();
        $namespace = $this->getRouteNamespace();

        $controller = $namespace ? $namespace.'\\'.$this->dashboardController : $this->dashboardController;

        if (!$this->hasRouteNamed($routeName)) {
            $routeName = $this->getSchema()->getRouteName();
            $this->getRouteCollector()->addRoute('get', $routePrefix, $controller.'@pageDashboard', [
                'name' => $routeName.'dashboard',
                'middleware' => 'auth',
                'domain' => $routeDomain,
            ]);
        }
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

    protected function getRouteNamespace()
    {
        $controllerNamespace = $this->getSchema()->getControllerNamespace();
        $namespace = trim(str_replace('App\Http\Controllers', '', $controllerNamespace), '\\');
        return $namespace;
    }

}
