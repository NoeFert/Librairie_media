<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mediaTypes = [
            'Roman',
            'Manga',
            'Anime',
            'Jeu de rôle',
            'Jeu de cartes',
            'Jeu vidéo',
            'Jouet',
            'Bande dessinée',
            'Film',
            'Série TV',
            'Jeu de société',
            'Figurine',
            'Artbook',
            'Light Novel',
            'Webtoon',
            'Podcast',
            'Manhwa',
            'Spin-off',
        ];
        
        foreach ($mediaTypes as $i => $mediaType) { 
            $media = new Media();
            $media->setName($mediaType);  

            $manager->persist($media);
        }

        $manager->flush();
    }
}
