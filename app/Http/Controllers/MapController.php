<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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

        $tags = Tag::all(); // すべてのタグを取得
        return view('map.index', compact('locations', 'tags'));
    }

    public function filterByTag(Tag $tag)
    {
        $locations = $tag->questions()->with('user')->latest()->get()->map(function ($location) {
            return [
                'id' => $location->id,
                'title' => $location->title,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'url' => route('questions.show', $location->id),
            ];
        });

        $tags = Tag::where('id', $tag->id)->get(); // 指定された $tag のみ取得

        return view('map.index', compact('locations', 'tags'));
    }

    function realTimeMode()
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

        $tags = Tag::all(); // すべてのタグを取得
        return view('map.realtimemode', compact('locations', 'tags'));
    }

    public function filterByTagRealTimeMode(Tag $tag)
    {
        $locations = $tag->questions()->with('user')->latest()->get()->map(function ($location) {
            return [
                'id' => $location->id,
                'title' => $location->title,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'url' => route('questions.show', $location->id),
            ];
        });

        $tags = Tag::where('id', $tag->id)->get(); // 指定された $tag のみ取得

        return view('map.realtimemode', compact('locations', 'tags'));
    }
}
