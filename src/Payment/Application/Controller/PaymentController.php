<?php

namespace App\Payment\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('payment/index.html.twig');
    }
}
