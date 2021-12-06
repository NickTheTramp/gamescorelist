<?php

namespace App\Form;

use App\Entity\PlayedGame;
use App\Repository\GameRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayedGameType extends AbstractType
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var PlayedGame $playedGame */
        $playedGame = $builder->getData();

        $games = $this->gameRepository->findBy(['selectedGroup' => $playedGame->getSelectedGroup()]);

        $builder
            ->add('date')
            ->add('scoreFinal', ChoiceType::class, [
                'choices' => PlayedGame::getScoreFinalTypes(),
                'choice_label' => function ($value) {
                    return $value;
                },
            ])
            ->add('game', ChoiceType::class, [
                'choices' => $games,
                'choice_label' => 'name',
            ]);

        if ($playedGame->getGame() !== null) {
            $gameMaps = $playedGame->getGame()->getGameMaps();

            if (count($gameMaps) > 0) {
                $builder
                    ->add('gameMap', ChoiceType::class, [
                        'choices' => $gameMaps,
                        'choice_label' => 'name',
                    ]);
            }
        }

        $builder
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayedGame::class,
        ]);
    }
}
