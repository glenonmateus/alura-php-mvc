<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function add(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title) VALUES (:url, :title)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        return statement->execute();
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
        $sql = "UPDATE videos SET url = :url, title = :title WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);
        return statement->execute();
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $sql = "SELECT * FROM videos";
        $videoList = $this->pdo->query($sql)->fetchAll(mode: PDO::FETCH_ASSOC);
        return array_map(
            $this->_hydrate(...),
            $videoList
        );
    }

    public function find(int $id): Video
    {
        $sql = "SELECT FROM videos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $this->_hydrate($statement->fetch(mode: PDO::FETCH_ASSOC));
    }

    /**
     * @param array<int,mixed> $data
     */
    private function _hydrate(array $data): Video
    {
        $video = new Video(
            $data['url'],
            $data['title']
        );
        $video->setId((int) $data['id']);
        return $video;
    }
}
