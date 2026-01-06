<?php

namespace App\Controller;

use App\Repository\RecipesRepository;
use App\Entity\Recipes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

final class RecipeController extends AbstractController
{

    #[Route('/recette', name: 'recipe.index')]
    public function index(Request $request, RecipesRepository $repository): Response
    {

        $recipes = $repository->findWithDurationLowerThan(40);
/*
//creation d'une recette exemple, attention bien ajouter entity manager interface dans les parametres de la fonction
        $recipe = new Recipes();
        $recipe->setTitle('Carbonade Flamande')
        ->setSlug('carbonade-flamande')
        ->setContent("La carbonade flamande est un plat traditionnel belge à base de viande de bœuf mijotée dans une sauce à la bière, souvent accompagnée de pain d'épices et de moutarde. C'est un plat réconfortant et savoureux, parfait pour les journées froides.")
        ->setDuration(180)
        ->setCreatedAt(new \DateTimeImmutable())
        ->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($recipe);
        $em->flush();
*/

// exemple suppression d'une recette
 /*       $em->remove($recipes[2]);
        $em->flush();
*/
//        dd($repository->findTotalDuration());

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
    
    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id, RecipesRepository $repository): Response
    {
        $recipes = $repository->find($id);
        if ($recipes->getSlug() !== $slug) {
            return $this->redirectToRoute('recipe.show', [
                'slug' => $recipes->getSlug(),
                'id' => $recipes->getId(),
            ]);
        }
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipes,
        ]);
    }
}

