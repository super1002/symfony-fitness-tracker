<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RunRepository")
 */
class Run
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateStarted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnded;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JoggingRoute", inversedBy="runs")
     */
    private $route;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStarted(): ?\DateTimeInterface
    {
        return $this->dateStarted;
    }

    public function setDateStarted(?\DateTimeInterface $dateStarted): self
    {
        $this->dateStarted = $dateStarted;

        return $this;
    }

    public function getDateEnded(): ?\DateTimeInterface
    {
        return $this->dateEnded;
    }

    public function setDateEnded(?\DateTimeInterface $dateEnded): self
    {
        $this->dateEnded = $dateEnded;

        return $this;
    }

    public function getRoute(): ?JoggingRoute
    {
        return $this->route;
    }

    public function setRoute(?JoggingRoute $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function calculateDuration()
    {
        return $this->getDateEnded()->diff($this->getDateStarted());
    }
}
