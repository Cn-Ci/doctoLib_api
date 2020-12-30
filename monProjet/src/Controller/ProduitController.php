<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProduitType;
use App\Service\ProduitService;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ProduitException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

   
class ProduitController extends AbstractController
{
     /**
    * @Route("/home", name="index_prod")
    */
    public function index(ProduitService $service): Response
    {
        try {
        } catch (\ProduitException $e) {
            return $this->render('produit/index.html.twig', [
                'produits' => [],
                'error' => $e->getMessage()
                ]);
        }
        return $this->render('produit/index.html.twig', [
        ]);
    }
    
    /**
    * @Route("/produit/affiche", name="list_produit")
    */
    public function afficheProduits(ProduitService $service): Response
    {
        try {
        
        //$repo = $this->getDoctrine()->getRepository(Produit::class);
        //$produits = $repo->findAll();
        $produits = $service->searchAll();
        
        } catch (\ProduitException $e) {
            return $this->render('produit/list.html.twig', [
                'produits' => [],
                'error' => $e->getMessage()
                ]);
        }
        return $this->render('produit/list.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
    * @Route("/produit/add", name="add_produit")
    *
    * @return Response
    */
    public function add(ProduitService $service, Request $request): Response
    {
        try {
            $produit = new Produit();
            $form = $this->createForm(ProduitType::class, $produit);
            // $form = $this->createFormBuilder($produit)->add("designation")
            //  ->add("prix")
            //  ->add("couleur")
            //  ->add("save", SubmitType::Class, [ "label" => "Ajouter le produit"])
            //  ->getForm();
            
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
            //     // $produit = $form->getData();
            //    // $manager = $this->getDoctrine()->getManager();
            //     $manager->persist($produit);
            //     $manager->flush();
                $form = $service->add($produit);
                $this->addFlash( 
                    'success',
                    "L'annonce {$produit->getDesignation()} a bien été ajouté !"
                );
                return $this->redirectToRoute("list_produit");
            }
        } catch (\ProduitException $ex) {
            return $this->render('produit/list.html.twig', [
                'produits' => [],
                'error' => $e->getMessage(),
                ]);
        }
            $prenom = 'cindy';
            return $this->render('produit/add.html.twig', [
                'title' => 'Ajout',
                'titreForm' => "Ajouter une nouvelle annonce ",
                'prenom' => $prenom,
                'form' => $form->createView(),
                'btnTitle' => 'Ajouter un produit'
            ]);
    } 

    /**
    * @Route("/produit/edit/{id}", name="edit_produit", methods={"GET","POST"})
    * 
    * @return Response
    */
   public function editProduit(ProduitService $service, Produit $produit, Request $request): Response
   {
        try {
             $form = $this->createForm(ProduitType::class, $produit);
            
             $form->handleRequest($request);
             if($form->isSubmitted() && $form->isValid()){
                //     // $produit = $form->getData();
                //    // $manager = $this->getDoctrine()->getManager();
                //     $manager->persist($produit);
                //     $manager->flush();
                    $form = $service->update($produit);
                    $this->addFlash( 
                        'success',
                        "L'annonce {$produit->getDesignation()} a bien été modifier !"
                    );
                    return $this->redirectToRoute("list_produit");
                }
        } catch (\ProduitException $e) {
            return $this->render('produit/list.html.twig', [
                'produits' => [],
                'error' => $e->getMessage(),
                ]);
        }
        $prenom = 'cindy';
            return $this->render('produit/edit.html.twig', [
                'title' => 'Modification',
                'titreForm' => "Modifier l'annonce {$produit->getDesignation()}",
                'prenom' => $prenom,
                'produit' => $produit,
                'form' => $form->createView(),
                'btnTitle' => 'Modifier le produit',
            ]);
   } 

    /**
     * @Route("/produit/delete/{id}", name="delete_produit")
     * 
     * @return Response
     */
    public function delete(Produit $produit, ProduitService $service): Response
    {
       try {
            // $manager->remove($produit);
            // $manager->flush();
            $id = $service->delete($produit);
            $this->addFlash( 
                'success',
                "L'annonce {$produit->getDesignation()} a bien été supprimé !"
            );
            return $this->redirectToRoute('list_produit');
        } catch (\ProduitException $e) {
            $prenom = 'cindy';
            return $this->render('produit/list.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }
        return $this->render('produit/list.html.twig', [
        ]);
    }
    
     /** Permet d'afficher une seule annonce
     * 
     * @Route("/produit/show/{id}", name ="show_produit")
     * 
     * 
     * @return Response
     */
    public function showOne(Produit $produit) {
        try {
            // recupere l'annonce qui correspond au produit
            // $produit = $repo->findOneById($id);

            return $this->render('produit/show.html.twig', [ 
                'title' => 'Consultation',
                'produit' => $produit,
            ]);
        } catch (\ProduitException $ex) {
            echo "Exception Found - " . $ex->getMessage() . "<br/>";
        }
    }

}
