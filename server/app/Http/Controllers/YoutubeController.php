<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_YouTube;

class YoutubeController extends Controller
{
    const MAX_SNIPPETS_COUNT = 50;
    const DEFAULT_ORDER_TYPE = 'viewCount';

    public function getListByChannelId(string $channelId)
    {
        // Googleへの接続情報のインスタンスを作成と設定
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));

        // 接続情報のインスタンスを用いてYoutubeのデータへアクセス可能なインスタンスを生成
        $youtube = new Google_Service_YouTube($client);

        // 接続情報のインスタンスを用いてYoutubeのデータへアクセス可能なインスタンスを生成
        $items = $youtube->search->listSearch('snippet', [
            'channelId'  => $channelId,
            'order'      => self::DEFAULT_ORDER_TYPE,
            'maxResults' => self::MAX_SNIPPETS_COUNT,
        ]);

        // 連想配列だと扱いづらいのでcollection化して処理
        $snippets = collect($items->getItems())->pluck('snippet')->all();
        return view('youtube/index')->with(['snippets' => $snippets]);
    }
}

