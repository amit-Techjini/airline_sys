<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FlightEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("name", TextType::class)
        ->add("seats", NumberType::class)
        ->add("price", NumberType::class)
        ->add("save", SubmitType::class,[ "label" => "Add Flight" ])
        ;
    }
}