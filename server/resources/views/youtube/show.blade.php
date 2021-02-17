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
                    {{ $snippets[0]->channelTitle }}
                </h1>
                <p class="header__title__sub">
                    This is Youtube Title GET;
                </p>
            </div>
        </div>
        <div class="content">
            <div class="content__body">
                @foreach ($snippets as $snippet)
                    <div class="content__body__videos">
                        <p>
                            {{ $snippet->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="hooter">
            <div class="hooter_bar">
            @if (isset($prev_page_token))
                <a href ="{{ route('list',['id' => $channelId,'page_token' => $prev_page_token]) }}"><p class="hooter_pre"> 前へ </p></a>
            @else
                <p class="hooter_pre"> 前へ </p>
            @endif
            @if (isset($next_page_token))
                <a href ="{{ route('list',['id' => $channelId,'page_token' => $next_page_token]) }}"><p class="hooter_next"> 次へ </p></a>
            @else
                <p class="hooter_next"> 次へ </p>
            @endif
            </div>
            <a href ="/"><p class="back">選択画面に戻る</p></a>
        </div>
    </div>
</body>
</html>