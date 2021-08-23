<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
        $users = [];
        for ($i=0; $i < 50; $i++) { 
            $user = new User;
            $user->setUsername($faker->name);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setTelephone($faker->e164PhoneNumber);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $manager->persist($user);
            $users[]= $user;

        }
        $categories = [];
        for ($i=0; $i < 15; $i++) { 
            $categorie = new Categorie;
            $categorie->setName($faker->text(50));
            $categorie->setSlug($faker->text(250));
            $categorie->setImage($faker->imageUrl());
            $manager->persist($categorie);
            $categories[]=$categorie;

        }
        // $articles = [];
        // $date = "2016-06-10";
        for ($i=0; $i < 100; $i++) { 
            $article = new Article;
            $article->setTitre($faker->text(50));
            $article->setDescription($faker->text(250));
            $article->setImage($faker->imageUrl());
            $article->setDetail($faker->text(1000));
            $article->setLocalisation($faker->text(50));
            $article->setCreatDate(new \DateTime());
            $article->addCategorie($categories[$faker->numberBetween(0,14)]);
            $article->setAuthor($users[$faker->numberBetween(0,49)]);
            $manager->persist($article);
            // $articles[]=$article;
        }

        $manager->flush();
    }
}
