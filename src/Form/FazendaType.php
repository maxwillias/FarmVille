<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FazendaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nome', TextType::class, ['label' => 'Nome da fazenda:'])
            ->add('tamanho', NumberType::class, ['label' => 'Tamanho da fazenda em hectares (HA):'])
            ->add('responsavel', TextType::class, ['label' => 'Nome do responsável pela fazenda:'])
            ->add('Salvar', SubmitType::class);
    }
}