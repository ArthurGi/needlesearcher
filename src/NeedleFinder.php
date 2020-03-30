<?php

namespace src;

use src\Classes\AbstractFile;
use src\Interfaces\SearchInterface;
use src\Classes\LocalFile;
use src\Classes\RemoteFile;
use src\Classes\SearchProvider;

class NeedleFinder
{
    /** @var AbstractFile  */
    private $file;

    /** @var SearchInterface  */
    private $seacher;

    public function __construct(string $filePath, bool $isRemote, $searcher = null)
    {
        $this->file    = $this->getFileObject($filePath, $isRemote);
        $this->seacher = $this->getSearcher($searcher);
    }

    public function search(string $needle)
    {
        return $this->file->readSearch($this->seacher ,$needle);
    }

    /**
     * @param string $filePath
     * @param bool $isRemote
     * @return AbstractFile
     */
    private function getFileObject(string $filePath, bool $isRemote): AbstractFile
    {
        if ($isRemote) {
            return new RemoteFile($filePath);
        }

        return new LocalFile($filePath);
    }

    /**
     * @param null $searcher
     * @return SearchProvider
     */
    private function getSearcher($searcher = null): SearchInterface
    {
        if (!$searcher) {
            return new SearchProvider();
        }

        return new $searcher;
    }
}