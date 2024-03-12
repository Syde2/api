<?php

namespace App\Entity;

use App\Repository\PollRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PollRepository::class)]
#[ApiResource()]

class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable :true )]
    private ?string $question = null;

    #[ORM\Column(nullable: true)]
    private ?int $yesCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $noCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getYesCount(): ?int
    {
        return $this->yesCount;
    }

    public function setYesCount(?int $yesCount): static
    {
        $this->yesCount = $yesCount;

        return $this;
    }

    public function getNoCount(): ?int
    {
        return $this->noCount;
    }

    public function setNoCount(?int $noCount): static
    {
        $this->noCount = $noCount;

        return $this;
    }
}
