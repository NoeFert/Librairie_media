<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = [
            'Science-fiction',
            'Fantasy',
            'Romance',
            'Horreur',
            'Thriller',
            'Aventure',
            'Policier',
            'Comédie',
            'Drame',
            'Historique',
            'Mystère',
            'Dystopie',
            'Superhéros',
            'Western',
            'Espionnage',
            'Mythologie',
            'Post-apocalyptique',
            'Steampunk',
            'Slice of Life',
            'Sports',
        ];

        foreach ($genres as $i => $genreName) { 
            $genre = new Genre();
            $genre->setName($genreName);  

            $manager->persist($genre);
        }

        $manager->flush();
    }
}
