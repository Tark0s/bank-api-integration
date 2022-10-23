<?php

namespace App\Cli;

use App\Entity\Currency;
use App\Service\NbpService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Repository\CurrencyRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:sync:currency',
    description: 'Update currency entity',
    aliases: ['app:sync:currency'],
    hidden: false
)]
class SyncCurrenciesCliCommand extends Command
{
    public function __construct(
        private CurrencyRepository $currencyRepository,
        private NbpService $nbp,
        private EntityManagerInterface $entity
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oldCurrencies = $this->currencyRepository->findAll();
        $newCurrencies = $this->nbp->getCurrencies()->toArray();


        foreach($newCurrencies[0]['rates'] as $newCurrency){
           if($this->isNew($newCurrency, $oldCurrencies)){

               $currency = new Currency(
                 $newCurrency['currency'],
                 $newCurrency['code'],
                 $newCurrency['mid'],
               );

               $this->entity->persist($currency);
           }else if ($this->isNewRate($newCurrency, $oldCurrencies)){
               $this->updateCurrency($newCurrency);
           }
        }

        $this->entity->flush();

        return self::SUCCESS;
    }

    private function isNew($newCurrency, $oldCurrencies): bool
    {
       $newCurrencyCode = $newCurrency['code'];

       /** @var Currency $oldCurrency */
        foreach ($oldCurrencies as $oldCurrency){
           if ($newCurrencyCode === $oldCurrency->getCurrencyCode()){
               return false;
           }
       }

        return true;
    }

    private function isNewRate(mixed $newCurrency, array $oldCurrencies): bool
    {
        $newCurrencyCode = $newCurrency['code'];
        $newCurrencyExchangeRate = $newCurrency['mid'];

        $oldCurrency = $this->currencyRepository->findOneBy(['currencyCode' => $newCurrencyCode]);

        if ($oldCurrency->getExchangeRate() === $newCurrencyExchangeRate){
            return false;
        }

        return true;
    }

    private function updateCurrency(mixed $newCurrency)
    {
        $newCurrencyCode = $newCurrency['code'];
        $newCurrencyExchangeRate = $newCurrency['mid'];

        $oldCurrency = $this->currencyRepository->findOneBy(['currencyCode' => $newCurrencyCode]);

        $oldCurrency->setExchangeRate($newCurrencyExchangeRate);
        $this->entity->persist($oldCurrency);
    }
}