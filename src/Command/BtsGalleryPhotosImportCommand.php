<?php

namespace App\Command;

use App\Entity\GalleryPhoto;
use App\Repository\GalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class BtsGalleryPhotosImportCommand extends Command
{
    private const URL = 'http://www.watchthedeer.com';

    protected static $defaultName = 'bts:gallery:photos:import';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var GalleryRepository
     */
    private $galleryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        GalleryRepository $galleryRepository
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->galleryRepository = $galleryRepository;
    }

    protected function configure(): void
    {
        $this->setDescription('Imports photos links to galleries');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);
        $this->client = new Client([
            'base_uri' => static::URL,
            'timeout' => 10.0,
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyleInputOutput = new SymfonyStyle($input, $output);

        $galleries = $this->galleryRepository->findAll();

        foreach ($galleries as $gallery) {
            $symfonyStyleInputOutput->note('Trying to import photos to `'.$gallery->getName().'` gallery');
            $response = $this->client->get(str_replace('http://www.watchthedeer.com', '', $gallery->getSourceUri()).'viewer.aspx');
            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);
            $script = $crawler->filter('head script[language=javascript]');
            $photosListString = $script->first()->html();
            preg_match_all('/([-A-z0-9]*\.jpg)/i', $photosListString, $images);
            if (!empty($photosUris = $images[0])) {
                foreach ($photosUris as $photoUri) {
                    $galleryPhoto = new GalleryPhoto();
                    $galleryPhoto->setGallery($gallery);
                    $galleryPhoto->setPhotoUri($photoUri);
                    $galleryPhoto->setPhotoDate((new \DateTime()));

                    $this->entityManager->persist($galleryPhoto);
                }
            }
        }

        $this->entityManager->flush();

        return 0;
    }
}
