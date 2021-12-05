<?php

namespace App\Entity;

use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * @ORM\Column(type="integer")
     *  @Assert\Range(
     *      min = 0,
     * )
     */
    private $kills;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     * )
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     * )
     */
    private $assists;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     * )
     */
    private $round;

    const ROUND_STYLE_ATTACK = 'attack';
    const ROUND_STYLE_DEFENCE = 'defence';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $roundStyle;

    public function __construct()
    {
        $this->kills = 0;
        $this->deaths = 0;
        $this->assists = 0;
    }

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

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getRoundStyle(): ?string
    {
        return $this->roundStyle;
    }

    public function setRoundStyle(?string $roundStyle): self
    {
        $this->roundStyle = $roundStyle;

        return $this;
    }

    public static function getRoundStyles()
    {
        return [
            self::ROUND_STYLE_ATTACK,
            self::ROUND_STYLE_DEFENCE,
        ];
    }
}
