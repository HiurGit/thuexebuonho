<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Banner hero chính',
                'image' => 'assets/image/banner-main.png',
                'position' => 'hero',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Banner giá 1',
                'image' => 'assets/banner-price/banner-gia1.png',
                'position' => 'banner-price',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Banner giá 2',
                'image' => 'assets/banner-price/banner-gia2.png',
                'position' => 'banner-price',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Banner giá 3',
                'image' => 'assets/banner-price/banner-gia3.png',
                'position' => 'banner-price',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Banner giá 4',
                'image' => 'assets/banner-price/banner-gia4.png',
                'position' => 'banner-price',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
