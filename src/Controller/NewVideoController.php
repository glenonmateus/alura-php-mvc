<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use finfo;

class NewVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function process(): void
    {
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
        if ($url === false) {
            header("Location: /?success=0");
            return;
        }
        $titulo = filter_input(INPUT_POST, "titulo");
        if ($titulo === false) {
            header("Location: /?success=0");
            return;
        }
        $video = new Video($url, $titulo);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $finfo = new finfo(flags: FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file(
                filename: $_FILES['image']['tmp_name'],
            );
            if (str_starts_with(
                haystack: $mimeType,
                needle: "image/"
            )
            ) {
                $safeFileName = uniqid(prefix: "upload_") . "_" . pathinfo(
                    path: $_FILES['image']['name'],
                    flags: PATHINFO_BASENAME
                );
                move_uploaded_file(
                    from: $_FILES['image']['tmp_name'],
                    to: __DIR__ . "/../../public/img/uploads/" . $safeFileName
                );
                $video->setFilePath(filePath: $safeFileName);
            }
        };

        $success = $this->videoRepository->add($video);
        if ($success === false) {
            header("Location: /?success=0");
        } else {
            header("Location: /?success=1");
        }
    }
}
