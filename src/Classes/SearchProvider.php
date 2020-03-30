<?php

namespace src\Classes;

use src\Interfaces\SearchInterface;

class SearchProvider implements SearchInterface
{
    /** @var string */
    private $encoding = "UTF-8";

    public function findOccurrence(string $needle, string $text): array
    {
        $result              = [];
        $needleLengthOffsset = $this->strLen($needle) - 1;
        $positions           = $this->findOccurrencePositions($needle, $text);

        foreach ($positions as $key => $position) {
            $result[$key] = [
                'start' => $position,
                'end'   => $position + $needleLengthOffsset
            ];
        }

        return $result;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding(string $encoding): void
    {
        $this->encoding = $encoding;
    }

    /**
     * @param string $needle
     * @param string $line
     * @return array
     */
    private function findOccurrencePositions(string $needle, string $line): array
    {
        $position          = -1;
        $searchedPositions = [];

        while (
            false !== ($position = $this->strPos($line, $needle, $position + 1))
        ) {
            $searchedPositions[] = $position;
        }

        return $searchedPositions;
    }

    /**
     * @param string $line
     * @param string $world
     * @param int $position
     * @return false|int
     */
    private function strPos(string $line, string $world, int $position)
    {
        return mb_strpos($line, $world, $position, $this->encoding);
    }

    /**
     * @param string $str
     * @return int
     */
    private function strLen(string $str): int
    {
        return mb_strlen($str, $this->encoding);
    }
}
