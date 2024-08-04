<?php

namespace App\Form\Configuracoes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AlterarEmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => [
                    'constraints' => [
                        new Length([
                            'min' => 4,
                            'minMessage' => 'O email deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                            'maxMessage' => 'O email deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                            'max' => 100,
                        ]),
                        new NotBlank([
                            'message' => 'Insira um email',
                        ]),
                        new Email([
                            'message' => 'O email "{{ value }}" não é um email válido.',
                        ]),
                        new Regex([
                            'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                            'message' => 'O campo email possui caracteres inadequados'
                        ]),
                    ],
                    'label' => 'Insira seu novo Email',
                    'attr' => [
                        'placeholder' => 'Insira um valor',
                    ],
                ],
                'second_options' => [
                    'label' => 'Repita o email',
                    'attr' => [
                        'placeholder' => 'Repita o valor',
                    ],
                ],
                'invalid_message' => 'Os emails devem corresponder.',
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
