<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day9Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day9', name: 'day9')]
class Day9Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day9Services $day9services
    ){}

    #[Route('/1/{file}', name: 'day9_1', defaults: ["file"=>"day9"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $checksum = $this->day9services->getChecksum($lines[0]);

        return new JsonResponse($checksum, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day9_2', defaults: ["file"=>"day9"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $checksum = $this->day9services->getChecksum($lines[0], true);

        return new JsonResponse($checksum, Response::HTTP_OK);
    }
}
