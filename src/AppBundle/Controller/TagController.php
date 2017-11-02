<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("tags")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tag_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
 
        $tags = $em->getRepository('AppBundle:Tag')->findAll();
        return $this->render('tag/index.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
    * @Route("/create", name="front_tag_create") 
    * @Method({"GET", "POST"})
    * @param Request $request
    */
    public function createAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash(`success`, `Le tag {$tag->getName()} a été créé!`);

            return $this->redirectToRoute('tag_index');
        }

        return $this->render('tag/create.html.twig', [
            'tag' => $tag,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/update", name="front_tag_update") 
    * @Method({"GET", "POST", "PUT"})
    * @param Request $request
    * @param Tag $tag
    */
    public function updateAction(Request $request, Tag $tag)
    {
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash(`success`, `Le tag {$tag->getTitle()} a été modifié!`);

            return $this->redirectToRoute('tag_index');
        }

        return $this->render('tag/create.html.twig', [
            'tag' => $tag,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/delete", name="front_tag_delete") 
    * @Method({"GET"})
    * @param Request $request
    * @param Tag $tag
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function deleteAction(Request $request, Tag $tag)
    {
        $token = $request->attributes->get('token');

        if (!$this->isCsrfTokenValid('delete_tag', $token)) {
            throw new AccessDeniedException('Erreur CSRF');
        }

        $tag->setRemoved(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();

        return $this->redirectToRoute('tag_index');
    }

    /**
    * @Route("/detail", name="front_tag_detail") 
    * @Method({"GET"})
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $tag = $em->getRepository('AppBundle:Tag')->find($id);
        return $this->render('tag/detail.html.twig', [
            'tag' => $tag
        ]);
    }
}