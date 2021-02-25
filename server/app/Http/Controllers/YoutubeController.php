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
        $order = self::DEFAULT_ORDER_TYPE;
        return redirect('youtube/'.$request->table_id.'/titles/'.$order);
    }

    public function getListByChannelIdAndToken(Channel $channel, string $order = self::DEFAULT_ORDER_TYPE, string $page_token = '')
    {        
        $order_type = self::ORDER_TYPE;
        $result = $this->getListFromYoutubeAPI($channel->youtube_channel_id, $order, $page_token);
        return view('youtube/show')->with(['target_channel' => $channel, 'result' => $result, 'order_types' => $order_type, 'order' => $order]);
    }

    public function getOrderType(Channel $channel, Request $request,string $page_token = '')
    {
        $result = $this->getListFromYoutubeAPI($channel->youtube_channel_id,'',$request->dropdown_order);
        return redirect('youtube/'.$request->table_id.'/titles/'.$request->dropdown_order);
        // return view('youtube/show')->with(['target_channel' => $channel, 'result' => $result, 'order_types' => $order_type, 'prev_order_type' => $prev_order_type]);
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

