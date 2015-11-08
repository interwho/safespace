<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * ProjectUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // PageController_home
        if ($pathinfo === '/') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_PageController_home;
            }

            return array (  '_controller' => 'Invreon\\SafeSpace\\Controllers\\PageController::home',  '_route' => 'PageController_home',);
        }
        not_PageController_home:

        // PageController_about
        if ($pathinfo === '/about') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_PageController_about;
            }

            return array (  '_controller' => 'Invreon\\SafeSpace\\Controllers\\PageController::about',  '_route' => 'PageController_about',);
        }
        not_PageController_about:

        // PageController_search
        if ($pathinfo === '/search') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_PageController_search;
            }

            return array (  '_controller' => 'Invreon\\SafeSpace\\Controllers\\PageController::search',  '_route' => 'PageController_search',);
        }
        not_PageController_search:

        // PageController_twitter
        if ($pathinfo === '/twitter') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_PageController_twitter;
            }

            return array (  '_controller' => 'Invreon\\SafeSpace\\Controllers\\PageController::twitter',  '_route' => 'PageController_twitter',);
        }
        not_PageController_twitter:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
