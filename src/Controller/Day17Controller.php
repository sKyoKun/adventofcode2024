<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day17Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day17', name: 'day17')]
class Day17Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day17Services $day17services
    ){}

    #[Route('/1/{file}', name: 'day17_1', defaults: ["file"=>"day17"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $this->day17services->parseInstructions($lines);
        $output = $this->day17services->runProgram();

        return new JsonResponse($output, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day17_2', defaults: ["file"=>"day17"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
