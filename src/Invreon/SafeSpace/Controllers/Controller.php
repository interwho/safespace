<?php
namespace Invreon\SafeSpace\Controllers;

use DateTime;
use Exception;
use Invreon\SafeSpace\Services\TwigService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class Controller
 * @package Invreon\SafeSpace\Controllers
 */
abstract class Controller
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var
     */
    protected $twigService;

    /**
     * Controller Initializer
     */
    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
        $this->params = $_REQUEST;
        $this->files = $_FILES;
        $this->twigService = new TwigService();
        $this->twigService->setTwigDirectory('Public');
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Return a formatted response object
     *
     * @param string $content
     * @param string $type
     * @return Response
     */
    protected function createResponse($content, $type = 'text/html')
    {
        return new Response(
            $content,
            Response::HTTP_OK,
            array('content-type' => $type)
        );
    }

    /**
     * Return a formatted redirecting response object
     *
     * @param string $newLocation
     * @return Response
     */
    protected function createRedirect($newLocation)
    {
        return new Response(
            '',
            Response::HTTP_FOUND,
            array('Location' => $newLocation)
        );
    }

    /**
     * Render twig file with proper context
     *
     * @param $twigFile
     * @param $context
     * @return string
     */
    protected function render($twigFile, $context)
    {
        return $this->twigService->render($twigFile, $context);
    }
}
