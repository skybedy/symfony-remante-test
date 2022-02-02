<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use App\Model\HomeModel;
use App\Model\BaseModel;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HomeModel $home,Connection $conn,BaseModel $base): Response
    {
        
        return $this->render('home/index.html.twig', [
            'title' => 'Hlavní strana',
            'vyrobce_list' => $base->VyrobceList($conn),
            'typ_produktu_list' => $base->TypProduktuList($conn),
        ]);
    }
}
