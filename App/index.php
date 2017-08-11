<?php
namespace App;

require "vendor/autoload.php";

function loadJson($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

// function githubScore($events)
// {
//     $event_types = [];
//     $score = 0;

//     foreach ($events as $event) {
//         $event_types[] = $event['type'];
//     }

//     foreach ($event_types as $event_type) {
//         switch ($event_type) {
//             case 'PushEvent':
//                 $score += 5;
//                 break;
//             case 'CreateEvent':
//                 $score += 4;
//                 break;
//             case 'IssueEvent':
//                 $score += 3;
//                 break;
//             case 'CommitEvent':
//                 $score += 2;
//                 break;
//             default:
//                 $score += 1;
//                 break;
//         }
//     }
//     return $score;
// }


function githubScore($events)
{
    return $events
        ->pluck('type')
        ->map(function ($event_type) {
            $score_table = collect([
                'PushEvent' => 5,
                'CreateEvent' => 4,
                'IssueEvent' => 3,
                'CommitEvent' => 2,
            ]);
            return $score_table->get($event_type, 1);
        })->sum();
}

$events = collect(loadJson('github.json'));

echo githubScore($events);
