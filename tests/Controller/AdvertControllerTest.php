<?php

namespace App\Test\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdvertControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AdvertRepository $repository;
    private string $path = '/advert/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Advert::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Advert index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'advert[title]' => 'Testing',
            'advert[description]' => 'Testing',
            'advert[price]' => 'Testing',
            'advert[postalCode]' => 'Testing',
            'advert[city]' => 'Testing',
            'advert[isEnabled]' => 'Testing',
        ]);

        self::assertResponseRedirects('/advert/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Advert();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPostalCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setIsEnabled('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Advert');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Advert();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPostalCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setIsEnabled('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'advert[title]' => 'Something New',
            'advert[description]' => 'Something New',
            'advert[price]' => 'Something New',
            'advert[postalCode]' => 'Something New',
            'advert[city]' => 'Something New',
            'advert[isEnabled]' => 'Something New',
        ]);

        self::assertResponseRedirects('/advert/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getPostalCode());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getIsEnabled());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Advert();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPostalCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setIsEnabled('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/advert/');
    }
}
