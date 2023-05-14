<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(length: 2)]
  private ?string $code = null;

  #[ORM\Column]
  private ?int $taxIdLength = null;

  #[ORM\Column]
  private ?float $taxPercent = null;

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

  public function getCode(): ?string
  {
    return $this->code;
  }

  public function setCode(string $code): self
  {
    $this->code = $code;

    return $this;
  }

  public function getTaxIdLength(): ?int
  {
    return $this->taxIdLength;
  }

  public function setTaxIdLength(int $taxIdLength): self
  {
    $this->taxIdLength = $taxIdLength;

    return $this;
  }

  public function getTaxPercent(): ?float
  {
    return $this->taxPercent;
  }

  public function setTaxPercent(float $taxPercent): self
  {
    $this->taxPercent = $taxPercent;

    return $this;
  }
}
