<?php
//https://sharemycode.fr/8jy
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('moussadak');
        $user->setPrenom('latifa');
        $user->setDateInscription(new \DateTime());
        $user->setEmail('latifa@gmail.com');
        $user->setRoles (['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'latifa'));
        $manager->persist($user);
        $user2 = new User();
        $user2->setNom('bencheikh');
        $user2->setPrenom('ali');
        $user2->setDateInscription(new \DateTime("2020-12-24"));
        $user2->setEmail('ali@gmail.com');
        $user2->setPassword($this ->passwordEncoder->encodePassword($user2, 'ali'));
        $manager->persist($user2);
        $manager->flush();
    }
}

