<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("channels")->insert([
            [
                "name" => "はじめしゃちょー（hajime）",
                "youtube_channel_id" => "UCgMPP6RRjktV7krOfyUewqw",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "HikakinTV",
                "youtube_channel_id" => "UCZf__ehlCEBPop-_sldpBUQ",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "Fischer's-フィッシャーズ-",
                "youtube_channel_id" => "UCibEhpu5HP45-w7Bq1ZIulw",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "Travel Thirsty",
                "youtube_channel_id" => "UCHKVXtT1YBCYUnnr4apqXfg",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "東海オンエア",
                "youtube_channel_id" => "UCutJqz56653xV2wwSvut_hQ",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "米津玄師",
                "youtube_channel_id" => "UCUCeZaZeJbEYAAzvMgrKOP",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "Yuka Kinoshita木下ゆうか",
                "youtube_channel_id" => "UCFTVNLC7ysej-sD5lkLqNGA",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "SUSHI RAMEN【Riku】",
                "youtube_channel_id" => "UCljYHFazflmGaDr5Lo90KmA",
                "updated_at" => now(),
                "created_at" => now(),
            ],
            [
                "name" => "avex",
                "youtube_channel_id" => "UC1oPBUWifc0QOOY8DEKhLuQ",
                "updated_at" => now(),
                "created_at" => now(),
            ],
        ]);
<<<<<<< HEAD
        //
=======
>>>>>>> d0fb6c492fe94144f20f3231eb303633ca65cc01
    }
}
