<?php

namespace Database\Seeders;

use App\Models\BlogArticle;
use App\Models\Testimonial;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HappyJourneySeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------------------------------------------------
        // TOUR PACKAGES
        // -----------------------------------------------------------------------
        TourPackage::truncate();

        $packages = [
            [
                'slug'         => '6d-shocking-sale-korea',
                'name'         => '6D SHOCKING SALE KOREA (ONEDAY FREE LEISURE)',
                'destination'  => 'Korea',
                'category'     => 'asia',
                'duration'     => '6 Hari',
                'airline'      => 'Korean Airlines (Premium Economy)',
                'price_adult'  => 10999000,
                'price_child'  => 10499000,
                'price_single_supplement' => 5000000,
                'price_infant' => 4000000,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => [
                    '2026-04-06','2026-04-16','2026-04-23',
                    '2026-05-01','2026-05-06','2026-05-22',
                    '2026-06-04','2026-07-09','2026-07-23',
                    '2026-08-06','2026-08-14','2026-08-27',
                    '2026-09-10','2026-09-24',
                ],
                'highlights' => [
                    'Nami Island','Starfield Library','Kimchi & Kimbap Making',
                    'Hanbok Wearing','Namsan Seoul Tower','Gyeongbokgung Palace',
                    'Hongdae Street','Myeongdong Shopping',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Incheon','description'=>'Assembly di Bandara Soekarno-Hatta Terminal 3, penerbangan malam dengan makan di pesawat.'],
                    ['day'=>2,'title'=>'Incheon - Nami Island - Seoul','description'=>'Tiba dengan pemandu berbahasa Indonesia. Kunjungan Nami Island (lokasi syuting Winter Sonata), Gangnam COEX Mall, Starfield Library, Patung Gangnam Style, Hongdae Street. Check-in hotel bintang 3.'],
                    ['day'=>3,'title'=>'Seoul City Tour','description'=>'Gyeongbokgung Palace, Museum Rakyat Nasional, Blue House (foto dari luar), Masjid Itaewon, Jalan Noksapyeong, pengalaman membuat kimbap dan memakai hanbok, Insadong Antique Street, Dongdaemun Shopping.'],
                    ['day'=>4,'title'=>'Seoul City Tour','description'=>'National Ginseng Museum, Healthcare Shop (Red Pine Tree), Duty Free, Han River Park, K-Cosmetic shopping, Myeongdong Street belanja bebas. Sarapan sudah termasuk.'],
                    ['day'=>5,'title'=>'Seoul Free Day (Leisure)','description'=>'Tidak ada kegiatan terjadwal, transportasi, pemandu, atau tour leader. Optional: Beauty Clinic Consultation atau Lotte World Theme Park (USD 100/orang).'],
                    ['day'=>6,'title'=>'Seoul - Jakarta','description'=>'Check-out hotel, belanja di supermarket lokal, sarapan udon Korea, transfer ke bandara untuk penerbangan pulang.'],
                ],
                'inclusions' => [
                    'Tiket internasional Korean Airlines Jakarta-Incheon (economy, termasuk pajak)',
                    'Bagasi sesuai ketentuan maskapai (biasanya 23kg)',
                    'Hotel bintang 3 (twin/triple room)',
                    'Bus wisata dan tiket masuk objek wisata',
                    'Makan sesuai jadwal itinerary',
                    'Air mineral botol harian',
                    'Pendampingan tour leader',
                    'Travel kit (name tag koper)',
                    'Asuransi perjalanan (usia s/d 69 tahun)',
                ],
                'exclusions' => [
                    'Visa Korea Grup: Rp 500.000 (atau visa individu jika tidak memenuhi syarat: Rp 1.150.000)',
                    'Tips (pemandu, driver, porter): ±Rp 800.000/orang',
                    'Fasilitas hotel (mini bar, laundry, telepon, kelebihan bagasi)',
                    'Tes COVID jika diperlukan',
                    'Optional: SIM card Korea',
                ],
                'image'       => '/images/packages/korea-6d-shocking-sale.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '7d-lebaran-busan-seoul',
                'name'         => '7D LEBARAN SALE BUSAN SEOUL',
                'destination'  => 'Korea',
                'category'     => 'asia',
                'duration'     => '7 Hari',
                'airline'      => 'Malaysia Airlines',
                'price_adult'  => 17590000,
                'price_child'  => 17590000,
                'price_single_supplement' => 5000000,
                'price_infant' => 4750000,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-18'],
                'highlights' => [
                    'Haedong Yonggungsa Temple','Oryukdo Skywalk','Jagalchi Market',
                    'Gyeongbok Palace','Gamcheon Culture Village','N Seoul Tower','Myeongdong',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Incheon (via Kuala Lumpur)','description'=>'Penerbangan malam transit Kuala Lumpur.'],
                    ['day'=>2,'title'=>'Incheon - Busan','description'=>'Tiba Incheon, perjalanan ke Busan. Kunjungi Oryukdo Skywalk dan Kuil Haedong Yonggungsa. Malam: melihat Jembatan Gwangan.'],
                    ['day'=>3,'title'=>'Busan City Tour','description'=>'Kukje Market, BIFF Street, Jagalchi Market, Gamcheon Culture Village.'],
                    ['day'=>4,'title'=>'Busan - Seoul','description'=>'Perjalanan ke Seoul. Ginseng Museum, K-Cosmetic Shop, Blue House, Gyeongbok Palace, belanja di Dongdaemun.'],
                    ['day'=>5,'title'=>'Seoul City Tour','description'=>'N-Seoul Tower, Love & Lock, Masjid Itaewon, Jalan Noksapyeong, Duty Free Shop, street food Myeongdong.'],
                    ['day'=>6,'title'=>'Seoul - Kuala Lumpur','description'=>'Belanja supermarket lokal, penerbangan ke Kuala Lumpur, waktu bebas di Bukit Bintang.'],
                    ['day'=>7,'title'=>'Kuala Lumpur - Jakarta','description'=>'Penerbangan pulang ke Jakarta.'],
                ],
                'inclusions' => [
                    'Tiket internasional Jakarta-Incheon dengan pajak',
                    'Bagasi sesuai ketentuan maskapai',
                    'Hotel bintang 3 (twin/triple)',
                    'Bus wisata dan tiket masuk',
                    'Makan sesuai itinerary',
                    'Air mineral harian',
                    'Tour leader',
                    'Travel kit',
                    'Asuransi perjalanan (s/d 69 tahun)',
                ],
                'exclusions' => [
                    'Visa Korea Grup: Rp 500.000 / Individu: Rp 1.300.000',
                    'Tips total: Rp 850.000',
                    'Fasilitas hotel, porter',
                    'PCR/rapid test',
                    'Optional: SIM card Korea',
                ],
                'image'       => '/images/packages/korea-7d-busan-seoul.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '7d-super-sale-blossom-busan-seoul',
                'name'         => '7D SUPER SALE BLOSSOM LEBARAN BUSAN SEOUL',
                'destination'  => 'Korea',
                'category'     => 'asia',
                'duration'     => '7 Hari',
                'airline'      => null,
                'price_adult'  => 15990000,
                'price_child'  => null,
                'price_single_supplement' => 5000000,
                'price_infant' => null,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-25','2026-04-02'],
                'highlights' => [
                    'Haedong Yonggungsa','Haeundae Beach Train','Lotte Tower',
                    'Jagalchi Market','Starfield Library','Gwangmyeong Cave',
                    'Hanbok Wearing di Gyeongbok Palace',
                ],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/packages/korea-7d-busan-seoul.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '7d-japan-golden-route',
                'name'         => '7D SHOCKING SALE GOLDEN ROUTE JAPAN + SHIRAKAWAGO',
                'destination'  => 'Jepang',
                'category'     => 'asia',
                'duration'     => '7 Hari',
                'airline'      => null,
                'price_adult'  => 13990000,
                'price_child'  => null,
                'price_single_supplement' => 4500000,
                'price_infant' => null,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-04-10','2026-04-17','2026-05-02'],
                'highlights' => [
                    'Shirakawago','Mt. Fuji','Takayama Old Town',
                    'Arashiyama Sengen Park','Kiyomizu Temple','Nara Deer Park','Ueno Park',
                ],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/packages/japan-7d-golden-route.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '7d-japan-sakura-golden-route',
                'name'         => '7D LEBARAN JAPAN BEST OF SAKURA SALE GOLDEN ROUTE WITH SHIRAKAWAGO',
                'destination'  => 'Jepang',
                'category'     => 'asia',
                'duration'     => '7 Hari',
                'airline'      => null,
                'price_adult'  => 15990000,
                'price_child'  => null,
                'price_single_supplement' => 4500000,
                'price_infant' => null,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-27','2026-04-03'],
                'highlights' => [
                    'Sakura Spot','Mt. Fuji','Arashiyama Sengen Park',
                    'Kiyomizu Temple','Nara Deer Park','Ueno Park','Shirakawago',
                ],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/packages/japan-7d-sakura.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '7d-japan-osaka-kyoto',
                'name'         => '7D CRAZY SALE LEBARAN JAPAN OSAKA KYOTO',
                'destination'  => 'Jepang',
                'category'     => 'asia',
                'duration'     => '7 Hari',
                'airline'      => null,
                'price_adult'  => 12990000,
                'price_child'  => null,
                'price_single_supplement' => 4500000,
                'price_infant' => null,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-04-05','2026-04-12'],
                'highlights' => ['Osaka','Nara','Kyoto'],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/packages/japan-7d-osaka-kyoto.jpg',
                'is_featured' => false,
                'is_active'   => true,
            ],
            [
                'slug'         => '8d-china-shanghai-beijing',
                'name'         => '8D LEBARAN CHINA POPULAR SHANGHAI + BEIJING',
                'destination'  => 'China',
                'category'     => 'asia',
                'duration'     => '8 Hari / 7 Malam',
                'airline'      => 'Singapore Airlines',
                'price_adult'  => 21990000,
                'price_child'  => 20990000,
                'price_single_supplement' => 4750000,
                'price_infant' => 4750000,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-15'],
                'highlights' => [
                    'The Bund','Shanghai TV Tower','Wuzhen Water Town','West Lake Hangzhou',
                    'Great Wall (Juyongguan)','Forbidden City','Tian An Men Square',
                    'Wangfujing Street','Peking Duck Dinner',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Shanghai','description'=>'Berangkat dari Soekarno-Hatta Terminal 3, tiba Shanghai. Kunjungi The Bund, LV Cruise Area, dan Starbucks Reserve Roastery terbesar di dunia. Menginap hotel bintang 4.'],
                    ['day'=>2,'title'=>'Shanghai City Tour','description'=>'Xin Tian Di, Tian Zi Fang arts district, foto di Shanghai TV Tower, Zhang Yuan, belanja di Nanjing Road. Menginap hotel bintang 4.'],
                    ['day'=>3,'title'=>'Shanghai - Wuzhen - Hangzhou','description'=>'Naik perahu tradisional menyusuri kanal Wuzhen, lanjut ke Hangzhou. Berkeliling West Lake dengan kapal, kunjungi Kuil Yue Fei. Menginap hotel bintang 4.'],
                    ['day'=>4,'title'=>'Hangzhou - Suzhou','description'=>'Kunjungi Tea Garden, lanjut ke Suzhou. Couple\'s Retreat Garden, Jinji Lake, belanja di Guanqian Street. Menginap hotel bintang 4.'],
                    ['day'=>5,'title'=>'Suzhou - Beijing (Kereta Cepat)','description'=>'Kunjungi Silk Factory, perjalanan ke Beijing menggunakan Bullet Train. Menginap hotel bintang 4.'],
                    ['day'=>6,'title'=>'Beijing City Tour','description'=>'Temple of Heaven, Tian An Men Square, belanja di Wangfujing Street. Menginap hotel bintang 4.'],
                    ['day'=>7,'title'=>'Beijing - Great Wall','description'=>'Great Wall Juyongguan, foto di Bird\'s Nest & Water Cube, Silk Market, makan malam Peking Duck. Transfer ke bandara malam hari.'],
                    ['day'=>8,'title'=>'Beijing - Jakarta','description'=>'Penerbangan pulang via Singapore Airlines.'],
                ],
                'inclusions' => [
                    'Tiket internasional Singapore Airlines economy (termasuk pajak internasional)',
                    'Bagasi 30 kg',
                    'Hotel bintang 4 (twin/triple room)',
                    'Bus wisata dan tiket masuk objek wisata',
                    'Makan sesuai itinerary',
                    'Air mineral harian',
                    'Tour leader',
                    'Travel kit',
                    'Asuransi perjalanan',
                ],
                'exclusions' => [
                    'Visa China: Rp 1.400.000',
                    'Tips (tour leader, local guide, driver): Rp 900.000/orang',
                    'Fasilitas hotel (porter, minibar, laundry)',
                    'PCR/rapid test',
                    'Optional: SIM card China',
                ],
                'image'       => '/images/packages/china-8d-shanghai-beijing.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '5d-best-deal-hainan',
                'name'         => '5D BEST DEAL HAINAN',
                'destination'  => 'China',
                'category'     => 'asia',
                'duration'     => '5 Hari',
                'airline'      => 'Lion Airlines (Charter Flight)',
                'price_adult'  => 4690000,
                'price_child'  => 4490000,
                'price_single_supplement' => 2600000,
                'price_infant' => null,
                'deposit'      => null,
                'min_participants' => 15,
                'departure_dates' => [
                    '2026-01-05','2026-01-12','2026-01-19','2026-01-26',
                    '2026-02-02','2026-03-09','2026-03-16','2026-03-23',
                    '2026-03-30','2026-04-06','2026-04-13','2026-04-20',
                    '2026-04-27','2026-05-04','2026-05-11','2026-05-18',
                    '2026-05-25','2026-06-01','2026-06-08','2026-06-15','2026-06-22',
                ],
                'highlights' => [
                    'Daxiao Dongtian',
                    'Nanshan Buddhism Cultural Zone (Patung Kwan Yin 108 meter)',
                    'Yalong Bay Beach',
                    'Lembah Mawar Asia',
                    'Phoenix Ridge (cable car 360°)',
                    'Dadong Sea',
                    'The End of The Earth (Tianya Haijiao)',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Sanya','description'=>'Penerbangan Lion Air JT2781 (16:50-22:05), check-in hotel.'],
                    ['day'=>2,'title'=>'Daxiao Dongtian - Nanshan','description'=>'Daxiao Dongtian, Nanshan Buddhism Cultural Zone dengan patung Kwan Yin setinggi 108 meter, kunjungan toko lateks. Termasuk sarapan & makan siang.'],
                    ['day'=>3,'title'=>'Yalong Bay - Phoenix Ridge','description'=>'Yalong Bay Beach, lembah mawar terbesar di Asia, Phoenix Ridge dengan cable car 360°, toko fish oil. Termasuk sarapan & makan siang.'],
                    ['day'=>4,'title'=>'Dadong Sea - Tianya Haijiao - Jakarta','description'=>'Dadonghai Tourism Zone, The End of The Earth, toko herbal China. Penerbangan pulang SYX-CGK JT2780 (23:05-02:20+1).'],
                    ['day'=>5,'title'=>'Tiba Jakarta','description'=>'Tiba di Jakarta, tour selesai.'],
                ],
                'inclusions' => [
                    'Tiket pesawat PP Lion Air Charter (economy)',
                    'Airport tax & fuel surcharge internasional',
                    'Hotel (twin sharing)',
                    'Wisata, transportasi, makan sesuai jadwal',
                    'Bagasi 20 kg',
                    'Air mineral harian',
                    'Asuransi perjalanan grup (s/d 69 tahun)',
                    '3 wajib kunjungan toko',
                    'Pendampingan tour leader Indonesia',
                ],
                'exclusions' => [
                    'Dokumen perjalanan (paspor, izin)',
                    'Pengeluaran pribadi',
                    'Kelebihan bagasi',
                    'Suplemen kamar single',
                    'Aktivitas opsional (RMB 150-350/aktivitas)',
                    'Tips tour leader/pemandu: Rp 550.000/orang',
                    'PCR/rapid test',
                    'PPN 1.1%',
                ],
                'image'       => '/images/packages/china-5d-hainan.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '5d-vietnam-hanoi-sapa-halong',
                'name'         => '5D LEBARAN EXPRESS HANOI SAPA HALONG BAY',
                'destination'  => 'Vietnam',
                'category'     => 'asia',
                'duration'     => '5 Hari',
                'airline'      => 'Vietnam Airlines',
                'price_adult'  => 12990000,
                'price_child'  => 12590000,
                'price_single_supplement' => 3200000,
                'price_infant' => 4000000,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-16'],
                'highlights' => [
                    'Halong Bay Cruise','Gua Thien Cung','Cat Cat Village (budaya H\'Mong)',
                    'Gereja Sapa','Gunung Fansipan (2.800m)','Ho Chi Minh Complex',
                    'One Pillar Pagoda','Train Street Hanoi',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Hanoi','description'=>'Berangkat dari Soekarno-Hatta Terminal 3 via Vietnam Airlines, penerbangan malam.'],
                    ['day'=>2,'title'=>'Hanoi - Halong Bay','description'=>'Tiba Hanoi (05:50), perjalanan ke Halong Bay, cruise dengan kunjungan gua (Thien Cung, Dau Go Grotto), kembali ke Hanoi Old Quarter. Menginap: First Eden Hotel.'],
                    ['day'=>3,'title'=>'Hanoi - Sapa','description'=>'Perjalanan ke Sapa, kunjungi Cat Cat Village (budaya H\'Mong), Gereja Sapa, pasar minoritas. Menginap: Sapa Panorama Hotel.'],
                    ['day'=>4,'title'=>'Fansipan Mountain','description'=>'Naik cable car ke puncak Gunung Fansipan (2.800m), kompleks pagoda, optional trekking, makan siang buffet, kembali ke Hanoi. Menginap: First Eden Hotel.'],
                    ['day'=>5,'title'=>'Hanoi City Tour - Jakarta','description'=>'Katedral St. Joseph, Kompleks Ho Chi Minh, One Pillar Pagoda, Train Street, keberangkatan malam.'],
                ],
                'inclusions' => [
                    'Tiket internasional dengan pajak',
                    'Bagasi sesuai ketentuan maskapai',
                    'Hotel bintang 3 (twin/triple)',
                    'Bus wisata dan tiket masuk',
                    'Makan sesuai itinerary',
                    'Air mineral harian',
                    'Tour leader',
                    'Travel kit',
                    'Asuransi perjalanan (s/d 84 tahun)',
                ],
                'exclusions' => [
                    'Tips tour leader/pemandu/driver',
                    'Fasilitas hotel (porter, minibar, laundry)',
                    'PCR/rapid test',
                    'Optional: SIM card',
                ],
                'image'       => '/images/blog/vietnam-halong-sapa.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '8d-vietnam-full',
                'name'         => '8D PEAK LEBARAN JOURNEY VIETNAM HANOI SAPA DANANG BA NA HILL & GOLDEN BRIDGE – HOI AN',
                'destination'  => 'Vietnam',
                'category'     => 'asia',
                'duration'     => '8 Hari',
                'airline'      => null,
                'price_adult'  => 17990000,
                'price_child'  => null,
                'price_single_supplement' => 4000000,
                'price_infant' => null,
                'deposit'      => 6000000,
                'min_participants' => 20,
                'departure_dates' => ['2026-03-20','2026-04-08'],
                'highlights' => ['Hanoi','Ha Long Island','Danang','Hoi An','Bana Golden Bridge','Saigon'],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/blog/vietnam-halong-sapa.jpg',
                'is_featured' => false,
                'is_active'   => true,
            ],
            [
                'slug'         => '9d-west-europe-7countries',
                'name'         => '9D WEST EUROPE TITISEE SCAFFHAUSEN + KEUKENHOF LEBARAN (7 NEGARA)',
                'destination'  => 'Eropa',
                'category'     => 'eropa',
                'duration'     => '9 Hari',
                'airline'      => 'Qatar Airways (Economy)',
                'price_adult'  => 31490000,
                'price_child'  => 30490000,
                'price_single_supplement' => 10000000,
                'price_infant' => null,
                'deposit'      => 8000000,
                'min_participants' => 25,
                'departure_dates' => ['2026-03-19'],
                'highlights' => [
                    'Menara Eiffel Paris','La Vallée Village (shopping)','Keukenhof Tulip Gardens',
                    'Volendam','Katedral Cologne','Rhine Falls Schaffhausen',
                    'Danau Titisee','Lucerne (Chapel Bridge)','Milan',
                ],
                'itinerary' => [
                    ['day'=>1,'title'=>'Jakarta - Paris (via Doha)','description'=>'Penerbangan ke Paris transit Doha.'],
                    ['day'=>2,'title'=>'Paris','description'=>'City tour Paris, waktu bebas di La Vallée Village shopping outlet.'],
                    ['day'=>3,'title'=>'Brussel - Amsterdam','description'=>'Orientasi Brussel, perjalanan ke Amsterdam.'],
                    ['day'=>4,'title'=>'Amsterdam - Keukenhof - Düsseldorf','description'=>'Foto di Amsterdam, Keukenhof Gardens, Desa Volendam, menginap Düsseldorf.'],
                    ['day'=>5,'title'=>'Cologne - Luksemburg - Colmar','description'=>'Katedral Cologne, objek wisata Luksemburg, menginap Colmar.'],
                    ['day'=>6,'title'=>'Titisee - Rhine Falls - Zurich','description'=>'Danau Titisee, toko Cuckoo Clock, Rhine Falls, foto Zurich.'],
                    ['day'=>7,'title'=>'Engelberg - Milan','description'=>'Lion Monument, Chapel Bridge Lucerne, menginap Milan.'],
                    ['day'=>8,'title'=>'Milan - Jakarta (via Doha)','description'=>'City tour Milan, penerbangan pulang ke Jakarta via Doha.'],
                    ['day'=>9,'title'=>'Tiba Jakarta','description'=>'Tiba di Jakarta.'],
                ],
                'inclusions' => [
                    'Tiket internasional Jakarta-Paris-Milan-Jakarta',
                    '6 malam akomodasi hotel bintang 4 (twin sharing)',
                    'Bus AC',
                    'Tiket masuk objek wisata',
                ],
                'exclusions' => [
                    'Visa Schengen: Rp 3.850.000/orang (Non Refund)',
                    'Pajak internasional: Rp 3.000.000',
                    'Tips tour leader/driver & city tax: Rp 2.800.000',
                    'Asuransi perjalanan wajib: Rp 650.000',
                    'Pengeluaran pribadi & kelebihan bagasi',
                ],
                'image'       => '/images/packages/europe-west.jpg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'slug'         => '9d-east-europe',
                'name'         => '9D EAST EUROPE PARNDORF + HALLSTATT SUPER SAVER (7 NEGARA)',
                'destination'  => 'Eropa',
                'category'     => 'eropa',
                'duration'     => '9 Hari',
                'airline'      => null,
                'price_adult'  => 28990000,
                'price_child'  => null,
                'price_single_supplement' => 9000000,
                'price_infant' => null,
                'deposit'      => 8000000,
                'min_participants' => 25,
                'departure_dates' => ['2026-04-15','2026-05-05'],
                'highlights' => [
                    'Gallery Lafayette','Menara Eiffel','Atomium Brussel',
                    'Vaduz Castle','Roermond Shopping',
                ],
                'itinerary' => [],
                'inclusions' => [],
                'exclusions' => [],
                'image'       => '/images/packages/europe-east.jpg',
                'is_featured' => false,
                'is_active'   => true,
            ],
        ];

        foreach ($packages as $data) {
            TourPackage::create($data);
        }

        // -----------------------------------------------------------------------
        // TESTIMONIALS  (from contohzai design)
        // -----------------------------------------------------------------------
        Testimonial::truncate();

        $testimonials = [
            [
                'name'       => 'Siti Rahayu',
                'location'   => 'Jakarta',
                'tour_name'  => 'Tour Jepang Sakura',
                'review'     => 'Pengalaman yang luar biasa! Tim Happy Journey sangat profesional dan helpful. Semua diatur dengan sempurna, dari akomodasi hingga transportasi. Pasti akan booking lagi!',
                'rating'     => 5,
                'date_label' => 'November 2024',
                'is_active'  => true,
            ],
            [
                'name'       => 'Budi Santoso',
                'location'   => 'Surabaya',
                'tour_name'  => 'Tour Korea Autumn',
                'review'     => 'Perjalanan ke Korea dengan Happy Journey sangat memuaskan. Tour guide berbahasa Indonesia sangat membantu dan ramah. Harga sangat kompetitif dengan kualitas premium.',
                'rating'     => 5,
                'date_label' => 'Oktober 2024',
                'is_active'  => true,
            ],
            [
                'name'       => 'Dewi Kartika',
                'location'   => 'Bandung',
                'tour_name'  => 'Tour Eropa Classic',
                'review'     => 'Impian liburan ke Eropa terwujud bersama Happy Journey! Itinerary sangat baik, hotel berbintang, dan pengalaman yang tak terlupakan. Highly recommended!',
                'rating'     => 5,
                'date_label' => 'September 2024',
                'is_active'  => true,
            ],
            [
                'name'       => 'Ahmad Fauzi',
                'location'   => 'Medan',
                'tour_name'  => 'Tour China Wonder',
                'review'     => 'Sensasi di Great Wall China dan Zhangjiajie memang luar biasa. Happy Journey mengatur semuanya dengan baik. Terima kasih untuk pengalaman yang indah!',
                'rating'     => 5,
                'date_label' => 'Agustus 2024',
                'is_active'  => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }

        // -----------------------------------------------------------------------
        // BLOG ARTICLES (all 11 from scraped data)
        // -----------------------------------------------------------------------
        BlogArticle::truncate();

        $articleImages = [
            'China'    => '/images/blog/china-zhangjiajie.jpg',
            'Vietnam'  => '/images/blog/vietnam-halong-sapa.jpg',
            'Jepang'   => '/images/blog/japan-city-fuji.jpg',
            'Inspirasi'=> '/images/blog/blog-04.jpg',
            'Corporate'=> '/images/packages/korea-6d-hanbok.jpg',
        ];

        $articles = [
            [
                'title'        => 'Fakta Unik Zhangjiajie & Chongqing: Dua Destinasi Spektakuler yang Wajib Masuk Bucket List',
                'excerpt'      => 'Jika Anda mencari destinasi liburan yang menawarkan perpaduan antara alam spektakuler, kota futuristik, sejarah, dan kuliner khas, Zhangjiajie dan Chongqing adalah dua tempat di China yang wajib dikunjungi.',
                'category'     => 'China',
                'read_time'    => '5 menit',
                'published_at' => '2025-11-18',
                'content'      => '<p>Zhangjiajie adalah taman nasional pertama di China yang terletak di Provinsi Hunan. Kawasan ini terkenal dengan pilar-pilar batu sandstone setinggi ratusan meter yang menjulang bak pulau di atas awan — pemandangan inilah yang menginspirasi dunia Avatar karya James Cameron. Selain itu, Jembatan Kaca Zhangjiajie yang membentang sepanjang 430 meter di ketinggian 300 meter adalah salah satu jembatan kaca terpanjang di dunia.</p>

<h3>Pesona Alam Zhangjiajie</h3>
<p>Di dalam taman nasional, Anda dapat menjelajahi Tianmen Mountain menggunakan cable car terpanjang di dunia sejauh 7,5 km. Di puncaknya terdapat "Gerbang Surga" — sebuah lubang alami di tebing setinggi 131 meter yang menakjubkan. Jangan lewatkan juga Yellow Dragon Cave, salah satu gua bawah tanah terbesar di Asia dengan formasi stalaktit dan stalagmit yang spektakuler.</p>

<h3>Chongqing: Kota di Atas Bukit</h3>
<p>Chongqing adalah megakota yang berdiri di atas dua sungai besar — Yangtze dan Jialing. Berbeda dari kota-kota China lainnya, Chongqing dibangun di atas terrain berbukit sehingga dijuluki "Mountain City". Beberapa hal wajib dilakukan di sini:</p>
<ul>
<li>Menikmati hot pot otentik Chongqing yang pedas dan menggugah selera</li>
<li>Menjelajahi Ciqikou Ancient Town, desa berusia ratusan tahun di tengah kota modern</li>
<li>Menyaksikan pemandangan malam kota dari Nanshan Observation Deck</li>
<li>Mengunjungi Hongya Cave, kompleks rumah tradisional bertingkat di tepi sungai</li>
</ul>
<p>Kombinasi Zhangjiajie dan Chongqing menawarkan pengalaman yang tak tergantikan — dari keajaiban alam hingga kehidupan kota yang dinamis. Happy Journey menyediakan paket tour ke China yang mencakup kedua destinasi spektakuler ini dengan panduan berbahasa Indonesia yang berpengalaman.</p>',
            ],
            [
                'title'        => 'Liburan ke Vietnam 2026: Destinasi Indah, Budget Bersahabat, Pengalaman Tak Terlupakan',
                'excerpt'      => 'Vietnam menjadi salah satu destinasi favorit untuk liburan. Pemandangan memukau, kuliner lezat, budaya kaya, dan harga ramah kantong membuat negara ini semakin populer.',
                'category'     => 'Vietnam',
                'read_time'    => '6 menit',
                'published_at' => '2025-11-18',
                'content'      => '<p>Vietnam adalah salah satu permata tersembunyi di Asia Tenggara yang menawarkan keanekaragaman luar biasa — dari teluk berbatu kapur di utara hingga pantai tropis di selatan, dari kota kolonial Prancis di tengah hingga kota metropolitan yang dinamis. Pada 2026, Vietnam semakin mempermudah kunjungan wisatawan asing dengan kebijakan bebas visa yang diperluas.</p>

<h3>Destinasi Utama yang Wajib Dikunjungi</h3>
<p>Halong Bay di Vietnam Utara adalah UNESCO World Heritage Site dengan lebih dari 1.600 pulau dan pulau kecil yang membentuk pemandangan seperti lukisan. Cruise semalaman di Halong Bay adalah pengalaman yang tak terlupakan. Di Sapa, Anda dapat menjelajahi sawah berterasering yang memukau dan mengenal budaya suku H\'Mong dan Dao yang masih terjaga keasliannya.</p>

<h3>Hoi An dan Da Nang: Pesona Tengah Vietnam</h3>
<p>Hoi An Ancient Town adalah kota kuno yang dipreservasi dengan sempurna, dipenuhi rumah-rumah bercat kuning, lentera warna-warni, dan suasana romantis. Da Nang menawarkan pantai My Khe yang indah serta Golden Bridge di Ba Na Hills — jembatan berbentuk tangan raksasa yang sedang viral di media sosial seluruh dunia.</p>
<ul>
<li>Halong Bay: Cruise di antara ribuan pulau kapur yang menakjubkan</li>
<li>Sapa: Trekking di desa suku pegunungan dan menaiki cable car ke Fansipan</li>
<li>Hoi An: Bersepeda di kota kuno bercahaya lentera saat malam hari</li>
<li>Da Nang: Menikmati sunrise di pantai dan mengunjungi Golden Bridge</li>
</ul>
<p>Dengan biaya hidup yang relatif terjangkau, kuliner yang lezat, dan masyarakat yang ramah, Vietnam adalah pilihan sempurna untuk liburan 2026 yang berkesan tanpa menguras kantong.</p>',
            ],
            [
                'title'        => 'Fakta Unik Tentang Jepang yang Bikin Kamu Semakin Pengen Liburan ke Negeri Sakura',
                'excerpt'      => 'Jepang bukan cuma negara dengan teknologi canggih dan budaya yang kuat. Di balik modernitasnya, ada banyak hal unik yang bikin siapa pun jatuh cinta.',
                'category'     => 'Jepang',
                'read_time'    => '7 menit',
                'published_at' => '2025-10-24',
                'content'      => '<p>Jepang adalah negara yang selalu berhasil mengejutkan setiap pengunjungnya. Di balik teknologi mutakhir dan gedung-gedung pencakar langit, tersimpan tradisi berusia ribuan tahun yang masih dijaga dengan penuh kebanggaan. Tidak heran jika Jepang selalu masuk dalam daftar destinasi wisata paling populer di dunia.</p>

<h3>Fakta-Fakta Unik yang Jarang Diketahui</h3>
<p>Jepang memiliki lebih dari 6.800 pulau, meski hanya sekitar 340 yang berpenghuni. Negara ini juga memiliki lebih banyak mesin vending dibandingkan jumlah penduduk di beberapa negara kecil — sekitar 5,5 juta mesin yang menjual segala sesuatu dari minuman dingin hingga payung darurat. Di Tokyo, sistem kereta bawah tanah beroperasi dengan ketepatan waktu yang luar biasa, rata-rata keterlambatan hanya 18 detik per tahun.</p>

<h3>Budaya yang Memukau</h3>
<p>Konsep "Omotenashi" atau keramahtamahan tulus tanpa mengharapkan imbalan adalah jiwa dari pelayanan di Jepang. Setiap interaksi, dari kasir minimarket hingga staf hotel berbintang, dilakukan dengan penuh kesungguhan dan rasa hormat. Beberapa hal unik yang bisa Anda temukan:</p>
<ul>
<li>Toilet canggih dengan pemanas dudukan dan fitur musik di mana-mana</li>
<li>Budaya "hanami" — piknik sambil menikmati bunga sakura bermekaran</li>
<li>Capsule hotel dengan desain futuristik dan harga terjangkau</li>
<li>Pasar Tsukiji di Tokyo tempat lelang tuna raksasa setiap pagi</li>
</ul>
<p>Dari Hokkaido di utara hingga Okinawa di selatan, setiap prefektur Jepang menawarkan keunikannya sendiri. Happy Journey siap mengantarkan Anda mengeksplorasi keajaiban Negeri Sakura ini dengan paket tour yang telah dirancang dengan cermat.</p>',
            ],
            [
                'title'        => 'Empat Musim di Jepang: Setiap Musim Punya Cerita, Setiap Sudut Punya Pesonanya',
                'excerpt'      => 'Negeri Sakura ini punya empat musim yang benar-benar membuat wisatawan ingin kembali berkali-kali.',
                'category'     => 'Jepang',
                'read_time'    => '8 menit',
                'published_at' => '2025-10-24',
                'content'      => '<p>Salah satu keistimewaan Jepang dibanding negara Asia lainnya adalah keindahan pergantian empat musim yang begitu dramatis dan cantik. Setiap musim membawa karakter tersendiri yang mengubah wajah lanskap Jepang menjadi pemandangan berbeda yang sama-sama menakjubkan.</p>

<h3>Musim Semi (Maret - Mei): Mekar Bersama Sakura</h3>
<p>Musim semi adalah favorit sebagian besar wisatawan. Bunga sakura mulai bermekaran dari akhir Maret hingga awal April, mengubah taman-taman, tepi sungai, dan jalan-jalan kota menjadi kanvas warna merah muda. Hanami — tradisi piknik di bawah pohon sakura — adalah pengalaman budaya yang wajib dicoba. Setelah sakura, giliran bunga wisteria ungu di Kawachi Fuji Gardens yang menjadi pemandangan paling viral di media sosial.</p>

<h3>Musim Panas (Juni - Agustus): Festival dan Pantai</h3>
<p>Musim panas identik dengan festival matsuri yang meriah di seluruh penjuru Jepang. Festival kembang api (hanabi) menerangi langit malam dengan cahaya yang memukau. Ini juga saat terbaik untuk mendaki Gunung Fuji yang hanya dibuka untuk pendakian selama musim panas.</p>

<h3>Musim Gugur (September - November): Lautan Daun Merah</h3>
<p>Momiji atau dedaunan gugur berwarna merah, oranye, dan kuning emas menciptakan pemandangan yang tak kalah memukau dari sakura. Kuil-kuil di Kyoto dan Nara menjadi semakin magis saat dibingkai dedaunan berwarna-warni.</p>

<h3>Musim Dingin (Desember - Februari): Salju dan Ketenangan</h3>
<ul>
<li>Festival Salju Sapporo dengan patung es dan salju raksasa yang menakjubkan</li>
<li>Sumber air panas (onsen) di tengah hutan bersalju — pengalaman paling menenangkan</li>
<li>Pemandangan Gunung Fuji berlatar salju putih yang sempurna untuk fotografi</li>
<li>Illuminasi Natal di berbagai kota dengan jutaan lampu warna-warni</li>
</ul>
<p>Kapan pun Anda berkunjung ke Jepang, selalu ada keindahan yang menunggu. Happy Journey menyediakan paket tour Jepang sepanjang tahun, termasuk paket khusus musim sakura yang selalu menjadi favorit.</p>',
            ],
            [
                'title'        => 'Saatnya Melihat Luasnya Dunia Luar',
                'excerpt'      => 'Mungkin inilah saatnya untuk keluar dari zona nyaman dan melihat luasnya dunia luar setelah merasa penat dengan rutinitas harian.',
                'category'     => 'Inspirasi',
                'read_time'    => '4 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Pernahkah Anda merasakan hari-hari terasa begitu monoton — bangun pagi, bekerja, pulang, tidur, dan berulang lagi? Rutinitas memang memberikan stabilitas, namun terlalu lama terkurung di zona nyaman justru bisa membunuh semangat dan kreativitas. Dunia di luar sana jauh lebih luas, beragam, dan indah dari yang bisa kita bayangkan dari balik meja kerja.</p>

<h3>Mengapa Perjalanan Itu Penting</h3>
<p>Bepergian bukan sekadar mengumpulkan foto untuk diunggah di media sosial. Setiap perjalanan adalah investasi untuk jiwa dan pikiran. Ketika kita melihat cara hidup orang di negeri lain, kita belajar untuk lebih bersyukur, lebih toleran, dan lebih terbuka terhadap perbedaan. Penelitian menunjukkan bahwa orang yang rutin bepergian memiliki tingkat stres lebih rendah dan kemampuan beradaptasi yang lebih baik.</p>

<h3>Mulai dari Langkah Kecil</h3>
<p>Tidak perlu langsung merencanakan perjalanan ke Eropa atau Amerika. Mulailah dengan destinasi yang lebih dekat dan terjangkau. Asia Tenggara menawarkan keanekaragaman budaya dan alam yang luar biasa dengan biaya yang relatif bersahabat. Vietnam, Thailand, Malaysia, atau Jepang bisa menjadi awal yang sempurna untuk memperluas wawasan Anda.</p>
<ul>
<li>Tentukan satu destinasi impian dan mulai menabung hari ini</li>
<li>Bergabunglah dengan open trip untuk pengalaman pertama yang lebih terjangkau</li>
<li>Manfaatkan long weekend dan cuti tahunan untuk perjalanan singkat</li>
<li>Dokumentasikan perjalanan Anda sebagai kenangan yang akan selalu diingat</li>
</ul>
<p>Happy Journey hadir untuk memastikan perjalanan pertama Anda — atau perjalanan selanjutnya — menjadi pengalaman yang tak terlupakan. Dengan tim yang berpengalaman dan paket yang beragam, kami siap mewujudkan impian perjalanan Anda.</p>',
            ],
            [
                'title'        => 'Rasakan Travel Nyaman Bersama Happy Journey',
                'excerpt'      => 'Rencana liburan justru berubah jadi sumber stres baru dengan itinerary yang berantakan dan penginapan yang mengecewakan? Bersama kami, tidak.',
                'category'     => 'Inspirasi',
                'read_time'    => '4 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Liburan seharusnya menjadi momen paling membahagiakan, bukan malah menjadi sumber stres baru. Sayangnya, banyak orang yang mengalami pengalaman buruk — hotel tidak sesuai ekspektasi, jadwal yang terlalu padat, pemandu yang tidak profesional, atau biaya tersembunyi yang tiba-tiba muncul. Happy Journey hadir untuk mengubah paradigma tersebut.</p>

<h3>Standar Pelayanan Kami</h3>
<p>Setiap paket tour Happy Journey dirancang dengan mempertimbangkan kenyamanan dan kepuasan peserta sebagai prioritas utama. Mulai dari pemilihan hotel berbintang yang telah diverifikasi, itinerary yang seimbang antara aktivitas dan waktu istirahat, hingga pemandu tour berbahasa Indonesia yang ramah dan berpengetahuan luas tentang destinasi.</p>

<h3>Transparansi Biaya</h3>
<p>Tidak ada biaya tersembunyi. Setiap detail paket — dari tiket pesawat, hotel, transportasi, tiket masuk, hingga makan — tertera jelas dalam informasi paket kami. Anda bisa merencanakan anggaran dengan pasti sejak awal tanpa khawatir adanya kejutan yang tidak menyenangkan di tengah perjalanan.</p>
<ul>
<li>Pemandu tour profesional berbahasa Indonesia di setiap destinasi</li>
<li>Hotel bintang 3-4 yang telah terverifikasi kualitas dan kebersihannya</li>
<li>Bus wisata ber-AC dengan kapasitas yang memadai</li>
<li>Asuransi perjalanan untuk ketenangan pikiran selama bepergian</li>
</ul>
<p>Lebih dari 10.000 wisatawan telah mempercayakan perjalanan mereka kepada Happy Journey sejak kami berdiri. Kepercayaan itu yang mendorong kami untuk terus meningkatkan kualitas layanan dan memberikan pengalaman terbaik bagi setiap traveler.</p>',
            ],
            [
                'title'        => 'Travel Nyaman Ramah Di Kantong',
                'excerpt'      => 'Anda bisa jalan-jalan seru, nyaman, dan tetap hemat — karena semua orang berhak menikmati dunia tanpa menguras tabungan.',
                'category'     => 'Inspirasi',
                'read_time'    => '5 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Satu mitos yang masih banyak dipercaya adalah bahwa perjalanan internasional hanya bisa dinikmati oleh mereka yang memiliki kantong tebal. Padahal dengan perencanaan yang tepat dan memilih mitra travel yang terpercaya, liburan ke luar negeri bisa menjadi jauh lebih terjangkau dari perkiraan Anda.</p>

<h3>Strategi Hemat Tanpa Mengorbankan Kenyamanan</h3>
<p>Kuncinya adalah bergabung dengan grup tour. Dengan bergabung bersama 20-30 orang dalam satu paket, biaya transportasi, hotel, dan pemandu tour dapat dibagi sehingga biaya per orang menjadi jauh lebih terjangkau. Happy Journey menawarkan open trip reguler ke berbagai destinasi Asia yang bisa diikuti oleh siapa saja, termasuk solo traveler.</p>

<h3>Paket Spesial Happy Journey</h3>
<p>Kami secara rutin menawarkan program shocking sale dan early bird discount yang bisa memangkas harga paket hingga 20-30%. Dengan mendaftar lebih awal, Anda tidak hanya mendapatkan harga yang lebih baik, tetapi juga jaminan tempat di paket tour yang Anda inginkan.</p>
<ul>
<li>Open trip mulai Rp 4.690.000 untuk destinasi China (Hainan)</li>
<li>Paket Vietnam 5 hari tersedia dengan harga sangat kompetitif</li>
<li>Program cicilan tersedia untuk memudahkan pembayaran</li>
<li>Deposit awal yang terjangkau untuk mengamankan booking Anda</li>
</ul>
<p>Investasi terbaik adalah investasi untuk pengalaman dan kenangan. Dengan Happy Journey, setiap rupiah yang Anda keluarkan akan berubah menjadi momen berharga yang akan selalu diingat sepanjang hayat.</p>',
            ],
            [
                'title'        => 'You Only Live Once, Lihatlah Dunia!',
                'excerpt'      => 'Kita hanya hidup sekali, namun seringkali hidup habis dalam rutinitas kerja dan deadline, padahal dunia menyimpan jutaan keindahan.',
                'category'     => 'Inspirasi',
                'read_time'    => '3 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>YOLO — You Only Live Once. Frasa singkat ini terasa klise, namun mengandung kebenaran yang sering kita lupakan. Di tengah kesibukan mengejar karier, membayar cicilan, dan memenuhi ekspektasi orang lain, kita lupa bahwa waktu terus berjalan dan tidak akan pernah kembali. Apakah Anda ingin di akhir hayat menyesali tempat-tempat yang tidak sempat dikunjungi?</p>

<h3>Jangan Tunda Lagi</h3>
<p>Alasan "nanti saja" adalah pencuri terbesar impian perjalanan Anda. Selalu ada alasan untuk menunda: belum cukup tabungan, pekerjaan sedang sibuk, anak masih kecil, dan seterusnya. Namun kenyataannya, waktu yang tepat tidak akan datang dengan sendirinya — Anda harus menciptakannya.</p>

<h3>Mulai dengan Satu Langkah</h3>
<p>Tidak perlu menunggu kondisi sempurna. Mulailah dengan menetapkan satu destinasi impian, lalu hitung berapa yang perlu ditabung setiap bulan untuk mewujudkannya. Anda akan terkejut betapa dekat impian itu jika dipecah menjadi langkah-langkah kecil yang konsisten.</p>
<ul>
<li>Tetapkan destinasi impian Anda hari ini</li>
<li>Konsultasikan dengan Happy Journey untuk estimasi biaya yang tepat</li>
<li>Mulai menabung dengan target yang realistis</li>
<li>Booking lebih awal untuk harga terbaik</li>
</ul>
<p>Happy Journey percaya bahwa setiap orang berhak melihat keindahan dunia. Mari wujudkan impian perjalanan Anda bersama kami — karena hidup terlalu singkat untuk tidak dijelajahi.</p>',
            ],
            [
                'title'        => 'Travel Dengan Aman Melalui Agent',
                'excerpt'      => 'Travel aman tidak harus mahal dengan berbagai paket hemat, open trip, dan private trip yang dapat disesuaikan.',
                'category'     => 'Inspirasi',
                'read_time'    => '5 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Di era digital ini, banyak traveler yang mencoba merencanakan sendiri perjalanan mereka melalui berbagai platform online. Meski praktis, cara ini menyimpan berbagai risiko — mulai dari penginapan yang tidak sesuai deskripsi, masalah transportasi di negeri asing, hingga kesulitan komunikasi karena hambatan bahasa. Menggunakan jasa agen travel terpercaya adalah pilihan bijak yang memberikan ketenangan pikiran.</p>

<h3>Keunggulan Menggunakan Agen Travel</h3>
<p>Agen travel profesional seperti Happy Journey memiliki jaringan mitra yang telah terverifikasi di berbagai destinasi — hotel, transportasi, pemandu wisata lokal, hingga restoran halal. Pengalaman bertahun-tahun di industri ini memungkinkan kami untuk mengantisipasi dan menangani berbagai situasi tak terduga yang mungkin terjadi selama perjalanan.</p>

<h3>Keamanan yang Terjamin</h3>
<p>Setiap paket Happy Journey dilengkapi dengan asuransi perjalanan yang melindungi Anda dari berbagai risiko seperti sakit mendadak, kecelakaan, atau pembatalan penerbangan. Tim kami juga tersedia 24 jam selama perjalanan untuk memberikan bantuan darurat jika diperlukan.</p>
<ul>
<li>Dokumen perjalanan dibantu dan dicek kelengkapannya sebelum keberangkatan</li>
<li>Briefing lengkap tentang destinasi, budaya, dan tips perjalanan</li>
<li>Group leader berpengalaman yang mendampingi selama perjalanan</li>
<li>Kontak darurat yang dapat dihubungi kapan saja selama tour berlangsung</li>
</ul>
<p>Pilih cara perjalanan yang cerdas dan aman. Bersama Happy Journey, Anda bisa fokus menikmati setiap momen perjalanan tanpa perlu khawatir tentang logistik dan keamanan.</p>',
            ],
            [
                'title'        => 'Tingkatkan Omset Perusahaan Dengan Reward Perjalanan',
                'excerpt'      => 'Reward perjalanan dapat meningkatkan semangat tim dengan cara yang menyenangkan dan berkesan.',
                'category'     => 'Corporate',
                'read_time'    => '6 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Di era persaingan bisnis yang semakin ketat, mempertahankan motivasi dan loyalitas karyawan adalah tantangan besar bagi setiap perusahaan. Berbagai penelitian menunjukkan bahwa reward dalam bentuk pengalaman — khususnya perjalanan wisata — jauh lebih berkesan dan efektif dibandingkan bonus tunai dalam membangun engagement dan loyalitas karyawan.</p>

<h3>Mengapa Reward Perjalanan Lebih Efektif</h3>
<p>Bonus uang cenderung cepat dilupakan dan seringkali langsung diserap untuk kebutuhan sehari-hari. Sebaliknya, pengalaman perjalanan bersama menciptakan memori kolektif yang memperkuat ikatan tim. Karyawan yang merasa dihargai dan mendapat pengalaman bersama rekan-rekannya akan memiliki rasa kebersamaan yang lebih kuat dan motivasi kerja yang lebih tinggi.</p>

<h3>Program Corporate Travel Happy Journey</h3>
<p>Happy Journey menyediakan layanan corporate travel yang dapat disesuaikan dengan kebutuhan dan anggaran perusahaan Anda. Dari company trip sederhana ke destinasi domestik hingga incentive tour internasional ke Jepang, Korea, atau Eropa, kami siap merancang program yang sempurna untuk tim Anda.</p>
<ul>
<li>Perencanaan itinerary yang disesuaikan dengan objektif perusahaan</li>
<li>Paket team building activities yang memperkuat kerja sama tim</li>
<li>Layanan MICE (Meeting, Incentive, Conference, Exhibition) lengkap</li>
<li>Harga korporat yang kompetitif dengan fleksibilitas pembayaran</li>
</ul>
<p>Investasikan dalam kebahagiaan tim Anda, dan saksikan bagaimana produktivitas dan loyalitas mereka meningkat secara signifikan. Hubungi tim Happy Journey untuk konsultasi program corporate travel yang sesuai dengan visi dan anggaran perusahaan Anda.</p>',
            ],
            [
                'title'        => 'Manfaat Wisata Membuka Wawasan Melihat Dunia',
                'excerpt'      => 'Wisata bukan sekadar rekreasi tetapi jendela untuk pemahaman lebih luas tentang dunia dan perspektif berbeda.',
                'category'     => 'Inspirasi',
                'read_time'    => '4 menit',
                'published_at' => '2025-09-30',
                'content'      => '<p>Berwisata adalah salah satu cara paling efektif untuk memperluas wawasan dan perspektif hidup. Ketika kita keluar dari lingkungan yang familiar dan menghadapi kebudayaan, bahasa, dan cara hidup yang berbeda, pikiran kita secara alami menjadi lebih terbuka dan fleksibel. Tidak ada buku teks atau kelas yang bisa menggantikan pengalaman langsung bertemu dengan keberagaman dunia.</p>

<h3>Manfaat Kognitif dari Perjalanan</h3>
<p>Penelitian dari neuroscience menunjukkan bahwa pengalaman baru — seperti navigasi di kota asing, berkomunikasi dalam bahasa berbeda, atau mencoba makanan yang belum pernah dimakan sebelumnya — merangsang pembentukan koneksi saraf baru di otak. Ini meningkatkan kemampuan berpikir kreatif, pemecahan masalah, dan adaptabilitas yang sangat berharga dalam kehidupan profesional maupun personal.</p>

<h3>Perspektif Baru tentang Kehidupan</h3>
<p>Melihat bagaimana orang di negara lain menjalani kehidupan mereka dapat memberikan perspektif baru yang mengubah cara kita memandang hidup sendiri. Mengunjungi negara berkembang mengajarkan rasa syukur, sementara melihat efisiensi Jepang atau kreativitas Korea bisa menginspirasi kita untuk menjadi lebih baik.</p>
<ul>
<li>Meningkatkan empati dan kemampuan berinteraksi lintas budaya</li>
<li>Mengembangkan kemandirian dan kepercayaan diri</li>
<li>Memperluas jaringan pertemanan secara global</li>
<li>Mendapatkan inspirasi segar untuk karier dan kehidupan pribadi</li>
</ul>
<p>Setiap perjalanan adalah kesempatan untuk menjadi versi diri yang lebih baik. Happy Journey tidak hanya mengantarkan Anda ke destinasi impian, tetapi juga membuka jendela menuju pengalaman hidup yang lebih kaya dan bermakna.</p>',
            ],
        ];

        foreach ($articles as $data) {
            BlogArticle::create([
                'slug'         => Str::slug($data['title']),
                'title'        => $data['title'],
                'excerpt'      => $data['excerpt'],
                'content'      => $data['content'] ?? $data['excerpt'],
                'image'        => $articleImages[$data['category']] ?? $articleImages['Inspirasi'],
                'category'     => $data['category'],
                'read_time'    => $data['read_time'],
                'is_active'    => true,
                'published_at' => $data['published_at'],
            ]);
        }
    }
}
