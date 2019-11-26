<?php

namespace App\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class BtsImportGalleriesCommand extends Command
{
    protected static $defaultName = 'bts:import:galleries';
    /**
     * @var Client
     */
    private $client;

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Argument description', 20);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);
        $this->client = new Client([
            'base_uri' => 'http://www.watchthedeer.com',
            'timeout' => 2.0,
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $limit = (int)$input->getArgument('limit');

        $response = $this->client->get('/photos');
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $links = $crawler->filter('div#content a[href*=looping]');
        foreach ($links as $x => $link) {
            $io->note(str_replace(["\r", "\n", "\r\n"], '', preg_replace('/\s+/', ' ', $link->textContent)));
            $io->note($link->getAttribute('href'));
            if ($x === $limit) {
                break;
            }
        }

        return 0;
    }
}
