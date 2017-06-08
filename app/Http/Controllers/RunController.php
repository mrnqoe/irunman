<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class RunController extends Controller
{
    public function runGo()
    {
        $baseUri = 'https://www.expedia.ca/service/?langid=3084';
        $topicLineItemKey = '//ul/li[contains(@id, "result-")]';

        $crawler = GoutteFacade::request('GET', $baseUri);
        $crawler->filterXPath($topicLineItemKey) -> each(function ($node) use ($baseUri) {
            $topicId = substr($node->attr('id'), -3);
            $topicUrl = $baseUri.'/articles/'.$topicId;
            $topicTitle = preg_replace('/\s\s+/', ' ', $node->children()->text());

            $topic = Topic::firstOrNew(['id' => $topicId]);
            $topic->url = $topicUrl;
            $topic->title = trim ( $topicTitle,  ' \t\n\r\0\x0B');
            $topic->save();
        });

        $topics = Topic::all();
//        dump($topics);
        foreach($topics as $topic) {
            $categoryLineItemKey =  '//ul/li[@id=\'result-'.$topic->id.'\']/section/ul/li[3]/a';
            $crawler = GoutteFacade::request('GET', $topic->url);
            $crawler->filterXPath($categoryLineItemKey) -> each(function ($node) use ($baseUri) {
                $catId = $node->attr('href');
                $catUrl = $baseUri.'/articles/'.$topicId;
                $catTitle = preg_replace('/\s\s+/', ' ', $node->children()->text());

                $cat = Category::firstOrNew(['id' => $catId]);
                $cat->url = $catUrl;
                $cat->title = trim ( $catTitle,  ' \t\n\r\0\x0B');
                $cat->save();
            });
        }
        return view('welcome');
    }
}
