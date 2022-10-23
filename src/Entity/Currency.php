<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $currencyId;

    #[ORM\Column(length: 40)]
    private string $name;

    #[ORM\Column(length: 10)]
    private string $currencyCode;

    #[ORM\Column]
    private float $exchangeRate;

    public function __construct(string $name, string $currencyCode, float $exchangeRate)
    {
        $this->currencyId = null;
        $this->name = $name;
        $this->currencyCode = $currencyCode;
        $this->exchangeRate = $exchangeRate;
    }


    public function getCurrencyId(): ?int
    {
        return $this->currencyId;
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

    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }

}
