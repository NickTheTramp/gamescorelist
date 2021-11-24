<?php

namespace App\Entity;

use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerScoreRepository::class)
 */
class PlayerScore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PlayedGame::class, inversedBy="playerScores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playedGame;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayedGame(): ?PlayedGame
    {
        return $this->playedGame;
    }

    public function setPlayedGame(?PlayedGame $playedGame): self
    {
        $this->playedGame = $playedGame;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }
}
