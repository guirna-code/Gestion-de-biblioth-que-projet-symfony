<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
final class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index');
    }
    #[Route('/commander/{id}', name: 'app_emprunt_commander', methods: ['GET'])]
#[Route('/commander/{id}', name: 'app_emprunt_commander', methods: ['GET'])]
public function commander(Book $book, EntityManagerInterface $em): Response
{
    // 1. Récupérer l'utilisateur connecté
    $user = $this->getUser();
    
    if (!$user) {
        $this->addFlash('danger', 'Vous devez être connecté pour commander.');
        return $this->redirectToRoute('app_login');
    }

    // 2. LOGIQUE DE SÉCURITÉ
    // On vérifie si le livre est déjà réservé
    if (!$book->isDisponible()) {
        $this->addFlash('warning', 'Ce livre a déjà été commandé par quelqu\'un d\'autre.');
        return $this->redirectToRoute('library_home');
    }

    // 3. MISE À JOUR DU STATUT DU LIVRE
    $book->setDisponible(false); 

    // 4. CRÉATION DE L'ENTITÉ EMPRUNT (Une seule fois !)
    $emprunt = new Emprunt();
    $emprunt->setUtilisateur($user);          // Relation vers l'objet User
    $emprunt->setLivre($book->getTitre());    // On utilise bien getTitre()
    $emprunt->setEmpruntdate(new \DateTime()); // Date d'aujourd'hui
    
    // Date de retour prévue (+15 jours)
    $dateRetour = (new \DateTime())->modify('+15 days');
    $emprunt->setDateretour($dateRetour);

    // 5. ENREGISTREMENT GLOBAL (Un seul flush à la fin)
    $em->persist($book);
    $em->persist($emprunt);
    $em->flush(); // Cette ligne enregistre tout en une seule transaction SQL

    // 6. MESSAGE DE SUCCÈS
    $this->addFlash('success', 'Paiement effectué avec succès ! Le livre "' . $book->getTitre() . '" est désormais à vous.');

    // 7. REDIRECTION VERS L'INDEX DES EMPRUNTS
    return $this->redirectToRoute('app_emprunt_index');
}
}