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
    private $searcher;


    public function __construct(string $filePath, bool $isRemote, SearchInterface $searcher = null)
    {
        $this->file    = $this->getFileObject($filePath, $isRemote);
        $this->file->setConfig();
        if (!$this->file->validate()) {
            var_dump('Error file size|mime-type');die;
        }

        $this->searcher = $this->getSearcher($searcher);
    }

    /**
     * @param string $needle
     * @return array
     */
    public function search(string $needle): array
    {
        return $this->file->readSearch($this->searcher ,$needle) ?? [];
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