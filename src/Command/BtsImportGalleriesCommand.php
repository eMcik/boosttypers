<?php

namespace App\Command;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class BtsImportGalleriesCommand extends Command
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

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports photo galleries from whatchthedeer.com')
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

        $links = $crawler->filter('div#content a[href*=viewer]');
        foreach ($links as $x => $link) {
            if ($x === $limit) {
                break;
            }
            $galleryName = str_replace(["\r", "\n", "\r\n"], '', preg_replace('/\s+/', ' ', $link->textContent));
            $io->note($galleryName);
            $galleryUri = 'http://www.watchthedeer.com/'. str_replace(['../', 'viewer.aspx'], '', $link->getAttribute('href'));
            $io->note($galleryUri);

            $gallery = new Gallery();
            $gallery->setName($galleryName);
            $gallery->setSourceUri($galleryUri);

            $this->entityManager->persist($gallery);
        }

        $this->entityManager->flush();

        return 0;
    }
}
