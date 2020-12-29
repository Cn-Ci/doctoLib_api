<?php

namespace App\Controller;

use App\Form\RegisterEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * @Route("/registerEdit", name="register_edit")
     * 
     * @return Response
     */
    public function registerEdit(Request $request, EntityManagerInterface $manager) {
        $user = $this->getUser();

        $form = $this->createForm(RegisterEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Les modifications du profil ont bien été enregistrées'
            );
            return $this->redirectToRoute("list_produit");
        }

        return $this->render('registration/registerEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/passwordEdit", name="password_edit")
     * 
     * @return Response
     */
    public function passwordEdit(Request $request, EntityManagerInterface $manager) {
        $user = $this->getUser();

        $form = $this->createForm(RegisterEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le mdp du profil ont bien été modifié'
            );
            return $this->redirectToRoute("list_produit");
        }

        return $this->render('registration/passwordEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
