<?php

namespace App\Controller;

use App\Entity\NewsletterMail;
use App\Form\NewsletterMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="default")
     */
    public function indexAction(Request $request): Response
    {
        $email = new NewsletterMail();
        $form = $this->createForm(NewsletterMailType::class, $email);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}