<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day8Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day8', name: 'day8')]
class Day8Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day8Services $day8services,
        private CalendarServices $calendarservices
    ){}

    #[Route('/1/{file}', name: 'day8_1', defaults: ["file"=>"day8"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarservices->parseInputFromStringsToArray($lines);
        $locations = $this->day8services->getCountLocations($grid);

        return new JsonResponse($locations, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day8_2', defaults: ["file"=>"day8"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarservices->parseInputFromStringsToArray($lines);
        $locations = $this->day8services->getCountLocations($grid, false);

        return new JsonResponse($locations, Response::HTTP_OK);
    }
}
