<?php

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Repository\CurrencyRepository;

#[AsCommand(
    name: 'app:sync:currency',
    description: 'Update currency entity'
)]
class SyncCurrenciesCliCommand extends Command
{
    public function __construct(
        private CurrencyRepository $currencyRepository
    )
    {
        parent::__construct();
    }
}