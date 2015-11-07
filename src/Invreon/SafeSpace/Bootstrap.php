<?php
namespace Invreon\SafeSpace;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

/**
 * Class Bootstrap
 * @package Invreon\SafeSpace
 */
class Bootstrap
{
    public function __construct($routeFile)
    {
        $request = Request::createFromGlobals();

        $context = new RequestContext();
        $context->fromRequest($request);

        // Locator
        $locator = new FileLocator([PATH . '/config/']);

        // Router
        $router = new Router(
            new PhpFileLoader($locator),
            $routeFile,
            ['cache_dir' => PATH . '/tmp/cache'],
            $context
        );

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($router));

        $resolver = new ControllerResolver();

        $kernel = new HttpKernel($dispatcher, $resolver);

        $kernel->handle($request)->send();
    }
}
