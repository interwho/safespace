<?php
namespace Invreon\SafeSpace\Repositories;

use Doctrine\ORM\EntityRepository;
use Invreon\SafeSpace\Entities\User;

/**
 * @method User findOneBy(array $criteria)
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends EntityRepository
{
    public function create($obj)
    {
        $em = $this->getEntityManager();
        $em->persist($obj);
        $em->flush($obj);
    }

    public function save($obj)
    {
        $em = $this->getEntityManager();
        $em->flush($obj);
    }

    public function remove($obj)
    {
        $em = $this->getEntityManager();
        $em->remove($obj);
        $em->flush();
    }
}
