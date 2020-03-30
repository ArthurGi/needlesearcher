<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 29.03.2020
 * Time: 14:42
 */
namespace src\Classes;

final class LocalFile extends AbstractFile
{
    /** @var string  */
    private $path;

    /**
     * LocalFile constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->path = $filePath;
        $this->checkFileExist();
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return filesize($this->path);
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return mime_content_type($this->path);
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->path;
    }


    public function checkFileExist(): void
    {
        if (!file_exists($this->path)) {
            var_dump("Local file not found by path: $this->path");die;
        }
    }

}