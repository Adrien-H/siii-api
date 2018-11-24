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

        $users = [
            ['email' => 'admin@siii.earth', 'password' => 'adminS3I'],
            ['email' => 'user@siii.earth', 'password' => 'userS3I']
        ];

        for ($i = 0, $max = count($users); $i < $max; ++$i) {
            $user = (new User())
                ->setEmail($users[$i]['email'])
                ->setSalt(User::generateSalt());
            $user->setPassword(
                $encoder->encodePassword($users[$i]['password'], $user->getSalt()));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
