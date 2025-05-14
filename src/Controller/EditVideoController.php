<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class EditVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function process(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header("Location: /?sucesso=0");
            return;
        }
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
        if ($url === false) {
            header("Location: /?sucesso=0");
            return;
        }
        $titulo = filter_input(INPUT_POST, "titulo");
        if ($titulo === false) {
            header("Location: /?sucesso=0");
            return;
        }
        $video = new Video(url: $url, title: $titulo);
        $video->setId($id);
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file(
                from: $_FILES['image']['tmp_name'],
                to: __DIR__ . "/../../public/img/uploads/" . $_FILES['image']['name']
            );
            $video->setFilePath(filePath: $_FILES['image']['name']);
        };
        $sucesso = $this->videoRepository->update($video);
        if ($sucesso === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }
    }
}
