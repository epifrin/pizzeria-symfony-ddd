<?php

namespace App\Order\Application\Controller;

use App\Order\Application\Form\OrderForm;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Service\OrderService;
use App\Order\Domain\Service\OrderProductsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly OrderProductsService $productService,
    ) {
    }

    public function create(Request $request): Response
    {
        // TODO: validate $request->get('products')
        $orderProducts = $this->productService->getProducts($request->get('products'));

        $newOrder = new NewOrder();
        $orderForm = $this->createForm(OrderForm::class, $newOrder);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $orderId = $this->orderService->create($newOrder, $orderProducts);
            return $this->redirectToRoute('payment_index', ['orderId' => $orderId]);
        }

        return $this->render('order/create.html.twig', [
            'orderForm' => $orderForm,
            'orderProducts' => $orderProducts,
        ]);
    }
}
