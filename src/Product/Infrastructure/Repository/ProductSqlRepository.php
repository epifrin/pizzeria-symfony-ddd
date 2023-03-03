<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\ProductRepository;
use App\Product\Domain\ViewModel\Product;

final class ProductSqlRepository implements ProductRepository
{
    public function __construct()
    {
    }

    public function getProductList(): array
    {
        // TODO: Implement getProductList() method.
        return [
            new Product(1, 'MARGHERITA', 'https://ilmolino.ua/media/ilmolino/images/products/cache/b/f/f/6/0/bff60631d8fb3b0724810e1558765eb420c65ba5.webp', 'Tomatoеs, mozzarella, basil. Allergens: cereals, lactose.'),
            new Product(2, 'PEPPERONI', 'https://ilmolino.ua/media/ilmolino/images/products/cache/3/7/b/7/2/37b72f0cd0603cb192d1f25047ea2b546e679b3c.webp', 'Ground tomatoes, mozzarella, spicy salami "Pepperoni". Allergens: cereals, lactose.'),
            new Product(3, 'QUATTRO FORMAGGIO', 'https://ilmolino.ua/media/ilmolino/images/products/cache/0/8/b/b/b/08bbb0294d099a81926453a7f6430063757a40cd.webp', 'Mozzarella, gorgonzola, parmigiano, provolone. Allergens: cereals, lactose.'),
            new Product(4, 'NEAPOLITANA', 'https://ilmolino.ua/media/ilmolino/images/products/cache/5/5/1/9/7/5519706396685a218ac36407cdba53252f2d9957.webp', 'Ground tomatoes, mozzarella, prosciutto cotto, fresh champignons, bazil, olive oil. Allergens: cereals, lactose.'),

        ];
    }
}
