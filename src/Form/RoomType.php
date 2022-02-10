<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roomtype', TextType::class)
            ->add('maxpeople', ChoiceType::class, [
                'choices'  => [
                    'Persons' => '',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ],
            ])
            ->add('price', TextType::class)
            ->add('availability', TextType::class)
            // ->add('checkin', TextType::class)
            // ->add('checkout', TextType::class)
            // ->add('privatebathroom', TextType::class)
            ->add('checkin', ChoiceType::class, [
                'choices'  => [
                    'Check In' => '',
                    '00:00' => '00:00',
                    '01:00' => '01:00',
                    '02:00' => '02:00',
                    '03:00' => '03:00',
                    '04:00' => '04:00',
                    '05:00' => '05:00',
                    '06:00' => '06:00',
                    '07:00' => '07:00',
                    '08:00' => '08:00',
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '12:00' => '12:00',
                    '13:00' => '13:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                    '17:00' => '17:00',
                    '18:00' => '18:00',
                    '19:00' => '19:00',
                    '20:00' => '20:00',
                    '21:00' => '21:00',
                    '22:00' => '22:00',
                    '23:00' => '23:00',
                    '24:00' => '24:00',
                ],
            ])
            ->add('checkout', ChoiceType::class, [
                'choices'  => [
                    'Check Out' => '',
                    '00:00' => '00:00',
                    '01:00' => '01:00',
                    '02:00' => '02:00',
                    '03:00' => '03:00',
                    '04:00' => '04:00',
                    '05:00' => '05:00',
                    '06:00' => '06:00',
                    '07:00' => '07:00',
                    '08:00' => '08:00',
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '12:00' => '12:00',
                    '13:00' => '13:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                    '17:00' => '17:00',
                    '18:00' => '18:00',
                    '19:00' => '19:00',
                    '20:00' => '20:00',
                    '21:00' => '21:00',
                    '22:00' => '22:00',
                    '23:00' => '23:00',
                    '24:00' => '24:00',
                ],
            ])
            ->add('privatebathroom', ChoiceType::class, [
                'choices'  => [
                    'Private Bathroom' => '',
                    'yes' => 'yes',
                    'no' => 'no'
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['maxlength' => 400]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
