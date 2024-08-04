<?php

declare(strict_types=1);

namespace App\Form\Configuracoes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class AlterarDataNascimentoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $atual = new \DateTime();
    $minidade = (new \DateTime())->modify('-95 years');
    $maxidade = (new \DateTime())->modify('-18 years');

    $builder
        ->add('nascimento', DateType::class, [
            'label' => 'Nova data de Nascimento',
            'years' => range($minidade->format('Y'), $maxidade->format('Y')),
            'attr' => [
                'class' => 'datte'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Por favor, insira sua data de nascimento.',
                ]),
                new LessThanOrEqual([
                    'value' => $maxidade,
                    'message' => 'Você deve ser maior de idade.',
                ]),
                new GreaterThanOrEqual([
                    'value' => $minidade,
                    'message' => 'Data de nascimento não pode ser inferior a 95 anos atrás.',
                ]),
            ],
        ])
        ->add('enviar', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary',
            ],
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
