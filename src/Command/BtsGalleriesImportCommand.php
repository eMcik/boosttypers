<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\WatchTheDeerURLEnum;
use App\Transformer\LinkToGallery;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class BtsGalleriesImportCommand extends Command
{
    protected static $defaultName = 'bts:gallery:import';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LinkToGallery
     */
    private $linkToGallery;

    public function __construct(EntityManagerInterface $entityManager, LinkToGallery $linkToGallery)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->linkToGallery = $linkToGallery;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Imports photo galleries from whatchthedeer.com')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Argument description', 20);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);
        $this->client = new Client([
            'base_uri' => WatchTheDeerURLEnum::URL,
            'timeout' => 5.0,
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyleInputOutput = new SymfonyStyle($input, $output);
        $limit = (int)$input->getArgument('limit');

        $response = $this->client->get('/photos');
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $links = $crawler->filter('div#content a[href*=viewer]');
        foreach ($links as $x => $link) {
            if ($x === $limit) {
                break;
            }

            $gallery = $this->linkToGallery->getGallery($link);

            $this->entityManager->persist($gallery);
        }

        $this->entityManager->flush();

        return 0;
    }
}
