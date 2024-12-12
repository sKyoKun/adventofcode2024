<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day12Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day12', name: 'day12')]
class Day12Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day12Services $day12services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day12_1', defaults: ["file"=>"day12"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $totalPrice = $this->day12services->calculateTotalPrice($grid);

        return new JsonResponse($totalPrice, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day12_2', defaults: ["file"=>"day12"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
