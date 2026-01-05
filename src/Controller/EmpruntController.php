<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Book;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/emprunt')]
final class EmpruntController extends AbstractController
{
    /**
     * CETTE ROUTE DOIT RESTER ACCESSIBLE AUX CLIENTS
     */
    #[Route('/commander/{id}', name: 'app_emprunt_commander', methods: ['GET'])]
    public function commander(Book $book, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
    if (!$user) return $this->redirectToRoute('app_login');

    // 1. Sécurité anti-double commande
    if ($book->getDisponible() === false) {
        $this->addFlash('danger', 'Ce livre n\'est plus disponible.');
        return $this->redirectToRoute('library_home');
    }

        if (!$book->isDisponible()) {
            $this->addFlash('warning', 'Ce livre est déjà réservé.');
            return $this->redirectToRoute('library_home');
        }

        $emprunt = new Emprunt();
        $emprunt->setUtilisateur($user);          
        $emprunt->setLivre($book->getTitre());    
        $emprunt->setEmpruntdate(new \DateTime()); 
        
        $dateRetour = (new \DateTime())->modify('+15 days');
        $emprunt->setDateretour($dateRetour);

        $book->setDisponible(false);

        $em->persist($emprunt);
        $em->persist($book);
        $em->flush();

        $this->addFlash('success', 'Paiement effectué avec succès ! Le livre "' . $book->getTitre() . '" est réservé.');

        return $this->redirectToRoute('library_home');
    }

    /**
     * TOUTES LES ROUTES CI-DESSOUS SONT RÉSERVÉES À L'ADMIN
     */
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route(name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emprunt);
            $entityManager->flush();
            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_emprunt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_emprunt_delete', methods: ['POST'])]
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager, BookRepository $bookRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$emprunt->getId(), $request->request->get('_token'))) {
        
        // --- MODIFICATION : Rendre le livre à nouveau disponible ---
        // On cherche le livre par son titre (puisque vous stockez le titre en string)
        $book = $bookRepository->findOneBy(['titre' => $emprunt->getLivre()]);
        if ($book) {
            $book->setDisponible(true);
            $entityManager->persist($book);
        }
        // ----------------------------------------------------------

        $entityManager->remove($emprunt);
        $entityManager->flush();
        
        $this->addFlash('success', 'Emprunt supprimé et livre remis en circulation.');
    }

    return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
}
}