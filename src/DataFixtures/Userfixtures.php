<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class Userfixtures extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
     }

        public function load(ObjectManager $manager)
{
            $user = new User();
    // ...
            $user->setEmail("email@gmail.com");
             $user->setPassword($this->passwordEncoder->encodePassword(
                     $user,
                     'the_new_password'
                 ));
            $manager->persist($user);
            $manager->flush();
    // ...
}

}
