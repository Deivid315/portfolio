<?php

declare(strict_types=1);

namespace App\Form\Configuracoes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AlterarAlcunhaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alcunha', TextType::class, [
                'label' => 'Insira seu novo apelido',
                'attr' => [
                    'placeholder' => 'Apelido',
                    'autocomplete' => "off"
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'O apelido deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        'maxMessage' => 'O apelido deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        'max' => 20,
                    ]),
                    new NotBlank([
                        'message' => 'Insira um apelido',
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
