<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $encoder = new Argon2iPasswordEncoder();
        $user = (new User())
            ->setEmail('admin@siii.earth')
            ->setSalt(User::generateSalt())
        ;
        $user->setPassword($encoder->encodePassword('adminS3I', $user->getSalt()));

        $manager->persist($user);
        $manager->flush();
    }
}
