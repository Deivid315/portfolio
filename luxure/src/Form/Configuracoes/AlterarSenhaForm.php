<?php

declare(strict_types=1);

namespace App\Form\Configuracoes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class AlterarSenhaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Insira o nome de usuário.',
                    ]),
                ],
                'label' => 'Nome de usuário',
                'attr' => [
                    'autocomplete' => 'off',
                    'readonly' => true
                ],
            ])
            ->add('senha_atual', PasswordType::class, [
                'label' => 'Senha Atual',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Insira uma senha',
                    ]),
                ]
            ])
            ->add('senha', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Insira uma senha',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'A senha deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                            'max' => 100,
                            'maxMessage' => 'A senha deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        ]),
                        new PasswordStrength([
                            'minScore' => PasswordStrength::STRENGTH_MEDIUM,
                            'message' => 'A senha que você inseriu é muito fácil de ser adivinhada, insira uma mais difícil.'
                        ]),
                        new NotCompromisedPassword([
                            'message' => 'Esta senha foi comprometida, escolha outra',
                        ]),
                    ],
                    'label' => 'Nova Senha',
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ],
                'second_options' => [
                    'label' => 'Repetição da senha',
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ],
                'invalid_message' => 'As senhas devem corresponder.',
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
