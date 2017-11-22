<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_index")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository("AppBundle:Article")->findAll();

        return $this->render("article/index.html.twig", [
            "articles" => $articles
        ]);
    }

    /**
     *  Creates an article
     *  @Route("/create", name="article_create")
     *  @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request) {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($article);
            $em->flush();

            $this->addFlash(`success`, `L'article {$article->getTitle()} a été créé!`);

            return $this->redirectToRoute("article_show", ["slug" => $article->getSlug()]);
        }

        return $this->render("article/create.html.twig", [
            "article" => $article,
            "form" => $form->createView()
        ]);
    }

     /**
     *  Updates an article
     *  @Route("/{slug}/update", name="article_update")
     *  @Method({"GET", "POST"})
     *  @return void
     */
    public function updateAction(Request $request, Article $article) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository("AppBundle:Article")->find($article);
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(`success`, `L'article {$article->getTitle()} a été modifié !`);

            return $this->redirectToRoute('article_show', ["slug" => $article->getSlug()]);
        }

        return $this->render('article/create.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * Shows an article
     * @Route("/{slug}", name="article_show")
     * @Method({"GET"})
     * @param Article $article
     * @return response
     */
    public function showAction(Request $req, Article $article) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($article);

        return $this->render("article/show.html.twig", [
            "article" => $article
        ]);
    }

    /**
     * Deletes an article
     * @Route("/delete/{slug}/token", name="article_delete")
     * @Method({"GET"})
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Article $article) {
        $token = $request->attributes->get("token");

        if($this->isCsrfTokenValid("delete_article", $token)) {
            throw new AccessDeniedException("Erreur CSRF");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("article_index");
    }
}
