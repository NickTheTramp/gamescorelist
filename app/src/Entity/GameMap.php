<?php

namespace App\Entity;

use App\Repository\GameMapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameMapRepository::class)
 */
class GameMap
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="gameMaps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity=PlayedGame::class, mappedBy="gameMap")
     */
    private $playedGames;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->playedGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $playedGame->setGameMap($this);
        }

        return $this;
    }

    public function removePlayedGame(PlayedGame $playedGame): self
    {
        if ($this->playedGames->removeElement($playedGame)) {
            // set the owning side to null (unless already changed)
            if ($playedGame->getGameMap() === $this) {
                $playedGame->setGameMap(null);
            }
        }

        return $this;
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
}
