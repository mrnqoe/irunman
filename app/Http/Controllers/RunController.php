<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class RunController extends Controller
{
    public function runGo()
    {
        $lineItemKey = '//ul[@class="segmented-list results-list"]/li[contains(@id, "result-")]';
        $crawler = GoutteFacade::request('GET', 'https://www.expedia.ca/service/');
        $crawler->filterXPath($lineItemKey) -> each(function ($node) {
            $topicId = substr ($node -> attr('id'), -3 );
            $topicTitle = $node->children()->text();
            $topicUrl = 'https://www.expedia.ca/service/#/articles/' . $topicId;
            $topic = new Topic;
            $topic -> id = $topicId;
            $topic->title = $topicTitle;
            $topic->url = $topicUrl;
            $topic -> save();
        });
        return view('welcome');
    }
}
