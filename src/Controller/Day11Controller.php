<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day11Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day11', name: 'day11')]
class Day11Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day11Services $day11services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day11_1', defaults: ["file"=>"day11"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $stones = $this->day11services->getStones($lines[0]);
        $stonesAfterBlink = $this->day11services->getStonesAfterblinks($stones);

        return new JsonResponse(count($stonesAfterBlink), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day11_2', defaults: ["file"=>"day11"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
