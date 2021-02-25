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
                    Youtube Title List;
                </h1>
                <p class="header__title__sub">
                    This is Youtube Title GET;
                </p>
            </div>
        </div>
        <div class="content">
            <p class="body__error" style="color:red">{{ $errors->first('table_id') }}</p>
            <form action="{{ action('YoutubeController@searchList') }}" method = "GET">
                <select name="table_id">
                    <option value='' disabled selected style='display:none;'>チャンネル名を選択してください</option>
                    @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                    @endforeach
                    <option value="12">12</option>                    
                </select>
                <input type="submit" name="submit" value="検索"/>
            </form>
        </div>
    </div>
</body>
</html>