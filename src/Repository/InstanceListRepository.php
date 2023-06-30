<?php

namespace App\Repository;

use App\Entity\InstanceList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InstanceList>
 *
 * @method InstanceList|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstanceList|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstanceList[]    findAll()
 * @method InstanceList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstanceListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstanceList::class);
    }

    public function save(InstanceList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InstanceList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
