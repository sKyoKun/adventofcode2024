<?php

declare(strict_types=1);

namespace App\Utils;

class LeaderboardServices
{
    private const LEADERBOARDS = [
        'WA - Sonia' => 1112427,
        'WA - Guillaume' => 4234761,
        'Ladies Of Code' => 377752,
        'Aramis Auto' => 3299508
    ];
    private const AOC_API_URL = 'https://adventofcode.com/__YEAR__/leaderboard/private/view/__LEADERBOARDID__.json';

    public function __construct(private string $cookie)
    {
    }

    public function retrieveLeaderboards(int $year): array
    {
        $options = array(
            'http'=>array(
                'method'=>"GET",
                'header'=> "Cookie: session=".$this->cookie."\r\n"."User-Agent: github.com/sKyoKun\r\n"
            )
        );

        $context = stream_context_create($options);

        // Open the file using the HTTP headers set above
        $json = [];
         foreach (self::LEADERBOARDS as $leaderboardName => $leaderboardId) {
             $url = str_replace('__YEAR__', ''.$year, self::AOC_API_URL);
             $url = str_replace('__LEADERBOARDID__', ''.$leaderboardId, $url);
             $json[$leaderboardName] = file_get_contents($url, false, $context);
         }

        return $json;
    }

    public function parseJsonLeaderboard($json): array
    {
        $leaderboard = [];
        $decodedJson = json_decode($json);

        foreach($decodedJson->members as $member)
        {
            if (empty($member->name) || 0 === $member->stars) {
                continue;
            }
            $leaderboard[$member->name]['stars'] = $member->stars;
            $leaderboard[$member->name]['name'] = $member->name;
            $leaderboard[$member->name]['local_score'] = $member->local_score;
            $leaderboard[$member->name]['completion_day_level'] = [];
            foreach($member->completion_day_level as $key => $completionDay) {
                $leaderboard[$member->name]['completion_day_level'][$key] = $completionDay;
            }
        }

        // sort by stars then by name
        $this->orderLeaderboard($leaderboard);

        return $leaderboard;
    }

    public function orderLeaderboard(&$leaderboard): void
    {
        uasort($leaderboard, function($a, $b) {
            return $b['stars'] <=> $a['stars']
                ?: $a['name'] <=> $b['name'];
        });
    }
}
