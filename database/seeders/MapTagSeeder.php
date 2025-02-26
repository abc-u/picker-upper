<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MapTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // マップアプリケーションに関連するタグ20個のリスト
        $tags = [
            'カフェ',
            'レストラン',
            'バー',
            '公園',
            '博物館',
            '映画館',
            '図書館',
            'ショッピングモール',
            'スーパーマーケット',
            'ホテル',
            '遊園地',
            'ビーチ',
        ];

        // リストの各タグをデータベースに挿入
        foreach ($tags as $tag) {
            Tag::create(['body' => $tag]);
        }
    }
}
