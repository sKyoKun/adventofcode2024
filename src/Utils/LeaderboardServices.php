<?php

declare(strict_types=1);

namespace App\Utils;

class LeaderboardServices
{
    //private const LEADERBOARDS = [1112427, 4234761];
    private const LEADERBOARDS = ['WA - Sonia' => 1112427, 'WA - Guillaume' => 4234761];
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
        /* foreach (self::LEADERBOARDS as $leaderboardName => $leaderboardId) {
             $url = str_replace('__YEAR__', ''.$year, self::AOC_API_URL);
             $url = str_replace('__LEADERBOARDID__', ''.$leaderboardId, $url);
             $json[$leaderboardName] = file_get_contents($url, false, $context);
         }*/

        $testJson['WA - Sonia'] = '{"event":"2024","members":{"1112427":{"id":1112427,"completion_day_level":{"1":{"2":{"star_index":1794,"get_star_ts":1733039621},"1":{"get_star_ts":1733038774,"star_index":0}},"2":{"1":{"star_index":273857,"get_star_ts":1733133275},"2":{"get_star_ts":1733155584,"star_index":362677}},"3":{"2":{"get_star_ts":1733214972,"star_index":564506},"1":{"star_index":549659,"get_star_ts":1733211871}}},"stars":6,"name":"sKyoKun","last_star_ts":1733214972,"local_score":56,"global_score":0},"2378773":{"last_star_ts":1733220209,"local_score":40,"global_score":0,"completion_day_level":{"1":{"2":{"star_index":44610,"get_star_ts":1733054142},"1":{"get_star_ts":1733051957,"star_index":37922}},"2":{"2":{"get_star_ts":1733158806,"star_index":376261},"1":{"get_star_ts":1733156419,"star_index":366139}},"3":{"1":{"star_index":588607,"get_star_ts":1733220209}}},"id":2378773,"stars":5,"name":"Redhewlett"},"4269677":{"completion_day_level":{"1":{"1":{"get_star_ts":1733059631,"star_index":60526},"2":{"star_index":61762,"get_star_ts":1733060051}},"2":{"1":{"get_star_ts":1733117002,"star_index":201068},"2":{"star_index":229786,"get_star_ts":1733123267}},"3":{"1":{"get_star_ts":1733210615,"star_index":543947},"2":{"get_star_ts":1733211230,"star_index":546681}}},"id":4269677,"stars":6,"name":"Maxime Herve","last_star_ts":1733211230,"local_score":57,"global_score":0},"3636215":{"stars":0,"id":3636215,"completion_day_level":{},"name":"Alexandre Boitelet","last_star_ts":0,"local_score":0,"global_score":0},"3314632":{"id":3314632,"completion_day_level":{},"stars":0,"name":"Max RV","last_star_ts":0,"local_score":0,"global_score":0},"2789606":{"local_score":0,"global_score":0,"last_star_ts":0,"name":"alexandrebrba","completion_day_level":{},"id":2789606,"stars":0},"1133872":{"name":"Motchouk","stars":0,"completion_day_level":{},"id":1133872,"global_score":0,"local_score":0,"last_star_ts":0},"2533333":{"last_star_ts":1733208614,"global_score":0,"local_score":63,"completion_day_level":{"2":{"2":{"star_index":226846,"get_star_ts":1733122480},"1":{"star_index":221902,"get_star_ts":1733121171}},"3":{"2":{"star_index":535269,"get_star_ts":1733208614},"1":{"get_star_ts":1733207906,"star_index":532250}},"1":{"1":{"get_star_ts":1733047390,"star_index":23365},"2":{"star_index":24421,"get_star_ts":1733047721}}},"id":2533333,"stars":6,"name":"Virus936"},"3686281":{"name":"@CedB99","stars":0,"completion_day_level":{},"id":3686281,"local_score":0,"global_score":0,"last_star_ts":0},"1709765":{"stars":0,"completion_day_level":{},"id":1709765,"name":"Maxime Médal","last_star_ts":0,"global_score":0,"local_score":0},"3261721":{"completion_day_level":{"2":{"2":{"star_index":292567,"get_star_ts":1733137740},"1":{"get_star_ts":1733127757,"star_index":248254}},"1":{"2":{"get_star_ts":1733087889,"star_index":146354},"1":{"get_star_ts":1733087561,"star_index":145427}}},"id":3261721,"stars":4,"name":"Coco","last_star_ts":1733137740,"global_score":0,"local_score":32}},"owner_id":1112427}';
        $testJson['WA - Guillaume'] = '{"members":{"4269677":{"global_score":0,"completion_day_level":{"1":{"2":{"get_star_ts":1733060051,"star_index":61762},"1":{"get_star_ts":1733059631,"star_index":60526}},"3":{"2":{"get_star_ts":1733211230,"star_index":546681},"1":{"get_star_ts":1733210615,"star_index":543947}},"2":{"2":{"star_index":229786,"get_star_ts":1733123267},"1":{"star_index":201068,"get_star_ts":1733117002}}},"name":"Maxime Herve","last_star_ts":1733211230,"id":4269677,"stars":6,"local_score":51},"4094873":{"id":4094873,"local_score":0,"stars":0,"global_score":0,"completion_day_level":{},"name":"Charles Giry Laterrière","last_star_ts":0},"4234761":{"last_star_ts":0,"completion_day_level":{},"global_score":0,"name":"Guillaume Lerigoleur","stars":0,"local_score":0,"id":4234761},"4108850":{"last_star_ts":1733232992,"global_score":0,"completion_day_level":{"3":{"2":{"get_star_ts":1733232992,"star_index":634740},"1":{"get_star_ts":1733224935,"star_index":606742}},"2":{"1":{"get_star_ts":1733136100,"star_index":285971},"2":{"star_index":293728,"get_star_ts":1733138042}},"1":{"2":{"star_index":53744,"get_star_ts":1733057311},"1":{"star_index":52891,"get_star_ts":1733056999}}},"name":"Hugo Lévêque","local_score":42,"stars":6,"id":4108850},"3261721":{"completion_day_level":{"2":{"2":{"star_index":292567,"get_star_ts":1733137740},"1":{"star_index":248254,"get_star_ts":1733127757}},"1":{"2":{"get_star_ts":1733087889,"star_index":146354},"1":{"star_index":145427,"get_star_ts":1733087561}}},"global_score":0,"name":"Coco","last_star_ts":1733137740,"id":3261721,"local_score":28,"stars":4},"1112427":{"local_score":48,"stars":6,"id":1112427,"last_star_ts":1733214972,"global_score":0,"completion_day_level":{"3":{"1":{"star_index":549659,"get_star_ts":1733211871},"2":{"star_index":564506,"get_star_ts":1733214972}},"2":{"1":{"get_star_ts":1733133275,"star_index":273857},"2":{"get_star_ts":1733155584,"star_index":362677}},"1":{"2":{"get_star_ts":1733039621,"star_index":1794},"1":{"get_star_ts":1733038774,"star_index":0}}},"name":"sKyoKun"},"4141014":{"local_score":24,"stars":6,"id":4141014,"last_star_ts":1733235017,"completion_day_level":{"3":{"2":{"get_star_ts":1733235017,"star_index":642180},"1":{"get_star_ts":1733233429,"star_index":636333}},"2":{"2":{"get_star_ts":1733220687,"star_index":590561},"1":{"get_star_ts":1733220524,"star_index":589900}},"1":{"2":{"star_index":585331,"get_star_ts":1733219465},"1":{"star_index":584965,"get_star_ts":1733219389}}},"name":"Fatma Lahmer","global_score":0},"4475790":{"last_star_ts":1733233784,"completion_day_level":{"3":{"2":{"get_star_ts":1733233784,"star_index":637699},"1":{"star_index":596612,"get_star_ts":1733222167}},"2":{"2":{"star_index":337586,"get_star_ts":1733149546},"1":{"get_star_ts":1733147666,"star_index":329960}},"1":{"2":{"star_index":313729,"get_star_ts":1733143469},"1":{"get_star_ts":1733142752,"star_index":310982}}},"name":"Alexis Trintignac","global_score":0,"local_score":33,"stars":6,"id":4475790},"2533333":{"completion_day_level":{"1":{"2":{"get_star_ts":1733047721,"star_index":24421},"1":{"get_star_ts":1733047390,"star_index":23365}},"3":{"1":{"get_star_ts":1733207906,"star_index":532250},"2":{"star_index":535269,"get_star_ts":1733208614}},"2":{"1":{"get_star_ts":1733121171,"star_index":221902},"2":{"star_index":226846,"get_star_ts":1733122480}}},"global_score":0,"name":"Virus936","last_star_ts":1733208614,"id":2533333,"stars":6,"local_score":57},"4125440":{"stars":4,"local_score":15,"id":4125440,"last_star_ts":1733232241,"completion_day_level":{"1":{"1":{"get_star_ts":1733137229,"star_index":290557},"2":{"star_index":583701,"get_star_ts":1733219099}},"2":{"2":{"star_index":631990,"get_star_ts":1733232241},"1":{"star_index":591519,"get_star_ts":1733220913}}},"name":"Mahmoud Kotti","global_score":0}},"event":"2024","owner_id":4234761}';

        return $testJson;
    }

    public function parseJsonLeaderboard($json): array
    {
        $leaderboard = [];
        $decodedJson = json_decode($json);

        foreach($decodedJson->members as $member)
        {
            $leaderboard[$member->name]['stars'] = $member->stars;
            $leaderboard[$member->name]['completion_day_level'] = [];
            foreach($member->completion_day_level as $key => $completionDay) {
                $leaderboard[$member->name]['completion_day_level'][$key] = $completionDay;
            }
        }

        // sort by stars
        uasort($leaderboard, function($a, $b) {
            return $b['stars'] - $a['stars'];
        });

        return $leaderboard;
    }
}
