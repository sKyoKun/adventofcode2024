<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day19Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day19', name: 'day19')]
class Day19Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day19Services $day19services,
        private CalendarServices $calendarservices
    ){}

    #[Route('/1/{file}', name: 'day19_1', defaults: ["file"=>"day19"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $towels = array_slice($lines, 0, array_search('', $lines), true);
        $designs = array_slice($lines, array_search('', $lines)+1);
        $towels = explode(', ', $towels[0]);

        $nbValidDesigns = $this->day19services->countValidDesigns($towels, $designs);

        return new JsonResponse($nbValidDesigns, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day19_2', defaults: ["file"=>"day19"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $towels = array_slice($lines, 0, array_search('', $lines), true);
        $designs = array_slice($lines, array_search('', $lines)+1);
        $towels = explode(', ', $towels[0]);

        $nbTotalDesigns = $this->day19services->countTotalPossibleDesigns($towels, $designs);

        return new JsonResponse($nbTotalDesigns, Response::HTTP_OK);
    }
}
