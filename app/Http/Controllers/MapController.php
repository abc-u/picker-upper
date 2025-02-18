<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class MapController extends Controller
{
    // function index()
    // {
    //     // $questions = Question::all();
    //     $locations = Question::select('id', 'title', 'latitude', 'longitude')->get();
    //     //$questions = "questionだよ";
    //     // $questions = [
    //     //     "mainData" => "questionだよ"
    //     // ];

    //     return view('map.index', compact('locations'));
    //     //dd($questions);
    //     //return view('questions.main',compact('questions'));
    // }

    public function index()
    {
        $locations = Question::all()->map(function ($location) {
            return [
                'id' => $location->id,
                'title' => $location->title,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'url' => route('questions.show', $location->id),
            ];
        });

        return view('map.index', compact('locations'));
    }
}
