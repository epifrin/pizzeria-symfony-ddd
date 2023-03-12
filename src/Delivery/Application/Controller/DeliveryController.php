<?php

namespace App\Delivery\Application\Controller;

use App\Delivery\Domain\Repository\DeliveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends AbstractController
{
    public function status(string $orderId, DeliveryRepository $deliveryRepository): Response
    {
        return $this->render('delivery/status.html.twig');
    }
}
