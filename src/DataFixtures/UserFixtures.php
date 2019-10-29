<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createUser(
            'admin1@bhinternet.fr',
            'password',
            'ROLE_ADMIN',
            $manager
        );

        $this->createUser(
            'superAdmin1@bhinternet.fr',
            'password',
            'ROLE_SUPER_ADMIN',
            $manager
        );

        $this->createUser(
            'user1@bhinternet.fr',
            'password',
            'ROLE_USER',
            $manager
        );
    }

    private function createUser(
        string $email,
        string $password,
        string $role,
        ObjectManager $manager
    ): void {
        $user = new User($email, $email, $password);
        $user->setRoles([$role]);
        $manager->persist($user);
        $manager->flush();
    }
}
