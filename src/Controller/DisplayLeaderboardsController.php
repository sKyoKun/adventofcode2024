<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utils\LeaderboardServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DisplayLeaderboardsController extends AbstractController
{
    //private const LEADERBOARDS = [1112427, 4234761];
    private const LEADERBOARDS = [1112427];
    private const AOC_API_URL = 'https://adventofcode.com/2024/leaderboard/private/view/__LEADERBOARDID__.json';

    public function __construct(private LeaderboardServices $leaderboardServices)
    {
    }

    #[Route('/leaderboards/{year}',
        name: 'leaderboards',
        requirements: ['year' => '\d+'],
        defaults: ["year"=>"2024"],
        methods: ['GET']
    )]
    public function displayLeaderboard(Request $request, int $year): Response
    {
        $leaderboards = $this->leaderboardServices->retrieveLeaderboards($year);
        $leaderboardsData = [];
        foreach ($leaderboards as $leaderboardName => $leaderboard) {
            $leaderboardsData[$leaderboardName] = $this->leaderboardServices->parseJsonLeaderboard($leaderboard);
        }

        return $this->render('leaderboard.twig', [
            'year' => $year,
            'leaderboardData' => $leaderboardsData
        ]);
    }
}
