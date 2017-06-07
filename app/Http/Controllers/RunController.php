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
//            dd($node->text());
            Topic::create(['id' => $node->attr('id'), 'title' => $node->text()]);
        });
        return view('welcome');
    }
}
