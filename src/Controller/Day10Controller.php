<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day10Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day10', name: 'day10')]
class Day10Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day10Services $day10services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day10_1', defaults: ["file"=>"day10"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToIntArray($lines);
        $this->day10services->searchTrailHeads($grid);
        $score = $this->day10services->calculateScore($grid);

        return new JsonResponse($score, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day10_2', defaults: ["file"=>"day10"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToIntArray($lines);
        $this->day10services->searchTrailHeads($grid);
        $rating = $this->day10services->calculateRating($grid);

        return new JsonResponse($rating, Response::HTTP_OK);
    }
}
