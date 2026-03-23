<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function destinations(): View
    {
        $destinations = [
            ['name'=>'China',         'label'=>'Tour China',         'flag'=>'🇨🇳', 'image'=>'/images/packages/china-8d-shanghai-beijing.jpg'],
            ['name'=>'Jepang',        'label'=>'Tour Jepang',        'flag'=>'🇯🇵', 'image'=>'/images/packages/japan-featured.jpg'],
            ['name'=>'Korea',         'label'=>'Tour Korea',         'flag'=>'🇰🇷', 'image'=>'/images/packages/korea-6d-shocking-sale.jpg'],
            ['name'=>'Taiwan',        'label'=>'Tour Taiwan',        'flag'=>'🇹🇼', 'image'=>null],
            ['name'=>'Hong Kong',     'label'=>'Tour Hong Kong',     'flag'=>'🇭🇰', 'image'=>null],
            ['name'=>'Eropa',         'label'=>'Tour Eropa',         'flag'=>'🌍',  'image'=>'/images/packages/europe-west.jpg'],
            ['name'=>'Dubai',         'label'=>'Tour Dubai',         'flag'=>'🇦🇪', 'image'=>null],
            ['name'=>'Turki',         'label'=>'Tour Turki',         'flag'=>'🇹🇷', 'image'=>'/images/packages/turkey-eropa.jpg'],
            ['name'=>'Asia Tenggara', 'label'=>'Tour Asia Tenggara', 'flag'=>'🌏',  'image'=>'/images/blog/vietnam-halong-sapa.jpg'],
            ['name'=>'Thailand',      'label'=>'Tour Thailand',      'flag'=>'🇹🇭', 'image'=>null],
            ['name'=>'Vietnam',       'label'=>'Tour Vietnam',       'flag'=>'🇻🇳', 'image'=>'/images/blog/vietnam-halong-sapa.jpg'],
            ['name'=>'Australia',     'label'=>'Tour Australia',     'flag'=>'🇦🇺', 'image'=>null],
            ['name'=>'Holyland',      'label'=>'Tour Holyland',      'flag'=>'☪️',  'image'=>null],
            ['name'=>'Indonesia',     'label'=>'Tour Domestik',      'flag'=>'🇮🇩', 'image'=>null],
            ['name'=>'Cruise',        'label'=>'Cruise Ship',        'flag'=>'🚢',  'image'=>null],
        ];

        // Attach package counts
        foreach ($destinations as &$dest) {
            $dest['count'] = TourPackage::where('is_active', true)
                ->where('destination', $dest['name'])
                ->count();
        }

        return view('packages.destinations', compact('destinations'));
    }

    public function index(Request $request): View
    {
        $destination = $request->query('destination');
        $category    = $request->query('category', 'all');

        $query = TourPackage::where('is_active', true);

        if ($destination) {
            $query->where('destination', $destination);
            $category = strtolower($destination);
        } elseif ($category && $category !== 'all') {
            $destinationMap = [
                'asia'     => ['Korea', 'Jepang', 'China', 'Vietnam', 'Thailand', 'Hong Kong', 'Taiwan'],
                'eropa'    => ['Eropa', 'Turki'],
                'holyland' => ['Holyland'],
                'domestik' => ['Domestik Indonesia'],
            ];

            if (isset($destinationMap[$category])) {
                $query->whereIn('destination', $destinationMap[$category]);
            }
        }

        $sort = $request->query('sort', 'price_asc');

        match ($sort) {
            'price_desc' => $query->orderByDesc('price_adult'),
            'newest'     => $query->orderByDesc('created_at'),
            default      => $query->orderBy('price_adult'),
        };

        $packages = $query->get();

        return view('packages.index', compact('packages', 'category', 'destination', 'sort'));
    }

    public function show(string $slug): View
    {
        $package = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('packages.show', compact('package'));
    }

    public function downloadPdf(string $slug)
    {
        $package = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $pdf = Pdf::loadView('packages.pdf', compact('package'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'DejaVu Sans',
            ]);

        $filename = 'HappyJourney-' . $package->slug . '-itinerary.pdf';

        return $pdf->download($filename);
    }
}
