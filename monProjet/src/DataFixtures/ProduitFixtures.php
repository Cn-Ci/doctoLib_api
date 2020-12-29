<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Adresse;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for ($i=1; $i <= 10; $i++) {
            $adresse = new Adresse();

            $libelle = $faker->streetAddress;

            $adresse->setLibelle($libelle)
                    ->setClient((new Client())->getId(mt_rand(1,5)));

            $manager->persist($adresse);
        }

        for ($i=1; $i <= 10; $i++) {
            $client = new Client();

            $nom = $faker->lastName;
            $prenom = $faker->firstName;

            $client->setNom($nom)
                    ->setPrenom($prenom);

            $manager->persist($client);
        }

        for($j =1; $j <= mt_rand(2,10); $j++) {
            $categorie = new Categorie();

            $libelle = $faker->word;
            $categorie->setLibelle($libelle);

           
                for ($i=1; $i <= 10; $i++) {
                    $produit = new Produit();
        
                    $designation = $faker->word;
                    $couleur = $faker->word;
        
                    $produit->setDesignation($designation)
                            ->setPrix(mt_rand(99, 599))
                            ->setCouleur($couleur)
                            ->setCategorieProduit($categorie);
                            
                    $manager->persist($categorie);
                }
               
                for ($k=1; $k <= 5; $k++) {
                    $user = new User();
                    
                    $email = $faker->unique()->email;
                    $password = $faker->password;
                    $nom = $faker->firstname;
                    $prenom = $faker->lastname;
                    $date = $faker->dateTimeBetween();
                    $inscription = $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null);
        
                    $user->setEmail($email)
                            ->setPassword($password)
                            ->setNom($nom)
                            ->setPrenom($prenom)
                            ->setDateAnniversaire($date)
                            ->setDateInscription($inscription);
                            
                    $manager->persist($user);
                }
                
            
            $manager->persist($produit);
            // $product = new Product();
            // $manager->persist($product);
        }
        $manager->flush();
    }
}
