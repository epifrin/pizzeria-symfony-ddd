<?php

namespace App\Payment\Application\Controller;

use App\Payment\Domain\Query\GetPaymentInfoQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends AbstractController
{
    public function index(string $orderId, GetPaymentInfoQuery $getPaymentInfoQuery): Response
    {
        $paymentInfo = $getPaymentInfoQuery->getPaymentByOrderId($orderId);

        return $this->render('payment/index.html.twig', [
            'paymentInfo' => $paymentInfo,
        ]);
    }

    public function pay(): Response
    {
    }

    public function cancel(): Response
    {
    }
}
