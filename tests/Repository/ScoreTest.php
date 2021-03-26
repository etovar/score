<?php 
namespace App\Tests\Repository;

use App\Entity\Score;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ScoreTest extends KernelTestCase
{
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testScoreRange()
    {
        $result = $this->entityManager
        ->getRepository('App:Score')
        ->getCountOfUserWithinScoreRange(20,50)
        ;

        $this->assertEquals(3, $result);
    }

    public function testConditions()
    {
        $result = $this->entityManager
        ->getRepository('App:Score')
        ->getCountOfUsersByCondition('NY', 'w', false, true)
        ;

        $this->assertEquals(1, $result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
?>
