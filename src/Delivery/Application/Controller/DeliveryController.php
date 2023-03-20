<?php

namespace App\Delivery\Application\Controller;

use App\Common\Domain\ValueObject\OrderId;
use App\Delivery\Domain\Repository\DeliveryRepository;
use App\Delivery\Domain\Service\ApproveDeliveryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends AbstractController
{
    public function status(string $orderId, DeliveryRepository $deliveryRepository): Response
    {
        $deliveryInfo = $deliveryRepository->getDeliveryInfoByOrderId(OrderId::fromString($orderId));
        return $this->render('delivery/status.html.twig', [
            'deliveryInfo' => $deliveryInfo,
        ]);
    }

    public function approve(string $orderId, ApproveDeliveryService $approveDeliveryService): Response
    {
        $approveDeliveryService->approve(OrderId::fromString($orderId));
        return $this->redirectToRoute('delivery_status', ['orderId' => $orderId]);
    }
}
