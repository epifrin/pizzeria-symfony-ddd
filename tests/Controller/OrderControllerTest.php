<?php

namespace App\Tests\Controller;

use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\OrderStatus;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testCreateOrder()
    {
        $client = static::createClient();
        $client->followRedirects();
        /** @var OrderRepository $orderRepository */
        $orderRepository = $client->getContainer()->get(OrderRepository::class);

        $client->request('GET', '/order/create?products[1]=1&products[3]=1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Order details');

        $crawler = $client->submitForm('Order', [
            'order_form[firstname]' => 'John',
            'order_form[lastname]' => 'Smith',
            'order_form[phone]' => '5783475984',
            'order_form[deliveryAddress]' => 'New York, First Avenue',
        ]);

        $this->assertRouteSame('payment_index');
        $this->assertSelectorTextContains('h1', 'Pay order');
        $this->assertSelectorTextContains('b#total-amount', '$24');

        $order = $orderRepository->findOneBy([
            'customer.firstname' => 'John',
            'customer.lastname' => 'Smith',
            'status' => OrderStatus::NEW
        ]);
        $this->assertEquals(2400, $order->getTotalAmount()->getAmount());
    }
}
