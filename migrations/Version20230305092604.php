<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305092604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');

        $this->addSql('CREATE TABLE product (
            product_id SMALLSERIAL,
            title varchar(50) NOT NULL,
            price int NOT NULL,
            image varchar(255),
            description TEXT,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(product_id)
        );');

        $this->addSql("INSERT INTO product (title, price, image, description) VALUES
            ('MARGHERITA', 1000, 'https://ilmolino.ua/media/ilmolino/images/products/cache/b/f/f/6/0/bff60631d8fb3b0724810e1558765eb420c65ba5.webp', 'Tomatoеs, mozzarella, basil. Allergens: cereals, lactose.'),
            ('PEPPERONI', 1200, 'https://ilmolino.ua/media/ilmolino/images/products/cache/3/7/b/7/2/37b72f0cd0603cb192d1f25047ea2b546e679b3c.webp', 'Ground tomatoes, mozzarella, spicy salami \"Pepperoni\". Allergens: cereals, lactose.'),
            ('QUATTRO FORMAGGIO', 1400, 'https://ilmolino.ua/media/ilmolino/images/products/cache/0/8/b/b/b/08bbb0294d099a81926453a7f6430063757a40cd.webp', 'Mozzarella, gorgonzola, parmigiano, provolone. Allergens: cereals, lactose.'),
            ('NEAPOLITANA', 1150, 'https://ilmolino.ua/media/ilmolino/images/products/cache/5/5/1/9/7/5519706396685a218ac36407cdba53252f2d9957.webp', 'Ground tomatoes, mozzarella, prosciutto cotto, fresh champignons, bazil, olive oil. Allergens: cereals, lactose.')
            ;");

        $this->addSql('CREATE TABLE public.order (
            order_id uuid NOT NULL,
            firstname varchar(50) NOT NULL,
            lastname varchar(50) NOT NULL,
            phone varchar(16) NOT NULL,
            delivery_address varchar(255),
            total_amount int NOT NULL,
            status int NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(order_id)
        );');

        $this->addSql('CREATE TABLE order_item (
            id SERIAL,
            order_id uuid NOT NULL,
            product_id int NOT NULL,
            quantity int NOT NULL,
            price int NOT NULL,
            product_title varchar(50),
            PRIMARY KEY(id)
        );');

        $this->addSql('CREATE TABLE payment (
            payment_id uuid NOT NULL,
            order_id uuid NOT NULL,
            amount int NOT NULL,
            status int NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            paid_at TIMESTAMP(0) WITHOUT TIME ZONE,
            PRIMARY KEY(payment_id)
        );');

        $this->addSql('CREATE UNIQUE INDEX order_id_index ON payment (order_id);');

        $this->addSql('CREATE TABLE delivery (
            id SERIAL,
            order_id uuid NOT NULL,
            firstname varchar(50) NOT NULL,
            lastname varchar(50) NOT NULL,
            phone varchar(16) NOT NULL,
            delivery_address varchar(255) NOT NULL,
            delivery_man varchar(255) NOT NULL,
            status int NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            PRIMARY KEY(id)
        );');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE public.order');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
