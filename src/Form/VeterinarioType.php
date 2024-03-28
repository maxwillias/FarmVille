<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VeterinarioType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nome', TextType::class, ['label' => 'Nome do veterinário:'])
            ->add('crmv', TextType::class, ['label' => 'Código do veterinário:'])
            ->add('Salvar', SubmitType::class);
    } 
}