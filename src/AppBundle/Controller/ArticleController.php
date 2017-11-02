<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @Route("/article/", name="admin_article_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();

        // Un repo est ce qui est appelé quand on veut taper sur une entité en passant par un controller. Doctrine les génère automatiquement. 
        // findBy: 1st param groupe de conditions sur les colonnes,
        // findBy: 2e param order & grouper
        // Il y a aussi find($id), findAll, findById, findBySlug($slug || $id), findOneBy (retourne un seul élément)
        // les finds retournent un objet/collection ou false 
        $articles = $em->getRepository('AppBundle:Article')->findAll();
        // return $this->render('article/index.html.twig');
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
    * @Route("article/create", name="front_article_create") 
    * @Method({"GET", "POST"}) 
    */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash(`success`, `L'article {$article->getTitle()} a été créé!`);

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('article/create.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}