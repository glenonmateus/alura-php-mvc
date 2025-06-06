<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class DeleteVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function process(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header("Location: /?success=0");
            return;
        }
        $success = $this->videoRepository->remove($id);
        if ($success === false) {
            header("Location: /?success=0");
        } else {
            header("Location: /?success=1");
        }
    }
}
