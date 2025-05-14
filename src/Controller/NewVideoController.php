<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function process(): void
    {
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
        $video = new Video($url, $titulo);
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file(
                from: $_FILES['image']['tmp_name'],
                to: __DIR__ . "/../../public/img/uploads/" . $_FILES['image']['name']
            );
            $video->setFilePath(filePath: $_FILES['image']['name']);
        };
        $success = $this->videoRepository->add($video);
        if ($success === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }
    }
}
