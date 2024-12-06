<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day6Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day6', name: 'day6')]
class Day6Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day6Services $day6services,
        private CalendarServices $calendarservices
    ){}

    #[Route('/1/{file}', name: 'day6_1', defaults: ["file"=>"day6"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarservices->parseInputFromStringsToArray($lines);
        [$startX, $startY] = $this->day6services->findStartingPoint($grid);
        $visited = $grid;
        $this->day6services->walk($grid, $startX, $startY, $visited);
        $countVisited = $this->day6services->countVisitedPoints($visited);

        return new JsonResponse($countVisited, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day6_2', defaults: ["file"=>"day6"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
