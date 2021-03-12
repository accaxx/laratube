<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequest;
use App\Channel;
use Google_Client;
use Google_Service_YouTube;

class YoutubeController extends Controller
{
    const MAX_SNIPPETS_COUNT = 50;
    const DEFAULT_ORDER_TYPE = 'viewCount';

    public function index(Channel $channel)
    {
        return view('youtube/index')->with(['channels' => $channel->get()]);
    }

    public function processForm(Channel $channel,ChannelRequest $request)
    {
        return redirect('youtube/channels/'.$channel->find($request->table_id)->youtube_channel_id.'/titles');    
    }

    public function getListByChannelId(string $channelId,string $pageToken ='')
    {
        // Googleへの接続情報のインスタンスを作成と設定
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        // 接続情報のインスタンスを用いてYoutubeのデータへアクセス可能なインスタンスを生成
        $youtube = new Google_Service_YouTube($client);
        // 必要情報を引数に持たせ、listSearchで検索して動画一覧を取得
        $items = $youtube->search->listSearch('snippet', [
            'channelId'     => $channelId,
            'order'         => self::DEFAULT_ORDER_TYPE,
            'maxResults'    => self::MAX_SNIPPETS_COUNT,
            'pageToken'     => $pageToken,
        ]);
        // 連想配列だと扱いづらいのでcollection化して処理
        $next_page_token = $items['nextPageToken'];
        $prev_page_token = $items['prevPageToken'];
        $snippets = collect($items->getItems())->pluck('snippet')->all();
        // チャンネルタイトルの取得
        $channelTitle = Channel::where('youtube_channel_id',$channelId)->first()->name;
        return view('youtube/show')->with(['snippets' => $snippets,'channelId' => $channelId, 'next_page_token' => $next_page_token,'prev_page_token' => $prev_page_token,'channelTitle' => $channelTitle]);
    }
}

