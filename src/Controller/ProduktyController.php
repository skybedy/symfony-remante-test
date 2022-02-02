<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ProduktyModel;
use App\Model\BaseModel;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProduktyController extends AbstractController
{
    /**
     * @Route("/produkty", name="produkty")
     */
    public function index(ProduktyModel $produkty,Connection $conn,BaseModel $base,Request $request): Response
    {
        $vyrobce_id = $request->query->get('vyrobce_id');
        $typ_produktu_id = $request->query->get('typ_produktu_id');
        $produkt_list = $produkty->ProductList($conn,$vyrobce_id,$typ_produktu_id,0,"produkt_nazev");
        $pagination_pocet = floor($produkt_list[0] / 10);   

        return $this->render('produkty/index.html.twig', [
            'title' => 'Produkty',
            'vyrobce_list' => $base->VyrobceList($conn),
            'typ_produktu_list' => $base->TypProduktuList($conn),
            'produkt_list' => $produkt_list[1],
            'pocet' => $produkt_list[0],
            'typ_produktu_id' => $typ_produktu_id,
            'vyrobce_id' => $vyrobce_id,
            'pagination_pocet' => $pagination_pocet

        ]);
   }


   /**
     * @Route("/produkt-list/{typ_produktu_id}/{vyrobce_id}/{order}/{from}", name="product-list")
     */
    public function productList(ProduktyModel $produkty,Connection $conn,$typ_produktu_id,$vyrobce_id,$order,$from): response
    {
        $produkt_list = $produkty->ProductList($conn,$vyrobce_id,$typ_produktu_id,$from,$order);
        return new JsonResponse($produkt_list);
    }


    /**
     * @Route("/produkt-edit-form/{produkt_id}", name="product-edit-form")
     */
    public function produktEditForm(ProduktyModel $produkty,Connection $conn,$produkt_id): response
    {
        $produkt = $produkty->ProduktEditForm($conn,$produkt_id);
        return new JsonResponse($produkt);
    }


    /**
     * @Route("/produkt-edit/{produkt_id}/{produkt_cena}/{produkt_nazev}/{typ_produktu_id}/{vyrobce_id}/{from}", name="product-edit")
     */
    public function produktEdit(ProduktyModel $produkty,Connection $conn,$produkt_id,$produkt_cena, $produkt_nazev,$typ_produktu_id,$vyrobce_id,$from): response
    {
        $produkt_list = $produkty->ProduktEdit($conn,$produkt_id,$produkt_cena, $produkt_nazev,$typ_produktu_id,$vyrobce_id,$from);
        return new JsonResponse($produkt_list);
    }



}
