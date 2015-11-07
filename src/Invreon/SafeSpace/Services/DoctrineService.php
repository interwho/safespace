<?php
namespace Invreon\SafeSpace\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Setup;
use RuntimeException;

class DoctrineService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct()
    {
        $autoGenerateProxy = true;
        $proxyDir = PATH . '/tmp/proxy';

        $config = Setup::createAnnotationMetadataConfiguration(array(PATH . '/src/Invreon/SafeSpace/Entities'), $autoGenerateProxy, $proxyDir);

        $this->em = EntityManager::create($GLOBALS['DATABASE'], $config);
    }

    /**
     * @param string $entity
     * @throws RuntimeException
     * @return EntityRepository
     */
    public function getRepository($entity)
    {
        $entityClass = 'Invreon\SafeSpace\Entities\\' . $entity;

        if (!class_exists($entityClass)) {
            throw new RuntimeException('EntityRepository ' . $entityClass . ' is not defined');
        }

        if (!isset($this->em)) {
            throw new RuntimeException('EntityManager is not defined');
        }

        return $this->em->getRepository($entityClass);
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->em;
    }
}
