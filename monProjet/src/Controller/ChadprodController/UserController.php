<?php

namespace App\Controller\ChadprodController;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\ChadprodEntity\Produit;
use App\Service\UserService;
use App\Repository\ChadprodRepository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('ChadprodTemplates/Chadprod/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('ChadprodTemplates/Chadprod/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('ChadprodTemplates/Chadprod/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete")
     */
    public function delete(Request $request, User $user): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

        return $this->redirectToRoute('user_index');
    }

    
    /**
     * Permet d'afficher les infos de l'user
     * 
     * @Route("/show/{email}", name ="user_show", methods={"GET","POST"})
     * 
     * @return Response
     */
    public function show(User $user) {
        // recupere l'annonce qui correspond au slug
        //$produitClient = $user->findOneByClient();
        return $this->render('ChadprodTemplates/Chadprod/user/usersShow.html.twig', [ 
           'user' => $user,
        ]);
    }
}
