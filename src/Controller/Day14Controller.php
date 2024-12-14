<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day14Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day14', name: 'day14')]
class Day14Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day14Services $day14services
    ){}

    #[Route('/1/{file}', name: 'day14_1', defaults: ["file"=>"day14"])]
    public function part1(string $file): JsonResponse
    {
        if ('day14' === $file) {
            $width = 101;
            $height = 103;
        } else {
            $width = 11;
            $height = 7;
        }


        $lines = $this->inputReader->getInput($file.'.txt');
        $robotsPositionsAndVelocity = $this->day14services->getRobotsPositionAndVelocity($lines);

        foreach ($robotsPositionsAndVelocity as $id => $robot) {
            $this->day14services->calculateRobotPositionAfterIteration(
                $robotsPositionsAndVelocity,
                $id,
                100,
                $width,
                $height
            );
        }

        $safetyFactor = $this->day14services->calculateSafetyFactor($robotsPositionsAndVelocity, $width, $height);

        return new JsonResponse($safetyFactor, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day14_2', defaults: ["file"=>"day14"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
