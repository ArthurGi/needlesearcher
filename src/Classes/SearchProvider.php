<?php

namespace src\Classes;

use src\Interfaces\SearchInterface;

class SearchProvider implements SearchInterface
{
    /** @var string  */
    private $encoding = "UTF-8";

    public function findOccurrence(string $needle, string $text): array
    {
        return $this->findOccurrencePositions($needle, $text);
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

}
