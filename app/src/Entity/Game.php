<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=PlayedGame::class, mappedBy="game")
     */
    private $playedGames;

    public function __construct()
    {
        $this->playedGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|PlayedGame[]
     */
    public function getPlayedGames(): Collection
    {
        return $this->playedGames;
    }

    public function addPlayedGame(PlayedGame $playedGame): self
    {
        if (!$this->playedGames->contains($playedGame)) {
            $this->playedGames[] = $playedGame;
            $playedGame->setGame($this);
        }

        return $this;
    }

    public function removePlayedGame(PlayedGame $playedGame): self
    {
        if ($this->playedGames->removeElement($playedGame)) {
            // set the owning side to null (unless already changed)
            if ($playedGame->getGame() === $this) {
                $playedGame->setGame(null);
            }
        }

        return $this;
    }
}
