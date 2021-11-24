<?php

namespace App\Entity;

use App\Repository\PlayedGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayedGameRepository::class)
 */
class PlayedGame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scoreFinal;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="playedGames")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity=PlayerScore::class, mappedBy="playedGame", orphanRemoval=true)
     */
    private $playerScores;

    public function __construct()
    {
        $this->playerScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScoreFinal(): ?string
    {
        return $this->scoreFinal;
    }

    public function setScoreFinal(string $scoreFinal): self
    {
        $this->scoreFinal = $scoreFinal;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection|PlayerScore[]
     */
    public function getPlayerScores(): Collection
    {
        return $this->playerScores;
    }

    public function addPlayerScore(PlayerScore $playerScore): self
    {
        if (!$this->playerScores->contains($playerScore)) {
            $this->playerScores[] = $playerScore;
            $playerScore->setPlayedGame($this);
        }

        return $this;
    }

    public function removePlayerScore(PlayerScore $playerScore): self
    {
        if ($this->playerScores->removeElement($playerScore)) {
            // set the owning side to null (unless already changed)
            if ($playerScore->getPlayedGame() === $this) {
                $playerScore->setPlayedGame(null);
            }
        }

        return $this;
    }
}
