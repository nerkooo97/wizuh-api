<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicCategoryResource;
use App\Http\Resources\TopicResource;
use App\Http\Resources\WordpressMediaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use simplehtmldom\HtmlWeb;
use DOMDocument;
use DOMXPath;
use App\Models\Topic;

class TopicController extends BaseController
{
    public function index(Request $request)
    {
        return Topic::paginate();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    /* public function index(Request $request)
    {
        $response = file_get_contents(self::PROJEKT_NJEMACKA_API . 'posts');
        $test = Http::get('https://projektnjemacka.com/wp-json/wp/v2/' . 'posts');
        $topics = json_decode($test);

        foreach ($topics as $topic) {
            if (isset($topic->featured_media)) {
                $media = $this->getMedia($topic->featured_media);
                $topic->featured_media_url = $media;
            }
        }

        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $topics = array_filter($topics, function ($topic) use ($categoryId) {
                return in_array($categoryId, $topic->categories);
            });
        }

        return $this->sendResponse(TopicResource::collection($topics), 'Topics retrieved successfully.');
    }

    public function getCategories(Request $request)
    {

        $response = file_get_contents(self::PROJEKT_NJEMACKA_API . 'categories?per_page=100');
        $categories = json_decode($response);

        $results = TopicCategoryResource::collection($categories);

        return $this->sendResponse($results, 'Categories retrieved successfully.');
    }


    public function getMedia(int $id) 
    {   
        if(!$id){
            return;
        }

        $response = file_get_contents('https://projektnjemacka.com/wp-json/wp/v2/media/' . $id);
        $media = json_decode($response);
        return $media->guid->rendered ?? null;
    } */
}
