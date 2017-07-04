<?php

namespace PancakeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="gindex")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }
}
