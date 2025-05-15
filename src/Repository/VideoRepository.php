<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":url", $video->url);
        $statement->bindValue(":title", $video->title);
        $statement->bindValue(":image_path", $video->getFilePath());
        return $statement->execute();
    }

    public function remove(int $id): bool
    {
        $sql = "DELETE FROM videos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function update(Video $video): bool
    {
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ", image_path = :image_path";
        };
        $sql = "UPDATE videos SET url = :url, title = :title $updateImageSql WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":url", $video->url);
        $statement->bindValue(":title", $video->title);
        if ($video->getFilePath() !== null) {
            $statement->bindValue(":image_path", $video->getFilePath());
        };
        $statement->bindValue(":id", $video->id, PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $sql = "SELECT * FROM videos";
        $videoList = $this->pdo->query($sql)->fetchAll();
        return array_map($this->_hydrate(...), $videoList);
    }

    public function find(int $id): Video
    {
        $sql = "SELECT * FROM videos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([":id" => $id]);
        return $this->_hydrate($statement->fetch());
    }

    /**
     * @param array<Video> $data
     */
    private function _hydrate(array $data): Video
    {
        $video = new Video($data["url"], $data["title"]);
        $video->setId((int) $data["id"]);
        if ($data['image_path'] !== null) {
            $video->setFilePath($data['image_path']);
        };
        return $video;
    }
}
