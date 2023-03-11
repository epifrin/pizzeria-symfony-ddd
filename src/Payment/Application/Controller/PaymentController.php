<?php

namespace App\Payment\Application\Controller;

use App\Payment\Domain\Query\GetPaymentInfoQuery;
use App\Payment\Domain\Service\SetPaidService;
use App\Payment\Domain\ValueObject\PaymentId;
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

    public function pay(string $paymentId, SetPaidService $setPaidService): Response
    {
        $setPaidService->setPaid(PaymentId::fromString($paymentId));
        return $this->redirectToRoute('product_list');
    }

    public function cancel(string $paymentId): Response
    {
        return $this->redirectToRoute('product_list');
    }
}
