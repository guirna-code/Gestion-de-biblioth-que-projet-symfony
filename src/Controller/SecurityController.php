<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/check-role', name: 'app_check_role')]
    public function checkRole(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isGranted('ROLE_ADMIN')) {
            // Assure-toi que cette route existe, sinon mets 'app_user_index'
            return $this->redirectToRoute('app_user_index');
        }

        return $this->redirectToRoute('library_home');
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }

    // --- CETTE ROUTE SERT À RÉPARER TON MOT DE PASSE ---
    #[Route('/fix-admin', name: 'fix_admin')]
    public function fixAdmin(EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $repo): Response
    {
        $user = $repo->findOneBy(['email' => 'yahyatest@gmail.com']);
        
        if (!$user) {
            return new Response("Erreur : L'utilisateur avec l'email yahyatest@gmail.com n'existe pas en base de données.");
        }

        // Symfony va hacher 'admin123' parfaitement selon TA configuration
        $hashedPassword = $hasher->hashPassword($user, 'admin123');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);

        $em->flush();

        return new Response("Succès ! Le mot de passe a été mis à jour. <a href='/login'>Aller au login</a> et tape admin123");
    }
    #[Route(path: '/logout', name: 'app_logout')]
public function logout(): void
{
    // Cette méthode peut rester vide. 
    // Symfony interceptera la requête avant qu'elle ne soit exécutée.
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
}
}