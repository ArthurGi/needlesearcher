<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 29.03.2020
 * Time: 23:05
 */

namespace src\Classes;

final class RemoteFile extends AbstractFile
{
    /** @var string  */
    private $url;

    /**
     * RemoteFile constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->checkFileExist();
    }


    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->getRemoteFileInfo(CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        $contentTypeInfo = $this->getRemoteFileInfo(CURLINFO_CONTENT_TYPE);
        $mimeType = trim(explode(';',$contentTypeInfo)[0]);

        return $mimeType ?? '';
    }

    public function checkFileExist(): void
    {
        if (200 !== $this->getRemoteFileInfo()) {
            var_dump("Local file not found by path: $this->url");die;
        }
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
       return $this->url;
    }

    /**
     * @param int $typeInfo
     * @return mixed
     */
    private function getRemoteFileInfo($typeInfo = CURLINFO_HTTP_CODE)
    {
        static $ch;
        if (!$ch) {
            try {
                $ch = curl_init($this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_NOBODY, 1);
                curl_exec($ch);
            } catch (\Exception $e) {
                //можно прокидывать в класс свой логгер ошибок
                var_dump('Remote file reading error: ',  $e->getMessage(), "\n");die;
            }
        }

        return curl_getinfo($ch, $typeInfo);
    }

}