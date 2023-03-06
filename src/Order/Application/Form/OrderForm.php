<?php

namespace App\Order\Application\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class OrderForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['attr' => ['maxlength' => 25]])
            ->add('lastname', TextType::class, ['attr' => ['maxlength' => 25]])
            ->add('phone', NumberType::class, ['attr' => ['maxlength' => 16]])
            ->add('deliveryAddress', TextType::class, ['attr' => ['maxlength' => 100]])
            ->add('Order', SubmitType::class);
    }
}
