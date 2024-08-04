<?php

namespace App\Form\Configuracoes;

use App\Validator\UserDuplicado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AlterarUsernameForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'label' => 'Insira seu nome de usuário',
            'required' => true,
            'attr' => [
                'placeholder' => 'User',
                'autocomplete' => "off",
                'maxlength' => "20",
                'minlength' => "4",
                'pattern' => "^(?=.*[a-z])[a-z0-9._\-]+$",
            ],
            'constraints' => [
                new Length([
                    'min' => 4,
                    'max' => 20,
                    'minMessage' => 'Seu nome de usuário deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                    'maxMessage' => 'Seu nome de usuário deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                ]),
                new NotBlank(),
                new Regex([
                    'pattern' => "/^(?=.*[a-z])[a-z0-9._-]+$/",
                    'message' => 'Seu nome de usuário deve ter ao menos um letra minúscula e/ou números e/ou um dos seguintes caracteres [_,.,-,]'
                ]),
                new UserDuplicado()
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
