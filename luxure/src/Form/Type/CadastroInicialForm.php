<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Document\Usuario\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Constraints\Regex;

class CadastroInicialForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $minidade = (new \DateTime())->modify('-95 years');
        $maxidade = (new \DateTime())->modify('-18 years');

        $builder
        ->add('email', EmailType::class, [
            'required' => true,
            'constraints' => [
                new Length([
                    'min' => 4,
                    'minMessage' => 'O email deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }}!',
                    'maxMessage' => 'O email deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }}!',
                    'max' => 100,
                ]),
                new NotBlank([
                    'message' => 'Insira seu email',
                ]),
                new Regex([
                    'pattern' => "/^[a-zA-Z0-9._%±]+@[a-zA-Z0-9.±]+\.[a-zA-Z]{2,}$/",
                    'message' => 'O email possui caracteres inadequados, faltando ou em exceço!'
                ]),
            ],
            'invalid_message' => 'Esse valor não é permitido!',
            'label' => 'Email',
            'attr' => [
                'maxlength' => "100",
                'pattern' => "^[a-zA-Z0-9._%±]+@[a-zA-Z0-9.±]+\.[a-zA-Z]{2,}$",
                'placeholder' => 'ex: email@gmail.com',
            ],

        ])
            ->add('password', RepeatedType::class, [
                'required' => true,
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
                            'minScore' => PasswordStrength::STRENGTH_WEAK,
                            'message' => 'A senha que você inseriu é muito fácil de ser adivinhada, insira uma mais difícil.'
                        ]),
                        new NotCompromisedPassword([
                            'message' => 'Esta senha é ineficaz, escolha outra',
                        ]),
                    ],
                    'label' => 'Senha',
                    'attr' => [
                        'minlength' => "8",
                        'maxlength' => "100",
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
            ->add('alcunha', TextType::class, [
                'required' => true,
                'label' => 'Como gostaria de ser chamado',
                'attr' => [
                    'minlength' => "2",
                    'maxlength' => "20",
                    'pattern' => "^[A-Za-zÀ-ÖØ-öø-ÿ' ]+$",
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
                        'message' => 'Insira seu pseudônimo',
                    ]),
                    new Regex([
                        'pattern' => "/^[A-Za-zÀ-ÖØ-öø-ÿ' ]+$/",
                        'message' => 'Seu pseudônimo deve ter apenas letras com/sem acentos.'
                    ])
                ],
            ])
            ->add('nome_completo', TextType::class, [
                'label' => 'Nome completo',
                'required' => true,
                'attr' => [
                    'minlength' => "5",
                    'maxlength' => "80",
                    'pattern' => "^[A-Za-zÀ-ÖØ-öø-ÿ' ]+$",
                    'placeholder' => 'Nome completo',
                    'autocomplete' => "off"
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'O nome deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        'maxMessage' => 'O nome deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        'max' => 80,
                    ]),
                    new NotBlank([
                        'message' => 'Insira seu nome completo',
                    ]),
                    new Regex([
                        'pattern' => "/^[A-Za-zÀ-ÖØ-öø-ÿ' ]+$/",
                        'message' => 'Seu nome deve ter apenas letras com/sem acentos.'
                    ])
                ],
            ])
            ->add('celular', TextType::class, [
                'required' => true,
                'invalid_message' => 'Valor inválido.',
                'label' => 'Número de Celular',
                'attr' => [
                    'autocomplete' => 'off',
                    'minlength' => "11",
                    'maxlength' => "11",
                    'pattern' => '\d{11}',
                    'placeholder' => 'ex: 11900000000',
                    'inputmode' => 'numeric',
                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Insira seu número de celular.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'O número de telefone deve conter exatamente 11 dígitos.',
                    ]),
                ],
            ])
            ->add('nascimento', DateType::class, [
                'required' => true,
                'label' => 'Data de Nascimento',
                'data' => $maxidade,
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => $maxidade,
                        'message' => 'Você deve ser maior de idade.',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => $minidade,
                        'message' => 'Data de nascimento não pode ser inferior a 95 anos atrás.',
                    ]),
                ],
                'years' => range($minidade->format('Y'), $maxidade->format('Y')),
                'attr' => [
                    'class' => 'datte'
                ],
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
