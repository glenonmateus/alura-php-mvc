<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class VideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function process(): void
    {
        $videoList = $this->videoRepository->all();
        include_once __DIR__ . "/../../views/video-list.php";
    }
}
