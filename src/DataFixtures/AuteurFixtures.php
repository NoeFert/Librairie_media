<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(); 

        $auteurs = [
            [
                'name' => 'Nono', 
                'role' => 'Développeuse',   
                'cover_url' => 'https://images.artfight.net/character/th_QnH7bg9v0t9XLzBAWCvW8IacJgk8lZQSDm8073li4lsldVX579AV5AYG0Yso.png?t=1748768493',
            ],
        ];

        $roles = [
            'Auteur',
            'Co-auteur',
            'Écrivain-ve',
            'Directeur-trice graphique',
            'Traducteur-trice',
            'Illustrateur-trice',
            'Développeur-se',
            'Acteur-trice',
            'Animateur-trice',
        ];

        foreach ($auteurs as $i => $auteurData) { 
            $auteur = new Auteur();
            $auteur->setName($auteurData['name']); 
            $auteur->setRole($auteurData['role']);  

            $manager->persist($auteur);
        }

        for ($i = 0; $i < 100; $i++) {
            shuffle($roles);

            $auteur = new Auteur();
            $auteur->setName($faker->name());
            $auteur->setRole($roles[0]);

            $manager->persist($auteur);
        }

        $manager->flush();
    }
}