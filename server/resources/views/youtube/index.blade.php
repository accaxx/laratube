<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youtube</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="index">
    <div class="main">
        <div class="header">
            <div class="header__title">
                <h1 class="header__title__main">
                    Youtube API Practice;
                </h1>
            </div>
        </div>
        <form action="{{ action('YoutubeController@searchList') }}" method = "GET">
            <div class="content">
                @foreach ($errors->all() as $error)
                <div class="error">{{ $error }}</div>
                @endforeach
                <select name="table_id">
                    <option value='' disabled selected style='display:none;'>チャンネル名を選択してください</option>
                    @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="dropdown_order" value="viewCount"/>
                <input type="button" id="btn_display" class="button" name="btn_display" value="表示項目を編集" onclick="return displayChange();"/>
                <input type="submit" name="submit" class="button" value="検索"/>
            </div>
            <div class="display_select display">               
                <div class="text display">表示項目を選択してください。</div>
                <div class="text_area display">
                    @foreach ($display_option as $display_option_key => $display_option_value)
                    <label><input type="checkbox" name="{{ $display_option_value['name'] }}" value="{{ $display_option_key }}" class="display_inline-block" {{ $display_option_value['status'] === "checked" ? " checked" : '' }}>{{ $display_option_value['value_jap'] }}</label>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
    <script src={{ asset('js/app.js') }}></script>
</body>
</html>
