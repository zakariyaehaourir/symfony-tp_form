<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                ],
                'help' => 'Please chose a number between 1 and 10.',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Fill the quantity field.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'La quantité doit être au moins {{ compared_value }}.',
                    ]),
                    new Assert\LessThanOrEqual([
                        'value' => 10,
                        'message' => 'La quantité ne peut pas dépasser {{ compared_value }}.',
                    ]),
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Select Color',
                'choices' => [
                    'Matte Black' => 'black',
                    'Pearl White' => 'white',
                    'Silver' => 'silver',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {}
}
