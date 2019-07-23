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
     * @Route("/quack", name="quack")
     */
    public function index()
    {
        return $this->render('quack/index.html.twig', [
            'controller_name' => 'QuackController',
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

        return $this->render('quack/index.html.twig', [
            'quack' => $quack
    ]);
    }

    /**
     * @Route("/create", name="quack_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        dump($request);
        $form = $this->createForm(QuackForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));
            $data = $form->getData();
            $quack = new Quack();
            $quack->setContent($data['content']);
            $quack->setCreatedAt($date);
            dd($quack);

            $em->persist($quack);
            $em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('quack/create.html.twig', [
            'quackForm' => $form->createView()
        ]);
    }

    public function update()
    {

    }

    public function delete()
    {

    }

}