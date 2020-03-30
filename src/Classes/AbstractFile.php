<?php

namespace src\Classes;


abstract class AbstractFile
{
    /**
     * @param SearchProvider $searcher
     * @param string $needle
     * @return array
     */
    public function readSearch(SearchProvider $searcher, string $needle): array
    {
        $line   = 1;
        $result = [];
        $path   = $this->getFilePath();

        if (!($handler = fopen($path, "rb"))) {
            var_dump("Cannot open the file");
            die;
        }

        while (!feof($handler)) {
            $text                   = fgets($handler);
            $result["line:" . $line] = $searcher->findOccurrence($needle, $text);
            $line++;
        }

        return $result;
    }

    abstract public function getFilePath(): string;

    abstract public function getFileSize(): int;

    abstract public function getMimeType(): string;

    abstract public function checkFileExist(): void;
}