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

    public function searchList(Channel $channel, ChannelRequest $request)
    {
        $target_channel = $channel->find($request->table_id);
        $result = $this->getListFromYoutubeAPI($target_channel->youtube_channel_id);
        return view('youtube/show')->with(['target_channel' => $target_channel, 'result' => $result]);
    }

    public function getListByChannelIdAndToken(Channel $channel, string $page_token = '')
    {
        $result = $this->getListFromYoutubeAPI($channel->youtube_channel_id, $page_token);
        return view('youtube/show')->with(['target_channel' => $channel, 'result' => $result]);
    }

    private function getListFromYoutubeAPI(string $channel_id, string $page_token ='')
    {
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $youtube = new Google_Service_YouTube($client);
        return $youtube->search->listSearch('snippet', [
            'channelId'     => $channel_id,
            'order'         => self::DEFAULT_ORDER_TYPE,
            'maxResults'    => self::MAX_SNIPPETS_COUNT,
            'pageToken'     => $page_token,
        ]);
    }
}

