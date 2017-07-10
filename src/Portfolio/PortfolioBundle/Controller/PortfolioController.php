<?php

namespace Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Portfolio\PortfolioBundle\Entity\Message;

class PortfolioController extends Controller
{
    public function indexAction()
    {
        return $this->render('PortfolioPortfolioBundle:Portfolio:portfolio.html.twig');
    }

    public function setLangAction($lang)
    {
        $languages = array('fr','en');
        if (in_array($lang, $languages))
        {
            $this->container->get('request')->setLocale($lang);
        }
        return $this->indexAction();
    }

    public function downloadCVAction()
    {
        $fichier = "guillaume_flambard_cv_canadien_english.pdf";
        $chemin = __DIR__ . '/../../../../web/portfolio/assets/images/';
        header ("Content-type: application/force-download");
        header ("Content-disposition: filename=$fichier");

        readFile($chemin . $fichier);
        return $this->indexAction();
    }

    public function setMessageAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $email = $request->request->get('email');
            $comment = $request->request->get('comment');

            $message = \Swift_Message::newInstance()
                ->setSubject('Contact portfolio')
                ->setFrom($email)
                ->setTo('guillaume.flambard01@gmail.com')
                ->setBody('Email : ' . $email . ' Message : ' . $comment)
            ;
            $this->get('mailer')->send($message);

            $message = new Message;
            $message->setEmail($email);
            $message->setComment($comment);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        return new JsonResponse();
    }
}
