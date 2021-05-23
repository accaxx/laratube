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
        <form action="" method = "GET">
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
                <select name="dropdown_order" class="display-inlineblock text">
                    @foreach ($order_types as $order_type_key => $order_type_value)
                    <option value="<?= $order_type_key; ?>"><?= $order_type_value; ?>順</option>
                    @endforeach
                </select>
                <input type="button" id="btn_display" class="button" name="btn_display" value="表示項目を編集" onclick="return displayChange();"/>
            </div>
            <div class="display_select display">               
                <div class="text display">表示項目を選択してください。</div>
                <div class="text_area display">
                    @foreach ($display_option as $display_option_key => $display_option_value)
                    <label><input type="checkbox" name="{{ $display_option_value['name'] }}" value="{{ $display_option_key }}" class="display_inline-block" {{ $display_option_value['status'] === "checked" ? " checked" : '' }}>{{ $display_option_value['value_jap'] }}</label>
                    @endforeach
                </div>
            </div>
            <div class="margin-tb-10 padding-top-20">
                <input type="submit" name="submit_search" formaction="{{ action('YoutubeController@searchList') }}" class="button" value="表示"/>
                <input type="submit" name="submit_exportcsv" formaction="{{ action('YoutubeController@csvExport') }}" class="button" value="出力"/>
            </div>
        </form>
    </div>
    <script src={{ asset('js/app.js') }}></script>
</body>
</html>
