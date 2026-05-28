<?php

namespace App\DataFixtures;

use App\Entity\Franchise;
use App\Repository\GenreRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FranchiseFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private GenreRepository $genreRepository)
            {
            }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $genres = $this->genreRepository->findAll();


        $franchises = [
            [
                'name'        => 'One Piece',
                'description' => 'Un jeune pirate part à la conquête du légendaire trésor "One Piece" pour devenir le Roi des Pirates.',
                'cover_url'   => 'https://m.media-amazon.com/images/M/MV5BMTNjNGU4NTUtYmVjMy00YjRiLTkxMWUtNzZkMDNiYjZhNmViXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg',
            ],
            [
                'name'        => 'The Witcher',
                'description' => 'Dans un monde de monstres et de magie, Geralt de Riv cherche sa place dans un univers en guerre.',
                'cover_url'   => 'https://img.etimg.com/thumb/width-1600,height-900,imgsize-1160551,resizemode-75,msid-109426403/magazines/panache/the-witcher-season-5-confirmed-as-the-last-chapter-by-netflix.jpg',
            ],
            [
                'name'        => 'Dungeons & Dragons',
                'description' => 'Le jeu de rôle sur table fondateur de la fantasy moderne, où des aventuriers explorent des donjons et affrontent des dragons.',
                'cover_url'   => 'https://www.dungeonsanddragons.com/cms/dungeon-masters/featured-poster-mobile.jpg',
            ],
        ];

        foreach ($franchises as $franchiseData) {
            shuffle($genres);

            $franchise = new Franchise();
            $franchise->setName($franchiseData['name']);
            $franchise->setDescription($franchiseData['description']);
            $franchise->setCoverUrl($franchiseData['cover_url']);
            $franchise->setGenre($genres[0]);

            $manager->persist($franchise);
        }

        for ($i = 0; $i < 10; $i++) {
            shuffle($genres);

            $franchise = new Franchise();
            $franchise->setName($faker->words(rand(1, 3), true));
            $franchise->setDescription($faker->paragraph(3));
            $franchise->setCoverUrl(null);
            $franchise->setGenre($genres[0]);

            $manager->persist($franchise);
        }

        $manager->flush();
    }

    // Doctrine chargera GenreFixtures avant FranchiseFixtures automatiquement
    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
        ];
    }
}