<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day7Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day7', name: 'day7')]
class Day7Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day7Services $day7services
    ){}

    #[Route('/1/{file}', name: 'day7_1', defaults: ["file"=>"day7"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $parsedInput = $this->day7services->getResultsAndOperands($lines);
        $calibrationResult = $this->day7services->getTotalCalibrationResult($parsedInput);


        return new JsonResponse($calibrationResult, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day7_2', defaults: ["file"=>"day7"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $parsedInput = $this->day7services->getResultsAndOperands($lines);
        $calibrationResult = $this->day7services->getTotalCalibrationResult($parsedInput, true);

        return new JsonResponse($calibrationResult, Response::HTTP_OK);
    }
}
