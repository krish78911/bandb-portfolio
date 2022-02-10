<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('roomid', IntegerType::class)
            ->add('datefrom', TextType::class)
            ->add('dateto', TextType::class)
            ->add('numberofpeople', IntegerType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
        ;
    }

    /**
    * @param OptionsResolverInterface $resolver
    */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'cascade_validation' => true,
            'roomid' => 0,
            'datefrom' => '',
            'dateto' => '',
            'numberofpeople' => '',
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'phone' => '',
            ]);
    }
}
