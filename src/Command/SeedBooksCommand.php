<?php

namespace App\Command;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:seed-books', description: 'Seed sample books into the database')]
final class SeedBooksCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repo = $this->em->getRepository(Book::class);

        $samples = [
            ['titre' => '1984', 'auteur' => 'Orwell', 'isbn' => '978014', 'disponible' => 'yes'],
            ['titre' => 'Dune', 'auteur' => 'Herbert', 'isbn' => '978044', 'disponible' => 'yes'],
            ['titre' => 'It', 'auteur' => 'King', 'isbn' => '978030', 'disponible' => 'no'],
            ['titre' => 'Sapiens', 'auteur' => 'Harari', 'isbn' => '978009', 'disponible' => 'yes'],
            ['titre' => 'Kafka', 'auteur' => 'Franz', 'isbn' => '978014', 'disponible' => 'yes'],
        ];

        $countInserted = 0;

        foreach ($samples as $s) {
            $existing = $repo->findOneBy(['titre' => $s['titre'], 'auteur' => $s['auteur']]);
            if ($existing) {
                continue;
            }

            $book = new Book();
            $book->setTitre($s['titre']);
            $book->setAuteur($s['auteur']);
            $book->setIsbn($s['isbn']);
            $book->setDisponible($s['disponible']);

            $this->em->persist($book);
            $countInserted++;
        }

        if ($countInserted > 0) {
            $this->em->flush();
        }

        $output->writeln(sprintf('Inserted %d new book(s)', $countInserted));

        return Command::SUCCESS;
    }
}
