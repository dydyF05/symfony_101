<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_index")
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
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
    * @Route("/create", name="front_article_create") 
    * @Method({"GET", "POST"})
    * @param Request $request
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

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/create.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/update", name="front_article_update") 
    * @Method({"GET", "PUT"})
    * @param Request $request
    * @param Article $article
    */
    public function updateAction(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash(`success`, `L'article {$article->getTitle()} a été modifié!`);

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/create.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/delete", name="front_article_delete") 
    * @Method({"DELETE"})
    * @param Request $request
    * @param Article $article
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function deleteAction(Request $request, Article $article)
    {
        $token = $request->attributes->get('token');

        if (!$this->isCsrfTokenValid('delete_article', $token)) {
            throw new AccessDeniedException('Erreur CSRF');
        }

        $article->setRemoved(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return $this->redirectToRoute('article_index');
    }

    /**
    * @Route("/detail", name="front_article_detail") 
    * @Method({"GET"})
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function findAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get('id');

        var_dump($id);

        $article = $em->getRepository('AppBundle:Article')->find($id);
        return $this->render('article/detail.html.twig', [
            'article' => $article
        ]);
    }
}