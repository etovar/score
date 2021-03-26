<?php

namespace App\Command;

use App\Entity\Score;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CsvImportCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports a CSV file');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting to import the feed...');

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvENcoder()]);
        $data = $serializer->decode(file_get_contents('public/csv/test.csv'), 'csv', array(CsvEncoder::DELIMITER_KEY => ';'));
        foreach($data as $dataOne){
            $score = (new Score())
            ->setName($dataOne['Name'])
            ->setGender($dataOne['Gender'])
            ->setAge($dataOne['Age'])
            ->setRegion($dataOne['Region'])
            ->setScore($dataOne['Score']);

            $this->em->persist($score);
        }

        $this->em->flush();

        $io->success('Everything went well');
        return 1;
    }
}

?>
