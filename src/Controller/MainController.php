<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainController extends AbstractController 
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $index = $em->getRepository('App:Score');
        echo $index->getCountOfUserWithinScoreRange(20,50);
        echo '<br>';
        echo $index->getCountOfUsersByCondition('CA', 'm', true, true);
        echo '<br>';
        echo $index->getCountOfUsersByCondition('NY', 'w', false, true);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'message' => 'MainController'
        ]);
    }
}
