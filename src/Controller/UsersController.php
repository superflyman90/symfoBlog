<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/users/articles/ajout", name="users_articles_ajout")
     */
    public function ajoutArticle(Request $request): Response
    {
        $article = new Articles;

        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsers($this->getUser());
            $article->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();


            return $this->redirectToRoute('users');
        }

        return $this->render('users/articles/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
