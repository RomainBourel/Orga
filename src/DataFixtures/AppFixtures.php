<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Unity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $unityData = [
            ["name" => "gramme", "shortname" => "g"],
            ["name" => "kilogramme", "shortname" => "Kg"],
            ["name" => "litre", "shortname" => "L"],
            ["name" => "pièce", "shortname" => "pièce"],
        ];
        foreach ($unityData as $data) {
            $unity = new Unity();
            $unity->setName($data["name"]);
            $unity->setShortname($data["shortname"]);
            $manager->persist($unity);
        }
        $categoryData = [
            ["name" => "nouriture"],
            ["name" => "boisson"],
            ["name" => "autre"],
        ];
        foreach ($categoryData as $data) {
            $category = new Category();
            $category->setName($data["name"]);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
