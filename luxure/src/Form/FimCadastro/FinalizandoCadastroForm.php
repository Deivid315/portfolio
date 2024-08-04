<?php

// src/Form/ProductType.phpsd
namespace App\Form\FimCadastro;

use App\Validator\TamanhoArquivo;
use App\Validator\UserDuplicado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class FinalizandoCadastroForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $alturas = range(1, 2.50, 0.01);
        $choices_altura['Selecione'] = '';
        foreach ($alturas as $altura) {
            $choices_altura[$altura . ' m'] = $altura;
        }

        $pesos = range(40, 150);
        $choices_peso['Selecione'] = '';
        foreach ($pesos as $peso) {
            $choices_peso[$peso . ' kg'] = $peso;
        }

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
            ->add('capa', FileType::class, [
                'label' => 'Insira sua foto de perfil: ',
                'mapped' => false,
                'required' => true,
                'attr' => ['accept' => 'image/jpeg, image/png, image/heic'],
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeos válidos!',
                    ]),
                    new NotBlank(),
                    new TamanhoArquivo()
                ],
            ])
            ->add('biografia', TextareaType::class, [
                'label' => 'Insira sua biografia: ',
                'required' => true,
                'attr' => [
                    'rows' => '5',
                    'cols' => '40',
                    'placeholder' => 'Biografia',
                    'autocomplete' => "on",
                    'maxlength' => "500",
                    'minlength' => "10"
                ],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 500,
                        'minMessage' => 'A biografria deve ter no mínimo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                        'maxMessage' => 'A biografria deve ter no máximo {{ limit }} caracteres, atualmente tem apenas {{ value_length }} caracteres.',
                    ]),
                    new NotBlank(),
                ],
            ])
            ->add('valor', IntegerType::class, [
                'label' => 'Valor da acompanhante R$/h: ',
                'required' => true,
                'attr' => [
                    'autocomplete' => "off",
                    'min' => 1,
                    'max' => 9999,
                    'placeholder' => 'exemplo: 100'
                ],
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => 9999,
                        'message' => 'O valor deve ser igual ou menor que {{ compared_value }}'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'O valor deve ser igual ou maior que {{ compared_value }}'
                    ]),
                    new NotBlank(),
                ],
            ])
            ->add('altura', ChoiceType::class, [
                'choices' => $choices_altura,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('peso', ChoiceType::class, [
                'choices' => $choices_peso,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('local', ChoiceType::class, [
                'label' => 'Local de atendimento:',
                'required' => true,
                'choices' => [
                    'Meu local' => 'Meu local',
                    'Seu local' => 'Seu local',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'label_attr' => ['class' => 'choice-custom-local']
            ])
            ->add('etnia', ChoiceType::class, [
                'choices' => [
                    'Selecione' => '',
                    'Pardo' => 'Pardo',
                    'Branco' => 'Branco',
                    'Negro' => 'Negro',
                    'Indigena' => 'Indigena',
                    'Amarelo' => 'Amarelo'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('sexualidade', ChoiceType::class, [
                'choices' => [
                    'Selecione' => '',
                    'Hétero' => 'Hétero',
                    'Bissexual' => 'Bissexual',
                    'Gay' => 'Gay',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('cabelo', ChoiceType::class, [
                'choices' => [
                    'Selecione' => '',
                    'Preto' => 'Preto',
                    'Castanho' => 'Castanho',
                    'Louro' => 'Louro',
                    'Cinza/Branco' => 'Cinza/Branco',
                    'Ruivo' => 'Ruivo',
                    'Azul' => 'Azul'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('posicao', ChoiceType::class, [
                'label' => 'Posição Sexual:',
                'required' => true,
                'choices' => [
                    'Ativa' => 'Ativa',
                    'Passiva' => 'Passiva',
                    'Versátil' => 'Versátil',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'label_attr' => ['class' => 'choice-custom-posicao']
            ])
            ->add('fetiches', ChoiceType::class, [
                'choices' => [
                    'BDSM' => 'BDSM',
                    'Dominação' => 'Dominação',
                    'Submissão' => 'Submissão',
                    'Fetiche por pés' => 'Fetiche por pés',
                    'Spanking' => 'Spanking',
                    'Voyeurismo' => 'Voyeurismo',
                    'Exibicionismo' => 'Exibicionismo',
                    'Sadomasoquismo' => 'Sadomasoquismo',
                    'Podolatria' => 'Podolatria',
                    'Bondage' => 'Bondage',
                    'Roleplay' => 'Roleplay',
                    'Daddy kink' => 'Daddy kink',
                    'Mommy kink' => 'Mommy kink',
                    'Ageplay' => 'Ageplay',
                    'Chuva dourada' => 'Chuva dourada',
                    'Scat' => 'Scat',
                    'Cuckold' => 'Cuckold',
                    'Menage à trois' => 'Menage à trois',
                    'Orgias' => 'Orgias',
                    'Gangbang' => 'Gangbang',
                    'Bukkake' => 'Bukkake',
                    'Swing' => 'Swing',
                    'Fisting' => 'Fisting',
                    'Sexo anal' => 'Sexo anal',
                    'Sexo oral' => 'Sexo oral',
                    'Sexo vaginal' => 'Sexo vaginal',
                    'Brinquedos sexuais' => 'Brinquedos sexuais',
                    'Vídeos e fotos eróticas' => 'Vídeos e fotos eróticas',
                    'Striptease' => 'Striptease',
                    'Massagem erótica' => 'Massagem erótica',
                    'Experiência de namorada' => 'Experiência de namorada',
                    'Despedida de solteiro' => 'Despedida de solteiro',
                    'Despedida de solteira' => 'Despedida de solteira',
                    'Acompanhamento em eventos' => 'Acompanhamento em eventos',
                    'Viagens' => 'Viagens',
                    'Jantar romântico' => 'Jantar romântico',
                    'Fetiches com roupas' => 'Fetiches com roupas',
                    'Fetiches com lingerie' => 'Fetiches com lingerie',
                    'Fetiches com saltos altos' => 'Fetiches com saltos altos',
                    'Fetiches com uniformes' => 'Fetiches com uniformes',
                    'Fetiches com fantasias' => 'Fetiches com fantasias',
                    'Fetiches com acessórios' => 'Fetiches com acessórios',
                    'Fetiches com cosméticos' => 'Fetiches com cosméticos',
                    'Fetiches com óleos e lubrificantes' => 'Fetiches com óleos e lubrificantes',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => true,
            ])

            ->add('arq_1', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm, video/quicktime',
                    'class' => 'upload-field'
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeos válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_2', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeos válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_3', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeos válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_4', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ])
                ],
            ])

            ->add('arq_5', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_6', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_7', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_8', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_9', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('arq_10', FileType::class, [
                'label' => 'Insira uma foto ou vídeo: ',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'video/quicktime, image/jpeg, image/png, image/heic, video/mp4, video/webm'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                            'video/mp4',
                            'video/webm',
                            'video/quicktime'
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeo válidos!',
                    ]),
                    new TamanhoArquivo()
                ],
            ])

            ->add('validacao', FileType::class, [
                'label' => 'Foto para validação segurando uma placa: ',
                'mapped' => false,
                'required' => true,
                'attr' => ['accept' => 'image/jpeg, image/png, image/heic'],
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/heic',
                        ],
                        'mimeTypesMessage' => 'Envie uma foto ou vídeos válidos!',
                    ]),
                    new NotBlank(),
                    new TamanhoArquivo()
                ],
            ])

            ->add('save', SubmitType::class);
    }
}
