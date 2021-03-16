<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChannelRequest;
use App\Http\Requests\ShowOrderRequest;
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
    const DISPLAY_OPTION_COLUMN = [
        'title'       => ['name' => 'display_columns[]', 'status' => '', 'extract_method' => 'snippet',    'value_jap' => 'タイトル名'],
        'description' => ['name' => 'display_columns[]', 'status' => '', 'extract_method' => 'snippet',    'value_jap' => '概要'],
        'publishedAt' => ['name' => 'display_columns[]', 'status' => '', 'extract_method' => 'snippet',    'value_jap' => '投稿日'],
    ];
    const DISPLAY_OPTION_VALUE = [
        'viewCount'   => ['name' => 'display_values[]',  'status' => '', 'extract_method' => 'statistics', 'value_jap' => '再生回数'],
    ];

    public function index(Channel $channel)
    {
        $display_option = array_merge(self::DISPLAY_OPTION_COLUMN,self::DISPLAY_OPTION_VALUE);
        $display_option['title']['status'] = 'checked';
        return view('youtube/index')->with(['channels' => $channel->get(), 'display_option' => $display_option]);
    }

    public function searchList(Channel $channel, ChannelRequest $request)
    {
        $get_display_option = $this->getDisplayOption($request->display_columns,$request->display_values);
        return redirect()->route('list',['channel' => $request->table_id, 'dropdown_order' => $request->dropdown_order])->with(['display_option' => $get_display_option['display_option'], 'display_value_exist' => $get_display_option['display_value_exist']]);
    }

    private function getDisplayOption(array $request_column_keys, array $request_value_keys = null)
    {
        $display_value_exist = false;
        $display_option = array_merge(self::DISPLAY_OPTION_COLUMN, self::DISPLAY_OPTION_VALUE);
        if (is_null($request_value_keys)){
            $request_keys = $request_column_keys;
        } else {
            $request_keys = array_merge($request_column_keys, $request_value_keys);    
            $display_value_exist = true;
        };
        foreach ($request_keys as $request_key){
            $display_option[$request_key]['status'] = 'checked';
        };
        return ['display_option' => $display_option, 'display_value_exist' => $display_value_exist];
    }

    private function convertDisplayFormat(object $result)
    {
        foreach ($result->items as $item){
            $item->snippet->publishedAt = date('Y/m/d H:i',strtotime($item->snippet->publishedAt));
            if (isset($item->statistics->viewCount)){
                $item->statistics->viewCount = number_format($item->statistics->viewCount).'回';
            };
        };
        return $result;
    }

    public function getListByChannelIdAndToken(Channel $channel, string $page_token = '', Request $request)
    {
        $request->session()->flash('display_option',$request->session()->get('display_option'));
        $request->session()->flash('display_value_exist',$request->session()->get('display_value_exist'));
        $checked_display_option = array_filter($request->session()->get('display_option'),function($element){
            return $element['status'] == 'checked';
        });
        $result = $this->getListFromYoutubeAPI($channel->youtube_channel_id, $request->dropdown_order, $page_token, $request->session()->get('display_value_exist'));
        $result = $this->convertDisplayFormat($result);
        return view('youtube/show')->with([
             'target_channel'         => $channel, 
             'result'                 => $result, 
             'order_types'            => self::ORDER_TYPE, 
             'order'                  => $request->dropdown_order, 
             'display_option'         => $request->session()->get('display_option'), 
             'checked_display_option' => $checked_display_option,
             ]);
    }

    public function getShowRequest(Channel $channel, ShowOrderRequest $request, string $page_token = '')
    {
        $get_display_option = $this->getDisplayOption($request->display_columns,$request->display_values);
        return redirect()->route('list',['channel' => $channel->id, 'page_token' => $request->page_token, 'dropdown_order' => $request->dropdown_order])->with(['display_option' => $get_display_option['display_option'], 'display_value_exist' => $get_display_option['display_value_exist']]);
    }

    private function getListFromYoutubeAPI(string $channel_id, string $order_type, string $page_token = '',$display_value_exist)
    {
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $youtube = new Google_Service_YouTube($client);
        $channel_search_snippets = $youtube->search->listSearch('snippet', [
            'channelId'     => $channel_id,
            'order'         => $order_type,
            'maxResults'    => self::MAX_SNIPPETS_COUNT,
            'pageToken'     => $page_token,
            'type'          => 'video',
        ]);
        if ($display_value_exist){
            $channel_search_snippets = $this->getVideoDetailFromYoutubeAPI($youtube,$channel_search_snippets);
        }
        return $channel_search_snippets;
    }

    private function getVideoDetailFromYoutubeAPI($youtube,$channel_search_snippets){
        $channel_search_items = $channel_search_snippets->items;
        foreach ($channel_search_items as $channel_search_item){
            $video_detail_result = $youtube->videos->listVideos('statistics', [
                'id'     => $channel_search_item->id->videoId,
            ]);
            // ****** $video_detail_result->items　は常に要素1の配列のため、[0]で指定（他の方法あり？) ******
            $channel_search_item->statistics = $video_detail_result->items[0]->statistics;
        };
        $channel_search_snippets->items = $channel_search_items;
        return $channel_search_snippets;
    }
}