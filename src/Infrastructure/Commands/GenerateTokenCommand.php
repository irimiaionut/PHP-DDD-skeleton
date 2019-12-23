<?php

namespace App\Infrastructure\Commands;

use TokenRepository;
use App\Domain\Token\Entities\ClientToken;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\CommandServices\GenerateTokenService;
use Doctrine\ORM\EntityManager;

class GenerateTokenCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'token:generateNew';

    protected $generateTokenService = null;
    protected $entityManager = null;


    public function __construct(GenerateTokenService $generateTokenService, EntityManager $entityManager)
    {
        $this->generateTokenService = $generateTokenService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('generate a new client token')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Will generate a new token for a client')
        ;

        $this
            // configure an argument
            ->addArgument('client', InputArgument::REQUIRED, 'Please add the client name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Token Generator',
            '========================',
            '',
        ]);

        $token = $this->generateTokenService->generateNewToken($input->getArgument('client'));

        $clientToken = new ClientToken($input->getArgument('client'), $token);
        $this->entityManager->persist($clientToken);
        $this->entityManager->flush();

        // retrieve the argument value using getArgument()
        $output->writeln('Client: '.$input->getArgument('client'));
        $output->writeln('Token: '.$token);

        return 0;
    }
}