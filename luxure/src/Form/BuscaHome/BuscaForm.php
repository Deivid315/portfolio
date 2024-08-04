<?php

declare(strict_types=1);

namespace App\Form\BuscaHome;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Regex;

class BuscaForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        
        // ->add('username', TextType::class, [
        //     'label' => 'Insira o user ou nome da acompanhante',
        //     'required' => false,
        //     'attr' => [
        //         'placeholder' => 'user ou nome',
        //         'autocomplete' => "off",
        //         'maxlength' => "80",
        //         'pattern' => "^[0-9._\-A-Za-zÀ-ÖØ-öø-ÿ' ]+$",
        //     ],
        //     'constraints' => [
        //         new Regex([
        //             'pattern' => '/^[0-9._\-A-Za-zÀ-ÖØ-öø-ÿ\' ]+$/',
        //             'message' => 'O valor inserido não corresponde ao formato esperado.',
        //         ]),
        //     ],
        // ])
        ->add('idade', IntegerType::class, [
            'label' => 'Idade',
            'required' => false,
            'attr' => [
                'placeholder' => 'Insira uma idade',
                'autocomplete' => "off",
                'pattern' => "^[0-9]+$",
            ]
        ])
        ->add('valor', ChoiceType::class, [
            'label' => 'Valor R$/h ',
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                'R$ 10,00 - R$ 100,00' => '10/100',
                'R$ 101,00 - R$ 300,00' => '101/300',
                'R$ 301,00 - R$ 500,00' => '301/500',
                'R$ 501,00 - R$ 700,00' => '501/700',
                'R$ 701,00 - R$ 1000,00' => '701/1000',
                'acima de R$ 1001,00' => '1001/9999'
            ]
        ])
        ->add('altura', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                '1,0 m a 1,5 m' => '1/1.59',
                '1,6 m a 1,7 m' => '1.60/1.79',
                '1,8 m a 1,9 m' => '1.80/1.99',
                'Acima de 2,0 m' => '2.00/2.59'
            ]
        ])
        ->add('peso', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                '40 kg a 60 kg' => '40/60',
                '61 kg a 80 kg' => '61/80',
                '81 kg a 90 kg' => '81/90',
                'Acima de 90 kg' => '90/150',
            ]
        ])
        ->add('local', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                'Meu local' => 'Meu local',
                'Seu local' => 'Seu local',
            ],
        ])
        ->add('etnia', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                'Pardo' => 'Pardo',
                'Branco' => 'Branco',
                'Negro' => 'Negro',
                'Indígena' => 'Indígena',
                'Amarelo' => 'Amarelo'
            ],
        ])
        ->add('sexualidade', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                'Hétero' => 'Hétero',
                'Bissexual' => 'Bissexual',
                'Gay' => 'Gay',
            ]
        ])
        ->add('cabelo', ChoiceType::class, [
            'required' => false,
            'choices' => [
                'Tanto faz' => '',
                'Preto' => 'Preto',
                'Castanho' => 'Castanho',
                'Louro' => 'Louro',
                'Cinza/Branco' => 'Cinza/Branco',
                'Ruivo' => 'Ruivo',
                'Azul' => 'Azul'
            ],
        ])
        ->add('posicao', ChoiceType::class, [
            'required' => false,
            'label' => 'Posiçãõ',
            'choices' => [
                'Tanto faz' => '',
                'Ativa' => 'Ativa',
                'Passiva' => 'Passiva',
                'Versátil' => 'Versátil',
            ],
        ])
        ->add('fetiches', ChoiceType::class, [
            'required' => false,
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
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('localizacao', HiddenType::class, [
            'attr' => ['class' => 'estado_cid']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);   
    }
}