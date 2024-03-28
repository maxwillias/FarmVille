<?php

namespace App\Form;

use App\Entity\Fazenda;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GadoType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('codigo', TextType::class, ['label' => 'Código do gado:'])
            ->add('leite', NumberType::class, ['label' => 'Número de litros de leite produzido por semana:'])
            ->add('racao', NumberType::class, ['label' => 'Quantidade de alimento ingerida por semana - em quilos:'])
            ->add('peso', NumberType::class, ['label' => 'Peso do animal em quilos:'])
            ->add('nascimento', DateType::class, ['label' => 'Data de nascimento do animal:'])
            ->add('fazenda_id', EntityType::class, [
                'class' => Fazenda::class,
                'choice_label' => 'nome',
                'label' => 'Fazendo do gado:'
            ])
            ->add('Salvar', SubmitType::class);
    }
}