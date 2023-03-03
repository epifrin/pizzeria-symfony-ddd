<?php

namespace App\Product\Application\Controller;

use App\Product\Domain\Query\GetProductListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends AbstractController
{
    public function __construct(
        private readonly GetProductListQuery $getProductList
    ) {
    }

    public function list(): Response
    {
        $productList = $this->getProductList->getList();
        return $this->render('product_list.html.twig', [
            'productList' => $productList,
        ]);
    }
}
