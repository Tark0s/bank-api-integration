<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private Uuid $id;

    #[ORM\Column(length: 40)]
    private string $name;

    #[ORM\Column(length: 10)]
    private string $currencyCode;

    #[ORM\Column]
    private int $exchangeRate;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getExchangeRate(): int
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(int $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }

}
