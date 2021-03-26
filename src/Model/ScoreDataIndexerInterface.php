<?php 
namespace App\Model;

interface ScoreDataIndexerInterface
{
    public function getCountOfUserWithinScoreRange(
        int $rangeStart,
        int $rangeEnd
    ): int;

    public function getCountOfUsersByCondition(
        string $region,
        string $gender,
        bool $hasLegalAge,
        bool $hasPositiveScore
    ): int;
}
?>
