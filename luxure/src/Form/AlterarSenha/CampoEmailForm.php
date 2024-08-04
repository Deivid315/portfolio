<?php

declare(strict_types=1);

namespace App\Form\AlterarSenha;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CampoEmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                    'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'message' => 'O email possui caracteres inadequados, faltando ou em exceço!'
                ]),
            ],
            'invalid_message' => 'Esse valor não é permitido!',
            'label' => 'Email',
            'attr' => [
                'placeholder' => 'ex: email@gmail.com',
            ],

        ])
        ->add('envie', SubmitType::class);
    }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([]);
        }
    }

