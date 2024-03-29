<?php

namespace App\Form;

use App\Entity\Veterinario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('veterinarios', EntityType::class, [
                'class' => Veterinario::class,
                'choice_label' => 'nome',
                'multiple' => true,
                'expanded' =>true,
                'label' => 'Veterinários da fazenda:'
            ])
            ->add('Salvar', SubmitType::class);
    }
}