<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youtube</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="index">
    <div class="main">
        <div class="header">
            <div class="header__title">
                <h1 class="header__title__main">
                    {{ $target_channel->name }}
                </h1>
                <p class="header__title__sub">
                    Here is the list
                </p>
            </div>
            <div class="header_edit">
                @foreach ($errors->all() as $error)
                <div class="error">{{ $error }}</div>
                @endforeach
                <div class="header_edit_order">
                    <input type="button" id="btn_display" class="button display-inlineblock" name="btn_display" value="表示項目を編集" onclick="return displayChange();"/>
                    <form action="{{ action('YoutubeController@getShowRequest', $target_channel->id) }}" name="form_order" class="display-inlineblock text" method = "GET">
                        @include('youtube.components.show_request',[
                            'form_name'              => 'form_order',
                            'order_types'            => $order_types,
                            'order'                  => $order,
                            'display_option'         => $display_option,
                            'checked_display_option' => $checked_display_option,
                            'prevPageToken'          => $result->prevPageToken,
                            'nextPageToken'          => $result->nextPageToken, 
                            ])
                    </form>
                </div>
                <p class="display_select display">
                    <div class="text display">表示項目を選択してください。</div>
                    <div class="text_area display">
                        <form action="{{ action('YoutubeController@getShowRequest', $target_channel->id) }}" name="form_display" method = "GET">
                            @include('youtube.components.show_request',[
                                'form_name'              => 'form_display',
                                'order_types'            => $order_types,
                                'order'                  => $order,
                                'display_option'         => $display_option,
                                'checked_display_option' => $checked_display_option,
                                'prevPageToken'          => $result->prevPageToken,
                                'nextPageToken'          => $result->nextPageToken, 
                                ])                            
                            <div class="margin-right-auto">
                                <input type="button" name="btn_display_execute" class="display button margin-tb-10 margin-right-auto" value="編集を実行" onclick="submit(this.form)"/>
                            </div>
                        </form>
                    </div>
                </p>
            </div>
        </div>
        <div class="content">
            <div class="content__body">
                @foreach ($result->items as $item)
                    <p class="content__body__videos  border-top-dashed">
                        @foreach ($checked_display_option as $checked_display_option_key => $checked_display_option_value)
                        <div class="text"><{{ $checked_display_option_value['value_jap'] }}></div>
                        <div class="content_text">{{ $item->{$checked_display_option_value['extract_method']}->$checked_display_option_key }}</div>
                        @endforeach
                    </p>
                @endforeach
            </div>
        </div>
        <div class="hooter border-top-dashed">
            <div class="hooter_bar">
                @if (isset($result->prevPageToken))
                <form action="{{ action('YoutubeController@getShowRequest', $target_channel->id) }}" method = "GET" name="form_peginate_prev" class="hooter_text display-inlineblock">
                    @include('youtube.components.show_request',[
                        'form_name'              => 'form_peginate_prev',
                        'order_types'            => $order_types,
                        'order'                  => $order,
                        'display_option'         => $display_option,
                        'checked_display_option' => $checked_display_option,
                        'prevPageToken'          => $result->prevPageToken,
                        'nextPageToken'          => $result->nextPageToken, 
                        ])
                    <a href ="javascript:form_peginate_prev.submit()"><div class="hooter_text display-inlineblock"> 前へ </div></a>
                </form>
                @else
                    <div class="hooter_text display-inlineblock"> 前へ </div>
                @endif            
                @if (isset($result->nextPageToken))
                <form action="{{ action('YoutubeController@getShowRequest', $target_channel->id) }}" method = "GET" name="form_peginate_next" class="hooter_text display-inlineblock">
                    @include('youtube.components.show_request',[
                        'form_name'              => 'form_peginate_next',
                        'order_types'            => $order_types,
                        'order'                  => $order,
                        'display_option'         => $display_option,
                        'checked_display_option' => $checked_display_option,
                        'prevPageToken'          => $result->prevPageToken,
                        'nextPageToken'          => $result->nextPageToken, 
                        ])
                    <a href ="javascript:form_peginate_next.submit()"><div class="hooter_text display-inlineblock"> 次へ </div></a>
                </form>
                @else
                    <div class="hooter_text display-inlineblock"> 次へ </div>
                @endif
            </div>
            <a href ="/"><div class="hooter_text">選択画面に戻る</div></a>
        </div>
    </div>
    <script src={{ asset('js/app.js') }}></script>
</body>
</html>