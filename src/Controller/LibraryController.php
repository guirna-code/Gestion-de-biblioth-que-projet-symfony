<?php

namespace App\Controller;

use App\Entity\Book; // Assurez-vous que le nom est exact (Book ou Livre)
use App\Repository\BookRepository;
use App\Repository\EmpruntRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library_home')]
    public function index(BookRepository $bookRepo): Response
    {
        // On récupère tous les livres pour les afficher sur la page d'accueil
        $books = $bookRepo->findAll();

        return $this->render('library/index.html.twig', [
            'livres' => $books
        ]);
    }

    /**
     * Cette route affiche la page de confirmation avec la photo et le prix
     */
    #[Route('/confirmation-achat/{id}', name: 'app_achat_confirmation', methods: ['GET'])]
    public function confirmation(Book $book): Response
    {
        // On envoie l'objet livre au template de confirmation
        return $this->render('library/confirmation.html.twig', [
            'livre' => $book
        ]);
    }

    #[Route('/api/library-stats', name: 'library_stats', methods: ['GET'])]
    public function stats(BookRepository $bookRepo, UserRepository $userRepo, EmpruntRepository $empruntRepo): JsonResponse
    {
        return $this->json([
            'books' => $bookRepo->count([]),
            'users' => $userRepo->count([]),
            'emprunts' => $empruntRepo->count([]),
        ]);
    }
}