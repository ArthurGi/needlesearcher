<?php

namespace src\Classes;


abstract class AbstractFile
{
    const DEFAULT_CONFIG_PATH = 'src/config.json';
    /** @var null|int */
    public $maxSize;

    /** @var null|string */
    public $allowedMimeType;


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
            $text          = fgets($handler);
            $result[$line] = $searcher->findOccurrence($needle, $text);
            $line++;
        }

        return $result;
    }

    public function setConfig(string $configPath = self::DEFAULT_CONFIG_PATH): void
    {
        $config                = json_decode(file_get_contents($configPath));
        $this->maxSize         = $config->maxSize ?? null;
        $this->allowedMimeType = $config->mimeType ?? null;
    }

    /**
     * @return bool
     */
    public function hasErrorMaxSize(): bool
    {
        return $this->maxSize && ($this->maxSize < $this->getFileSize());
    }

    /**
     * @return bool
     */
    public function hasErrorMimeType(): bool
    {
        return $this->allowedMimeType
               && ($this->allowedMimeType !== $this->getMimeType());
    }

    public function validate(): bool
    {
        return !$this->hasErrorMaxSize() && !$this->hasErrorMimeType();
    }

    abstract public function getFilePath(): string;

    abstract public function getFileSize(): int;

    abstract public function getMimeType(): string;

    abstract public function checkFileExist(): void;


}