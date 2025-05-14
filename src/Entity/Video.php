<?php

namespace Alura\Mvc\Entity;

use InvalidArgumentException;

class Video
{
    public readonly int $id;
    public readonly string $url;
    private ?string $_image_path = null;

    public function __construct(
        string $url,
        public readonly string $title
    ) {
        $this->setUrl($url);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    private function setUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setFilePath(string $filePath): void
    {
        $this->_image_path = $filePath;
    }

    public function getFilePath(): ?string
    {
        return $this->_image_path;
    }
}
