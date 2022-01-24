<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;


class CrawlController extends Controller
{
    protected $results = [];

    public function GetContent(Request $request)
    {
        $url = $request->url;
        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('.new_news')->each(function ($node, $i) {
            $this->results[$i]['title'] = $node->filter('.new_news_cnt a > p ')->text();
            $this->results[$i]['content'] = $node->filter('.new_news_cnt div')->text();
            $this->results[$i]['url'] = $node->filter('a')->evaluate('substring-after(@href,"")')[0];
            $this->results[$i]['created_at'] = $node->filter('.news_date')->text();
        });
        return $this->results;
    }

    public function GetSingle(Request $request)
    {
        $url = $request->url;
        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('#main_cnt')->each(function ($node) {
            $this->results['title'] = $node->filter('.titxshr h1 ')->text();
            $node->filter('.article_main p')->each(function ($item, $i) {
                $this->results['content'][$i] = $item->text();
            });
            $node->filter('.article_date span')->each(function ($item, $i) {
                $this->results['created_at'][$i] = $item->text();
            });
        });
        $this->results['url'] = $url;
        return $this->results;
    }

    public function GetScreenShot(Request $request)
    {
        $url = $request->url;
        //screenshot
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://website-screenshot6.p.rapidapi.com/screenshot?url=" . urlencode($url) . "&width=1920&height=1080&fullscreen=true",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: website-screenshot6.p.rapidapi.com",
                "x-rapidapi-key: ed90b8e3c0msh49aa8378f18fb39p1c4a88jsn7706a8089d83"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
        }
        $response = json_decode($response);
        $url_ss = $response->screenshotUrl;
        return $url_ss;
    }
}
