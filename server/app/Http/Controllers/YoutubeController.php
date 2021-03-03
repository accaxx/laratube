<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChannelRequest;
use App\Channel;
use Google_Client;
use Google_Service_YouTube;

class YoutubeController extends Controller
{
    const MAX_SNIPPETS_COUNT = 50;
    const DEFAULT_ORDER_TYPE = 'viewCount';
    const ORDER_TYPE = [
        'viewCount' => '再生回数',
        'date'      => '日付',
        'rating'    => '評価',
        'title'     => 'タイトル', 
    ];

    public function index(Channel $channel)
    {
        return view('youtube/index')->with(['channels' => $channel->get()]);
    }

    public function searchList(Channel $channel, ChannelRequest $request)
    {
        return redirect()->route('list',['channel' => $request->table_id, 'dropdown_order' => $request->dropdown_order]);
    }

    public function getListByChannelIdAndToken(Channel $channel, string $page_token = '', Request $request)
    {
        $result = $this->getListFromYoutubeAPI($channel->youtube_channel_id, $request->dropdown_order, $page_token);
        return view('youtube/show')->with(['target_channel' => $channel, 'result' => $result, 'order_types' => self::ORDER_TYPE, 'order' => $request->dropdown_order]);
    }

    public function getOrderType(Channel $channel, Request $request,string $page_token = '')
    {
        return redirect()->route('list',['channel' => $channel->id, 'dropdown_order' => $request->dropdown_order]);
    }
    private function getListFromYoutubeAPI(string $channel_id, string $order_type, string $page_token = '')
    {
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $youtube = new Google_Service_YouTube($client);
        return $youtube->search->listSearch('snippet', [
            'channelId'     => $channel_id,
            'order'         => $order_type,
            'maxResults'    => self::MAX_SNIPPETS_COUNT,
            'pageToken'     => $page_token,
        ]);
    }
}