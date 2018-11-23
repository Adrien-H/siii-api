<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param string|null $identity
     *
     * @return UserInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findByIdentity(?string $identity): ?UserInterface
    {
        return $this->findByEmail($identity);
    }

    /**
     * @param string|null $email
     *
     * @return UserInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function findByEmail(?string $email): ?UserInterface
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.email = :email')->setParameter('email', $email)
            ->getQuery()
        ;

        // @todo Implement Redis cache system
//        $query->useQueryCache(true);
//        $query->setResultCacheLifetime(0);

        return $query->getOneOrNullResult();
    }
}
