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

    public function setMessageAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $email = $request->request->get('email');
            $comment = $request->request->get('comment');
            //$message = new Message;
            //$message->setEmail($email);
            //$message->setComment($comment);

            //$em = $this->getDoctrine()->getManager();
            //$em->persist($message);
            //$em->flush();
        }

        return new JsonResponse();
    }
}
