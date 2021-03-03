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
                <p class="header_edit_order">
                    <form action="{{ action('YoutubeController@getOrderType', $target_channel->id) }}" method = "GET">
                        <select name="dropdown_order" onchange="submit(this.form)">
                        @foreach ($order_types as $order_type_key => $order_type_value)
                            <option value="{{ $order_type_key }}" {{ $order_type_key === $order ? " selected" : '' }}>{{ $order_type_value }}順</option>
                        @endforeach
                        </select>
                    </form>
                </p>
            </div>
        </div>
        <div class="content">
            <div class="content__body">
                @foreach ($result->items as $item)
                    <div class="content__body__videos">
                        <p>
                            {{ $item->snippet->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="hooter">
            <div class="hooter_bar">
            @if (isset($result->prevPageToken))
                <a href ="{{ route('list',['channel' => $target_channel->id,'page_token' => $result->prevPageToken, 'dropdown_order' => $order]) }}"><p class="hooter_pre"> 前へ </p></a>
            @else
                <p class="hooter_pre"> 前へ </p>
            @endif
            @if (isset($result->nextPageToken))
                <a href ="{{ route('list',['channel' => $target_channel, 'page_token' => $result->nextPageToken, 'dropdown_order' => $order]) }}"><p class="hooter_next"> 次へ </p></a>
            @else
                <p class="hooter_next"> 次へ </p>
            @endif
            </div>
            <a href ="/"><p class="back">選択画面に戻る</p></a>
        </div>
    </div>
</body>
</html>