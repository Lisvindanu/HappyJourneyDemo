<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\Testimonial;
use App\Models\TourPackage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $packages = TourPackage::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('price_adult')
            ->get();

        // If no featured, take first 6 active
        if ($packages->isEmpty()) {
            $packages = TourPackage::where('is_active', true)
                ->orderBy('price_adult')
                ->take(6)
                ->get();
        }

        $testimonials = Testimonial::where('is_active', true)->get();

        $articles = BlogArticle::where('is_active', true)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        // Top 6 destinations by package count (for home section)
        $allDests = [
            ['name'=>'China',         'label'=>'Tour China',         'flag'=>'🇨🇳', 'image'=>'images/packages/china-8d-shanghai-beijing.jpg'],
            ['name'=>'Jepang',        'label'=>'Tour Jepang',        'flag'=>'🇯🇵', 'image'=>'images/packages/japan-featured.jpg'],
            ['name'=>'Korea',         'label'=>'Tour Korea',         'flag'=>'🇰🇷', 'image'=>'images/packages/korea-6d-shocking-sale.jpg'],
            ['name'=>'Vietnam',       'label'=>'Tour Vietnam',       'flag'=>'🇻🇳', 'image'=>'images/blog/vietnam-halong-sapa.jpg'],
            ['name'=>'Eropa',         'label'=>'Tour Eropa',         'flag'=>'🌍',  'image'=>'images/packages/europe-west.jpg'],
            ['name'=>'Turki',         'label'=>'Tour Turki',         'flag'=>'🇹🇷', 'image'=>'images/packages/turkey-eropa.jpg'],
            ['name'=>'Taiwan',        'label'=>'Tour Taiwan',        'flag'=>'🇹🇼', 'image'=>null],
            ['name'=>'Hong Kong',     'label'=>'Tour Hong Kong',     'flag'=>'🇭🇰', 'image'=>null],
            ['name'=>'Dubai',         'label'=>'Tour Dubai',         'flag'=>'🇦🇪', 'image'=>null],
            ['name'=>'Asia Tenggara', 'label'=>'Tour Asia Tenggara', 'flag'=>'🌏',  'image'=>'images/blog/vietnam-halong-sapa.jpg'],
            ['name'=>'Thailand',      'label'=>'Tour Thailand',      'flag'=>'🇹🇭', 'image'=>null],
            ['name'=>'Australia',     'label'=>'Tour Australia',     'flag'=>'🇦🇺', 'image'=>null],
            ['name'=>'Holyland',      'label'=>'Tour Holyland',      'flag'=>'☪️',  'image'=>null],
            ['name'=>'Indonesia',     'label'=>'Tour Domestik',      'flag'=>'🇮🇩', 'image'=>null],
            ['name'=>'Cruise',        'label'=>'Cruise Ship',        'flag'=>'🚢',  'image'=>null],
        ];

        $featuredDestinations = collect($allDests)
            ->map(function ($d) {
                $d['count'] = TourPackage::where('is_active', true)
                    ->where('destination', $d['name'])
                    ->count();
                return $d;
            })
            ->sortByDesc('count')
            ->take(6)
            ->values();

        return view('home', compact('packages', 'testimonials', 'articles', 'featuredDestinations'));
    }
}
