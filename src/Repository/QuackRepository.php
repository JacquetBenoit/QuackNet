<?php

namespace App\Repository;

use App\Entity\Quack;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Quack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quack[]    findAll()
 * @method Quack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quack::class);
    }

    public function findAllWithRelation(){
        $qb = $this->createQueryBuilder('q')
            ->Join('q.author', 'u')
            ->addSelect('u');
        return $qb->getQuery()->getResult();
    }
}
