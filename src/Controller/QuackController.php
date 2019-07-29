<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuackController extends AbstractController
{
    /**
     * @Route("/", name="quack")
     */
    public function index()
    {
        $quacks = $this->getDoctrine()
            ->getRepository(Quack::class)
            ->findAll();

        $quacks = array_reverse($quacks);

        $form = $this->createForm(QuackForm::class);

        return $this->render('quack/index.html.twig', [
            'quacks' => $quacks,
            'quackForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/quack/{id}", name="quack_show")
     */
    public function show($id)
    {
        $quack = $this->getDoctrine()
            ->getRepository(Quack::class)
            ->find($id);

        $com = $this->getDoctrine()
            ->getRepository(Quack::class)
            ->findAll();

        if (!$quack) {
            throw $this->createNotFoundException(
              'No quack for this id'
            );
        }

        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
            'id' => $id,
            'com' => $com
    ]);
    }

    /**
     * @Route("/create", name="quack_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        //dd($request);
        $form = $this->createForm(QuackForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));
            $data = $form->getData();
            $user = $this->getUser();
            $quack = new Quack();
            $quack->setContent($data['content']);
            $quack->setCreatedAt($date);
            $quack->setAuthor($user)->getId();
            $quack->setParent(0);

//            dd($quack);
            $em->persist($quack);
            $em->flush();
            return $this->redirectToRoute('quack');
        }

        return $this->render('quack/update.html.twig', [
            'quackForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/create-comment", name="quack_create_comment", methods={"GET", "POST"})
     */
    public function createComment(Request $request, EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));
        $data = $request->get('quack');
        $parent = $request->get('parent');
        $user = $this->getUser();
        $quack = new Quack();

        $quack->setAuthor($user);
        $quack->setContent($data);
        $quack->setCreatedAt($date);
        $quack->setParent($parent);

        $em->persist($quack);
        $em->flush();

        return $this->index();
    }

    /**
     * @Route("/update", name="quack_update")
     */
    public function update(Request $request)
    {
        $form = $this->createForm(QuackForm::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));

        $id = $request->get('id');
        $quack = $this->getDoctrine()
            ->getRepository(Quack::class)
            ->find($id);

        //controle des droits de l'utilisateur
        $this->denyAccessUnlessGranted('edit', $quack);

        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setContent($data['content']);
            $quack->setCreatedAt($date);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack');
        }

        return $this->render('quack/update.html.twig', [
            'quackForm' => $form->createView(),
            'id' => $id
        ]);
    }

    /**
     * @Route("/delete", name="quack_delete")
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');

        $quack = $this->getDoctrine()
            ->getRepository(Quack::class)
            ->find($id);

        //controle des droits de l'utilisateur
        $this->denyAccessUnlessGranted('edit', $quack);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($quack);
        $entityManager->flush();

        return $this->index();
    }

    /**
     * @Route("/show-delete", name="quack_show_delete")
     */
    public function showDelete(Request $request){
        $id = $request->get('id');
        return $this->render('quack/delete.html.twig', [
            'id' => $id
        ]);
    }

}
