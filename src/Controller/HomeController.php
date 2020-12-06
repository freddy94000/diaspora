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
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="default")
     */
    public function indexAction(Request $request): Response
    {
        $email = new NewsletterMail();
        $form = $this->createForm(NewsletterMailType::class, $email);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();

            $newsletterMailRepository = $this->getDoctrine()->getRepository(NewsletterMail::class);
            if ($newsletterMailRepository->findOneBy(['email' => $email->getEmail()])) {
                $this->addFlash('warning', 'Vous êtes déjà inscrit à la newsletter');
                return $this->redirectToRoute('default');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();

            $this->addFlash('success', 'Votre inscription à la newsletter s\'est déroulée avec succès');

            return $this->redirectToRoute('default');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/newsletters", name="newsletters")
     */
    public function newslettersAction(Request $request): Response
    {
        $newsletterMailRepository = $this->getDoctrine()->getRepository(NewsletterMail::class);
        $emails = $newsletterMailRepository->findAll();

        $email = new NewsletterMail();
        $form = $this->createForm(NewsletterMailType::class, $email, [
            'action' => $this->generateUrl('default'),
        ]);

        $form->handleRequest($request);

        return $this->render('home/newsletters.html.twig', [
            'emails' => $emails,
            'form' => $form->createView(),
        ]);
    }

}
