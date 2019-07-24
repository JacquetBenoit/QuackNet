<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackForm;
use Doctrine\ORM\EntityManagerInterface;
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

        if (!$quack) {
            throw $this->createNotFoundException(
              'No quack for this id'
            );
        }

        return $this->render('', [
            'quack' => $quack
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

        return $this->render('quack/create.html.twig', [
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

        return $this->redirectToRoute('quack');
    }

    public function update()
    {

    }

    public function delete()
    {

    }

}
