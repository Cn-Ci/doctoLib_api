<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SymProdController extends AbstractController
{
    /**
    * @Route("/symprod", name="symprod")
    */
    public function symProd(): Response
    {
        return $this->render('ad/index.html.twig', [
        ]);
    }

    /**
    * @Route("/symprod/ads", name="symprod_ad")
    */
    public function ad(AdRepository $repo): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();
        return $this->render('ad/ad.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route ("/symprod/new", name="symprod_new")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager ) {
        $ad = new Ad();   
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('symprod_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'edition
     * 
     * @Route("/symprod/{slug}/edit", name="symprod_edit")
     *
     * @return Response
     */
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('symprod_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher une seule annonce
     * 
     * @Route("/symprod/{slug}", name ="symprod_show")
     * 
     * @return Response
     */
    public function show(Ad $ad) {
        // recupere l'annonce qui correspond au slug
        // $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [ 
            'ad' => $ad,
        ]);
    }

}
