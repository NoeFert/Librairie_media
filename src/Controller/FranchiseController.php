<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseType;
use App\Repository\FranchiseRepository;
use App\Repository\PublicationRepository;
use App\Form\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/franchise')]
final class FranchiseController extends AbstractController
{
    #[Route(name: 'app_franchise_index', methods: ['GET'])]
    public function index(Request $request, FranchiseRepository $franchiseRepository): Response
    {
        $genre = null;
        $form = $this->createForm(FilterType::class, null, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);

        $genre = null;
        $name = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->get('searchedGenre')->getData();
            $name  = $form->get('searchedName')->getData();
        }

        $franchises = $franchiseRepository->findByFilters($genre, $name);

        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'filterForm' => $form,
        ]);
    }

    #[Route('/new', name: 'app_franchise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($franchise);
            $entityManager->flush();

            return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('franchise/new.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_franchise_show', methods: ['GET'])]
    public function show(Franchise $franchise, PublicationRepository $publicationRepository): Response
    {
        $publications = $publicationRepository->findByFranchiseField($franchise->getId());
        return $this->render('franchise/show.html.twig', [
            'franchise' => $franchise,
            'publications' => $publications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_franchise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Franchise $franchise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('franchise/edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_franchise_delete', methods: ['POST'])]
    public function delete(Request $request, Franchise $franchise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$franchise->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($franchise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
    }

    public function findByFilters(?Genre $genre, ?string $name): array
    {
        $query = $this->createQueryBuilder('f');

        if ($genre) {
            $query->andWhere('f.genre = :genre')
            ->setParameter('genre', $genre);
        }

        if ($name) {
            $query->andWhere('f.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        return $query->getQuery()->getResult();
    }
}
