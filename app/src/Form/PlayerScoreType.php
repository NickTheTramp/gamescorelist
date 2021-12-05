<?php

namespace App\Form;

use App\Entity\PlayerScore;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerScoreType extends AbstractType
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var PlayerScore $playerScore */
        $playerScore = $builder->getData();

        $players = $this->userRepository->findBy(['selectedGroup' => $playerScore->getPlayedGame()->getGame()->getSelectedGroup()]);

        $builder
            ->add('kills')
            ->add('deaths')
            ->add('assists')
            ->add('player', ChoiceType::class, [
                'choices' => $players,
                'choice_label' => 'username',
            ]);

        if ($playerScore->getPlayedGame()->getGame()->getHasRounds()) {
            $builder
                ->add('round')
                ->add('roundStyle', ChoiceType::class, [
                    'choices' => PlayerScore::getRoundStyles(),
                    'choice_label' => function ($value) {
                        return $value;
                    },
                ]);
        }

        $builder
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayerScore::class,
        ]);
    }
}
