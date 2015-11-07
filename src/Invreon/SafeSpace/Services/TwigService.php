<?php
namespace Invreon\SafeSpace\Services;

use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigService
{
    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var string $dir
     */
    private $dir;

    public function __construct()
    {
        $this->dir = '';
        $this->loader = new Twig_Loader_Filesystem(PATH . '/src/Invreon/SafeSpace/Templates' . $this->dir);
        $this->twig = new Twig_Environment($this->loader);
    }

    public function render($name, array $context = array())
    {
        $fullName = $this->dir . $name;

        // Ensure extensions end in .twig
        if (strpos($fullName, '.twig') === false) {
            $fullName .= '.twig';
        }

        return $this->twig->loadTemplate($fullName)->render($context);
    }

    /**
     * @param string $dir
     */
    public function setTwigDirectory($dir)
    {
        // Ensure extensions end in .twig
        if (substr($dir, 0, 1) !== '/') {
            $dir = '/' . $dir;
        }

        if (substr($dir, -1) !== '/') {
            $dir .= '/';
        }

        $this->dir = $dir;
    }

    /**
     * @return string $dir
     */
    public function getTwigDirectory()
    {
        return $this->dir;
    }
}
