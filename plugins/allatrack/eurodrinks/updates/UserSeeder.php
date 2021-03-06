<?php namespace Acme\Users\Updates;

use Allatrack\Eurodrinks\Models\Address;
use Allatrack\Eurodrinks\Models\Brand;
use Allatrack\Eurodrinks\Models\Contractor;
use Allatrack\Eurodrinks\Models\Product;
use Backend\Models\User;
use Seeder;
use BackendAuth;
use DB;

class SeedUsersTable extends Seeder {

    public function run()
    {
        User::whereNotNull('brand_id')->delete();
        $imgPath = storage_path('temp/init/');
        $brands = [

            // display brands

            ['slug' => str_slug('Branche de charlerqi'), 'import_name' => 'Branche de charlerqi', 'image' => $imgPath . 'brands/1.png', 'style_class' => 'blue', 'is_displayed' => true],
            ['slug' => str_slug('Munchen'), 'import_name' => 'Munchen', 'image' => $imgPath . 'brands/2.png', 'style_class' => 'violet', 'is_displayed' => true],
            ['slug' => str_slug('Estrells'), 'import_name' => 'Estrells', 'image' => $imgPath . 'brands/3.png', 'style_class' => 'red', 'is_displayed' => true],
            ['slug' => str_slug('ERDINGER'), 'import_name' => 'ERDINGER', 'image' => $imgPath . 'brands/4.png', 'style_class' => 'black-blue big', 'is_displayed' => true],
            ['slug' => str_slug('Obaras'), 'import_name' => 'Obaras', 'image' => $imgPath . 'brands/5.png', 'style_class' => 'black big', 'is_displayed' => true],
            ['slug' => str_slug('Abbaye'), 'import_name' => 'Abbaye', 'image' => $imgPath . 'brands/6.png', 'style_class' => 'green-yellow medium', 'is_displayed' => true],

            ['slug' => str_slug('Keller'), 'import_name' => 'Keller', 'image' => $imgPath . 'brands/7.png', 'style_class' => 'yellow medium', 'is_displayed' => true],

            ['slug' => str_slug('Estrella'), 'import_name' => 'Estrella', 'image' => $imgPath . 'brands/8.png', 'style_class' => 'red big', 'is_displayed' => true],
            ['slug' => str_slug('saaz'), 'import_name' => 'saaz', 'image' => $imgPath . 'brands/9.png', 'style_class' => 'beige', 'is_displayed' => true],
            ['slug' => str_slug('Pilger'), 'import_name' => 'Pilger', 'image' => $imgPath . 'brands/10.png', 'style_class' => 'gray big', 'is_displayed' => true],
            ['slug' => str_slug('CHerie'), 'import_name' => 'CHerie', 'image' => $imgPath . 'brands/11.png', 'style_class' => 'white medium', 'is_displayed' => true],
            ['slug' => str_slug('Praga'), 'import_name' => 'Praga', 'image' => $imgPath . 'brands/12.png', 'style_class' => 'brown', 'is_displayed' => true],
            ['slug' => str_slug('Damm'), 'import_name' => 'Damm', 'image' => $imgPath . 'brands/13.png', 'style_class' => 'green', 'is_displayed' => true],
            ['slug' => str_slug('Magners'), 'import_name' => 'Magners', 'image' => $imgPath . 'brands/14.png', 'style_class' => 'dark-green big', 'is_displayed' => true],
            ['slug' => str_slug('Tennents'), 'import_name' => 'Tennents', 'image' => $imgPath . 'brands/15.png', 'style_class' => 'light-green medium', 'is_displayed' => true],
            ['slug' => str_slug('Backers'), 'import_name' => 'Backers', 'image' => $imgPath . 'brands/16.png', 'style_class' => 'light-gray', 'is_displayed' => true],
            ['slug' => str_slug('Karlsberg'), 'import_name' => 'Karlsberg', 'image' => $imgPath . 'brands/17.png', 'style_class' => 'dark-blue big', 'is_displayed' => true],
            ['slug' => str_slug('Bernard'), 'import_name' => 'Bernard', 'image' => $imgPath . 'brands/18.png', 'style_class' => 'green big', 'is_displayed' => true],
            ['slug' => str_slug('Huber Weisses'), 'import_name' => 'Huber Weisses', 'image' => $imgPath . 'brands/19.png', 'style_class' => 'green big', 'is_displayed' => true],
            ['slug' => str_slug('Paderborner'), 'import_name' => 'Paderborner', 'image' => $imgPath . 'brands/20.png', 'style_class' => 'green big', 'is_displayed' => true],
            ['slug' => str_slug('Faxe'), 'import_name' => 'Faxe', 'image' => $imgPath . 'brands/21.png', 'style_class' => 'gray big', 'is_displayed' => true],
            ['slug' => str_slug('Микулинецьке'), 'import_name' => 'Микулинецьке', 'image' => $imgPath . 'brands/22.png', 'style_class' => 'dark-green', 'is_displayed' => true],


            // import brands   Erdinger
            ['slug' => str_slug('БЕЛАЛКО'), 'import_name' => 'БЕЛАЛКО', 'image' => $imgPath . 'brand.png'],
            ['slug' => str_slug('Hofbrau'), 'import_name' => 'Hofbrau', 'image' => $imgPath . 'brand.png'],
            ['slug' => str_slug('Karlsbrau'), 'import_name' => 'Karlsbrau', 'image' => $imgPath . 'brand.png'],
            ['slug' => str_slug('ODA'), 'import_name' => 'ODA', 'image' => $imgPath . 'brand.png'],
            ['slug' => str_slug('Rauch'), 'import_name' => 'Rauch', 'image' => $imgPath . 'brand.png'],
            ['slug' => str_slug('Українські мінеральні води'), 'import_name' => 'Українські мінеральні води', 'image' => $imgPath . 'brands/brand.png']
        ];

        foreach ($brands as $brand)
        {
            $_brand = new Brand;
            $_brand->slug = $brand['slug'];
            $_brand->import_name = $brand['import_name'];
            $_brand->is_displayed = isset($brand['is_displayed']) ? $brand['is_displayed'] : false;
            $_brand->style_class = isset($brand['style_class']) ? $brand['style_class'] : '';
            $_brand->image = $brand['image'];
            try
            {
                $_brand->save();
            } catch (\Exception $e)
            {
                dd(file_put_contents('example.txt', 'brand 2' . $e->getMessage() . $brand['import_name']));
            }
        }

        // contractors slugs
        $ashanSlug = str_slug('АШАН ТОВ');
        $belalkoSlug = str_slug('БЕЛАЛКО');
        $provinoSlug = str_slug('ПРОВИНО ТОВ');
        $freuaSlug = str_slug('ФРЕЯ 2017 ТОВ');
        $fozziSlug = str_slug('ФОЗЗІ-ФУД ТОВ');
        $tsPlusSlug = str_slug('ТС ПЛЮС ТОВ');
        $silpoSlug = str_slug('СІЛЬПО-ФУД ТОВ');
        $roalSlug = str_slug('РОЯЛ МЕДІА ТОВ');
        $novusSlug = str_slug('НОВУС ТОВ');
        $madiatreidingfSlug = str_slug('МЕДІАТРЕЙДІНГ ТОГОВИЙ ДІМ ТОВ');
        $ecspansiafSlug = str_slug('ЕКСПАНСІЯ ТОВ');

        DB::table('allatrack_eurodrinks_contractors')->insert([
            ['slug' => $belalkoSlug, 'import_name' => 'БЕЛАЛКО'],
            ['slug' => str_slug('АМІАТА ТОВ'), 'import_name' => 'АМІАТА ТОВ'],
            ['slug' => str_slug('АТБ-МАРКЕТ ТОВ'), 'import_name' => 'АТБ-МАРКЕТ ТОВ'],
            ['slug' => str_slug('Атлантік-Трейдінг ТОВ'), 'import_name' => 'Атлантік-Трейдінг ТОВ'],
            ['slug' => $ashanSlug, 'import_name' => 'АШАН ТОВ'],
            ['slug' => str_slug('БІЛЛА-УКРАЇНА ПII'), 'import_name' => 'БІЛЛА-УКРАЇНА ПII'],
            ['slug' => str_slug('БЮРО ВИН ТОВ'), 'import_name' => 'БЮРО ВИН ТОВ'],
            ['slug' => str_slug('ВАЛЛЕНБЕРГ ТЕТЯНА ДМИТРІВНА ФОП'), 'import_name' => 'ВАЛЛЕНБЕРГ ТЕТЯНА ДМИТРІВНА ФОП'],
            ['slug' => str_slug('ГРУПА РІТЕЙЛУ УКРАЇНИ ТОВ'), 'import_name' => 'ГРУПА РІТЕЙЛУ УКРАЇНИ ТОВ'],
            ['slug' => str_slug('ДАСТОР-УЖГОРОД ТОВ'), 'import_name' => 'ДАСТОР-УЖГОРОД ТОВ'],
            ['slug' => str_slug('ДЖУНА ТОВ'), 'import_name' => 'ДЖУНА ТОВ'],
            ['slug' => str_slug('ДІВІАЛ-2000 ПП'), 'import_name' => 'ДІВІАЛ-2000 ПП'],
            ['slug' => str_slug('ЕКО ТОВ'), 'import_name' => 'ЕКО ТОВ'],
            ['slug' => str_slug('ЕКСІМ ТРЕЙД ТРАНС ФУД ТОВ'), 'import_name' => 'ЕКСІМ ТРЕЙД ТРАНС ФУД ТОВ'],
            ['slug' => $ecspansiafSlug, 'import_name' => 'ЕКСПАНСІЯ ТОВ'],
            ['slug' => str_slug('ЛАБР ТОВ'), 'import_name' => 'ЛАБР ТОВ'],
            ['slug' => str_slug('ЛОДКІН В\'ЯЧЕСЛАВ БОРИСОВИЧ ФОП'), 'import_name' => 'ЛОДКІН В\'ЯЧЕСЛАВ БОРИСОВИЧ ФОП'],
            ['slug' => $madiatreidingfSlug, 'import_name' => 'МЕДІАТРЕЙДІНГ ТОГОВИЙ ДІМ ТОВ'],
            ['slug' => str_slug('МЕТРО Кеш енд Кері Україна ТОВ'), 'import_name' => 'МЕТРО Кеш енд Кері Україна ТОВ'],
            ['slug' => str_slug('НОВУС УКРАЇНА ТОВ'), 'import_name' => 'НОВУС УКРАЇНА ТОВ'],
            ['slug' => $novusSlug, 'import_name' => 'НОРДОН ТОВ'],
            ['slug' => str_slug('ОЛЕКСАНДРІЯ - БЛІГ ТОВ'), 'import_name' => 'ОЛЕКСАНДРІЯ - БЛІГ ТОВ'],
            ['slug' => str_slug('П.С.Ю УЖГОРОД ТОВ'), 'import_name' => 'П.С.Ю УЖГОРОД ТОВ'],
            ['slug' => str_slug('ПОЛТАВПИВО Фірма ПАТ'), 'import_name' => 'ПОЛТАВПИВО Фірма ПАТ'],
            ['slug' => str_slug('ПЛОДООВОЧ-УЖ ТОВ'), 'import_name' => 'ПЛОДООВОЧ-УЖ ТОВ'],
            ['slug' => $provinoSlug, 'import_name' => 'ПРОВИНО ТОВ'],
            ['slug' => str_slug('РОЗНЕТ ТОВ'), 'import_name' => 'РОЗНЕТ ТОВ'],
            ['slug' => str_slug('РОСТІКС УКРАЇНА ТОВ'), 'import_name' => 'РОСТІКС УКРАЇНА ТОВ'],
            ['slug' => $roalSlug, 'import_name' => 'РОЯЛ МЕДІА ТОВ'],
            ['slug' => str_slug('СИМПАТИК ТОВ'), 'import_name' => 'СИМПАТИК ТОВ'],
            ['slug' => $silpoSlug, 'import_name' => 'СІЛЬПО-ФУД ТОВ'],
            ['slug' => str_slug('СПІРІТ ЗАХІД ПП'), 'import_name' => 'СПІРІТ ЗАХІД ПП'],
            ['slug' => str_slug('ТАІС-ДІСТРИБЬЮШН ТОВ'), 'import_name' => 'ТАІС-ДІСТРИБЬЮШН ТОВ'],
            ['slug' => str_slug('ТВИЧ ТОВ'), 'import_name' => 'ТВИЧ ТОВ'],
            ['slug' => str_slug('ТД РЕСУРС ТОВ'), 'import_name' => 'ТД РЕСУРС ТОВ'],
            ['slug' => $tsPlusSlug, 'import_name' => 'ТС ПЛЮС ТОВ'],
            ['slug' => str_slug('Укр-Трейд ТОВ'), 'import_name' => 'Укр-Трейд ТОВ'],
            ['slug' => str_slug('УШАКОВ ІГОР ВАДИМОВИЧ ФОП'), 'import_name' => 'УШАКОВ ІГОР ВАДИМОВИЧ ФОП'],
            ['slug' => str_slug('Ф.К.С. ТОВ'), 'import_name' => 'Ф.К.С. ТОВ'],
            ['slug' => $fozziSlug, 'import_name' => 'ФОЗЗІ-ФУД ТОВ'],
            ['slug' => $freuaSlug, 'import_name' => 'ФРЕЯ 2017 ТОВ'],
            ['slug' => str_slug('ФУДКОМ ТОВ'), 'import_name' => 'ФУДКОМ ТОВ'],
            ['slug' => str_slug('ФУДМЕРЕЖА ТОВ'), 'import_name' => 'ФУДМЕРЕЖА ТОВ'],
            ['slug' => str_slug('ЧП Колесниченко'), 'import_name' => 'ЧП Колесниченко'],
            ['slug' => str_slug('ШАНДРУК ТОРГОВИЙ ДІМ ТОВ'), 'import_name' => 'ШАНДРУК ТОРГОВИЙ ДІМ ТОВ'],
            ['slug' => str_slug('ЮЛАНА ТОВ'), 'import_name' => 'ЮЛАНА ТОВ'],
        ]);

        $contractor = Contractor::whereSlug($ashanSlug)->first();

        $contractorId = $contractor->id;

        $arr = [
            new Address([
                'latitude'  => 50.428573,
                'longitude' => 30.356441,
                'name_en'   => 'Tts Promenada-Park, Velyka Okruzhna Vulytsya, 4, Petropavlivska',
                'name_ru'   => 'село Петропавлівська Борщагівка, Велика Окружна улица, 4',
                'name_uk'   => 'село Петропавлівська Борщагівка, Велика Окружна вулиця, 4',
            ]),
            new Address([
                'latitude'  => 50.49705,
                'longitude' => 30.361673,
                'name_en'   => 'Stepana Bandery Avenue, 15А',
                'name_ru'   => 'ул. Берковецкая, 6',
                'name_uk'   => 'Берковецька вулиця, 6',
            ]),
            new Address([
                'latitude'  => 50.491338,
                'longitude' => 30.48985,
                'name_en'   => 'Stepana Bandery Avenue, 15А',
                'name_ru'   => 'Ул. Степана Бандеры, 15А',
                'name_uk'   => 'Степана Бандери вулиця, 15А',
            ]),
            new Address([
                'latitude'  => 50.493930,
                'longitude' => 30.561961,
                'name_en'   => 'Henerala Vatutina Ave, 2',
                'name_ru'   => 'просп. Генерала Ватутина, 2, Скаймолл',
                'name_uk'   => 'просп. Генерала Ватутіна, 2, Скаймолл',
            ])
        ];

        foreach ($arr as $item)
        {
            $item->save();
            $contractor->addresses()->attach($item->id);
        }


        $contractor = Contractor::whereSlug($provinoSlug)->first();

        $contractor->addresses()->attach($item->id);
        $item = new Address([
            'latitude'  => 50.472898,
            'longitude' => 30.5015631,
            'name_en'   => 'вулиця Костянтинівська, 71, Київ, Украина, 02000',
            'name_ru'   => 'вулиця Костянтинівська, 71, Київ, Украина, 02000',
            'name_uk'   => 'вулиця Костянтинівська, 71, Київ, Украина, 02000',
        ]);
        $item->save();
        $contractor->addresses()->attach($item->id);


        $contractor = Contractor::whereSlug($freuaSlug)->first();
        $item = new Address([
            'latitude'  => 50.4766635,
            'longitude' => 30.4052756,
            'name_en'   => 'вулиця Данила Щербаківського, 55, Київ, Украина, 04111',
            'name_ru'   => 'вулиця Данила Щербаківського, 55, Київ, Украина, 04111',
            'name_uk'   => 'вулиця Данила Щербаківського, 55, Київ, Украина, 04111',
        ]);
        $item->save();
        $contractor->addresses()->attach($item->id);


        $contractor = Contractor::whereSlug($fozziSlug)->first();
        $item = new Address([
            'latitude'  => 50.443718,
            'longitude' => 30.652011,
            'name_en'   => 'вулиця Академіка Бутлерова, 1, Київ, Украина, 02000',
            'name_ru'   => 'вулиця Академіка Бутлерова, 1, Київ, Украина, 02000',
            'name_uk'   => 'вулиця Академіка Бутлерова, 1, Київ, Украина, 02000',
        ]);
        $item->save();
        $contractor->addresses()->attach($item->id);


        $contractor = Contractor::whereSlug($tsPlusSlug)->first();
        $item = new Address([
            'latitude'  => 50.4649625,
            'longitude' => 30.3785785,
            'name_en'   => 'Краснова М. вул. 27, Київ, Київська, Украина, 03115',
            'name_ru'   => 'Краснова М. вул. 27, Київ, Київська, Украина, 03115',
            'name_uk'   => 'Краснова М. вул. 27, Київ, Київська, Украина, 03115',
        ]);
        $item->save();
        $contractor->addresses()->attach($item->id);


        $contractor = Contractor::whereSlug($silpoSlug)->first();
        $item = new Address([
            'latitude'  => 50.4954335,
            'longitude' => 30.3593221,
            'name_en'   => 'вулиця Берковецька, 6Д, Київ, Украина, 04128',
            'name_ru'   => 'вулиця Берковецька, 6Д, Київ, Украина, 04128',
            'name_uk'   => 'вулиця Берковецька, 6Д, Київ, Украина, 04128',
        ]);
        $item->save();
        $contractor->addresses()->attach($item->id);


        $contractor = Contractor::whereSlug($roalSlug)->first();
        $contractor->addresses()->attach(Address::create([
            'latitude'  => 50.5296706,
            'longitude' => 30.6274765,
            'name_en'   => 'вулиця Миколи Закревського, 93А, 245, Київ, Украина, 02000',
            'name_ru'   => 'вулиця Миколи Закревського, 93А, 245, Київ, Украина, 02000',
            'name_uk'   => 'вулиця Миколи Закревського, 93А, 245, Київ, Украина, 02000',
        ])->id);

        $contractor = Contractor::whereSlug($novusSlug)->first();
        $contractor->addresses()->attach(Address::create([
            'latitude'  => 50.455001,
            'longitude' => 30.3880697,
            'name_en'   => 'ул. Святошинская, 3 Киев Украина 02000',
            'name_ru'   => 'ул. Святошинская, 3 Киев Украина 02000',
            'name_uk'   => 'ул. Святошинская, 3 Киев Украина 02000',
        ])->id);

        $contractor = Contractor::whereSlug($madiatreidingfSlug)->first();
        $contractor->addresses()->attach(Address::create([
            'latitude'  => 50.4634515,
            'longitude' => 30.4528566,
            'name_en'   => 'Дегтярівська вул., 48, Київ, Київська обл., Украина, 04112',
            'name_ru'   => 'Дегтярівська вул., 48, Київ, Київська обл., Украина, 04112',
            'name_uk'   => 'Дегтярівська вул., 48, Київ, Київська обл., Украина, 04112',
        ])->id);


        $contractor = Contractor::whereSlug($ecspansiafSlug)->first();
        $contractor->addresses()->attach(Address::create([
            'latitude'  => 50.3866396,
            'longitude' => 30.3470769,
            'name_en'   => 'вулиця Промислова, 5, Вишневе, Київська обл., Украина, 08132',
            'name_ru'   => 'вулиця Промислова, 5, Вишневе, Київська обл., Украина, 08132',
            'name_uk'   => 'вулиця Промислова, 5, Вишневе, Київська обл., Украина, 08132',
        ])->id);

        $belalo_id = Brand::where('slug', str_slug('БЕЛАЛКО'))->first()->id;
        $products = [
            ['name_uk' => 'Горілка "Дика Качка" , 0,5 л/20', 'capacity' => 0.5, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Горілка "Дика Качка", 0,7 л/12', 'capacity' => 0.7, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Горілка "Хлєбніков Класична", 0,5 л/20', 'capacity' => 0.5, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Горілка особлива "Дика Качка VIP", 0,5 л/20', 'capacity' => 0.5, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Горілка особлива "Дика Качка VIP", 0,7 л/12', 'capacity' => 0.7, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Горілка "Ведмежий Лог" , 0,5/20', 'capacity' => 0.5, 'brand_id' => $belalo_id, 'image' => $imgPath . 'beer.png']
        ];

        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            try
            {
                $_product->save();
            } catch (\Exception $e)
            {
                dd(file_put_contents('app_seed_log.txt', $belalo_id . ' Error 3' . $e->getMessage() . $product['name_uk']));
            }
        }

        $ERDINGER_id = Brand::where('slug', str_slug('ERDINGER'))->first()->id;
        $products = [
            [
                'name_uk'  => 'Набір подарунковий "Erdinger Oktoberfest" 5+1',
                'capacity' => 2.5, 'brand_id' => $ERDINGER_id,
                'image'    => $imgPath . 'beer.png'
            ],
            [
                'name_uk'      => 'Пиво ERDINGER Alkoholfrei 0.33л',
                'capacity'     => 0.33,
                'brand_id'     => $ERDINGER_id,
                'image'        => $imgPath . 'products/Erdinger/SKU/8.png',
                'is_displayed' => true,
                'display_name' => 'Alkoholfrei',
                'degree'       => 0.4
            ],
            [
                'name_uk'      => 'Пиво ERDINGER Alkoholfrei 0.5л',
                'capacity'     => 0.5,
                'brand_id'     => $ERDINGER_id,
                'image'        => $imgPath . 'products/Erdinger/SKU/7.png',
                'is_displayed' => true,
                'display_name' => 'Alkoholfrei',
                'degree'       => 0.4
            ],
            [
                'name_uk'  => 'Пиво ERDINGER Alkoholfrei 0.5л ж/б',
                'capacity' => 0.5,
                'brand_id' => $ERDINGER_id,
                'image'    => $imgPath . 'beer.png'
            ],
            [
                'name_uk'         => 'Пиво ERDINGER Oktoberfest 5.7% 0.5л',
                'capacity'        => 0.5,
                'brand_id'        => $ERDINGER_id,
                'image'           => $imgPath . 'products/Erdinger/SKU/3.png',
                'is_displayed'    => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Oktoberfest',
                'degree'          => 5.7
            ],
            [
                'name_uk'         => 'Пиво ERDINGER Pikantus 7.3% 0.5л',
                'capacity'        => 0.5,
                'brand_id'        => $ERDINGER_id,
                'image'           => $imgPath . 'products/Erdinger/SKU/4.png',
                'is_displayed'    => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Pikantus',
                'degree'          => 7.3
            ],
            [
                'name_uk'  => 'Пиво ERDINGER Schneeweisse 5.6% 0.5л',
                'capacity' => 0.5,
                'brand_id' => $ERDINGER_id,
                'image'    => $imgPath . 'beer.png'
            ],
            [
                'name_uk'         => 'Пиво ERDINGER Sommerweisse 0,33л',
                'capacity'        => 0.33,
                'brand_id'        => $ERDINGER_id,
                'image'           => $imgPath . 'products/Erdinger/SKU/5.png',
                'is_displayed'    => true,
                'contractor_slug' => $belalkoSlug,
                'display_name'    => 'Sommerweisse', 'degree' => 4.6
            ],
            [
                'name_uk'  => 'Пиво ERDINGER Weissbier 5.3% 0.5л',
                'capacity' => 0.5,
                'brand_id' => $ERDINGER_id,
                'image'    => $imgPath . 'beer.png'
            ],
            [
                'name_uk'         => 'Пиво ERDINGER Weissbier 5.3% 0.5л ж/б',
                'capacity'        => 0.5,
                'brand_id'        => $ERDINGER_id,
                'image'           => $imgPath . 'products/Erdinger/SKU/2.png',
                'is_displayed'    => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Weissbier', 'degree' => 5.3
            ],
            [
                'name_uk'  => 'Пиво ERDINGER Weissbier 5.3% 20л',
                'capacity' => 20,
                'brand_id' => $ERDINGER_id,
                'image'    => $imgPath . 'beer.png'
            ],
            [
                'name_uk'         => 'Пиво ERDINGER Weissbier Dunkel 5.3%  0.5л',
                'capacity'        => 0.5,
                'brand_id'        => $ERDINGER_id,
                'image'           => $imgPath . 'products/Erdinger/SKU/1.png',
                'is_displayed'    => true,
                'contractor_slug' => $novusSlug,
                'display_name'    => 'Weissbier Dunkel',
                'degree'          => 5.3
            ]
        ];

        foreach ($products as $product)
        {
            try
            {
                $_product = new Product();
                $_product->name_uk = $product['name_uk'];
                $_product->name_en = str_slug($product['name_uk']);
                if (isset($product['display_name'])){
                    $_product->display_name = $product['display_name'];
                }
                if (isset($product['degree'])){
                    $_product->degree = $product['degree'];
                }
                $_product->name_en = str_slug($product['name_uk']);
                $_product->brand_id = $product['brand_id'];
                $_product->capacity = $product['capacity'];
                $_product->is_displayed = isset($product['is_displayed']) ? $product['is_displayed'] : false;
                $_product->image = $product['image'];
                $_product->save();
                if (isset($product['contractor_slug']))
                {
                    $_product->contractors()->attach(Contractor::whereSlug($product['contractor_slug'])->first()->id);
                }

            } catch (\Exception $e)
            {
                dd($_product);

                dd(file_put_contents('app_seed_log.txt', 'Error 1' . $e->getMessage()));
            }

        }

        $Estrella_id = Brand::where('slug', str_slug('Estrella'))->first()->id;
        $products = [
            [
                'name_uk' => 'Пиво Estrella Barcelona Inedit Damm 4,8%, 0,33 л',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id, 'image' => $imgPath . 'beer.png'],
            [
                'name_uk' => 'Пиво Estrella Barcelona Inedit Damm 4,8%, 0,75 л',
                'capacity' => 0.75,
                'brand_id' => $Estrella_id, 'image' => $imgPath . 'products/Estrella/SKU/7.png',
                'is_displayed' => true,
                'contractor_slug' => $fozziSlug,
                'display_name'    => 'Barcelona Inedit Damm',
                'degree'          => 4.8
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле 4,6%, 0,33 л ж/б',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id, 'image' => $imgPath . 'products/Estrella/SKU/2.png',
                'is_displayed' => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Damm Barcelona світле',
                'degree'          => 4.6
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле 4,6%, 0,66л',
                'capacity' => 0.66,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/1.png',
                'is_displayed' => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Damm Barcelona світле',
                'degree'          => 4.6
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле 4,6%, 1л',
                'capacity' => 1,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/4.png',
                'is_displayed' => true,
                'contractor_slug' => $novusSlug,
                'display_name'    => 'Damm Barcelona світле',
                'degree'          => 4.6
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле ж/б 0,5л',
                'capacity' => 0.5,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'beer.png'
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле кега 30л',
                'capacity' => 30,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'beer.png'
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Barcelona світле одноразова кега 30л',
                'capacity' => 30,
                'brand_id' => $Estrella_id, 'image' => $imgPath . 'beer.png'
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Daura скло 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/5.png',
                'is_displayed' => true,
                'contractor_slug' => $novusSlug,
                'display_name'    => 'Damm Daura скло',
                'degree'          => 0.4
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Lemon скло 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/9.png',
                'is_displayed' => true,
                'contractor_slug' => $freuaSlug,
                'display_name'    => 'Damm Lemon скло',
                'degree'          => 3
            ],
            [
                'name_uk' => 'Пиво Estrella Damm non alcoholic бут 0,25л',
                'capacity' => 0.25,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'beer.png'
            ],
            [
                'name_uk' => 'Пиво Estrella Damm non alcoholic метал. банка 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id, 'image' => $imgPath . 'products/Estrella/SKU/10.png',
                'is_displayed' => true,
                'contractor_slug' => $freuaSlug,
                'display_name'    => 'Damm non alcoholic',
                'degree'          => 0
            ],
            [
                'name_uk' => 'Пиво Estrella Damm Saaz скло 0.33л',
                'capacity' => 0.33,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/11.png',
                'is_displayed' => true,
                'contractor_slug' => $fozziSlug,
                'display_name'    => 'Damm Saaz скло',
                'degree'          => 3.5
            ],
            [
                'name_uk' => 'Пиво Keler Lager світле 5,4 %, 1л',
                'capacity' => 1,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/12.png',
                'is_displayed' => true,
                'contractor_slug' => $ashanSlug,
                'display_name'    => 'Keler Lager світле',
                'degree'          => 5.4
            ],
            [
                'name_uk' => 'Пиво Keler Lager світле 6,2 %, 0.5л. ж/б',
                'capacity' => 0.5,
                'brand_id' => $Estrella_id,
                'image' => $imgPath . 'products/Estrella/SKU/1.png'
            ]
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            if (isset($product['display_name'])){
                $_product->display_name = $product['display_name'];
            }
            if (isset($product['degree'])){
                $_product->degree = $product['degree'];
            }
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->is_displayed = isset($product['is_displayed']) ? $product['is_displayed'] : false;

            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }

        $Faxe_id = Brand::where('slug', str_slug('Faxe'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво Faxe 10%, 0.5л, з/б', 'capacity' => 0.5, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Amber 5%, 0.5л, з/б', 'capacity' => 0.5, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Black 4.7%, 1л, з/б', 'capacity' => 1, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Premium 5%, 0.5л, з/б', 'capacity' => 0.5, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Premium 5%, 1л, з/б', 'capacity' => 1, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Royal Export 5.6%, 0.5л, з/б', 'capacity' => 0.5, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Faxe Stout 7.7%, 0.5л, з/б', 'capacity' => 0.5, 'brand_id' => $Faxe_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Hofbrau_id = Brand::where('slug', str_slug('Hofbrau'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво HB Dunkel 5.5% 0.5л', 'capacity' => 0.5, 'brand_id' => $Hofbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво HB Münchner Weissbier 5.1% 0.5л', 'capacity' => 0.5, 'brand_id' => $Hofbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво HB Oktoberfest 6.3% 0.5л', 'capacity' => 0.5, 'brand_id' => $Hofbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво HB Original Munchen 5.1% 0.5л', 'capacity' => 0.5, 'brand_id' => $Hofbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво HB Schwarze Weisse 5.1% 0.5л', 'capacity' => 0.5, 'brand_id' => $Hofbrau_id, 'image' => $imgPath . 'beer.png']
        ];

        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }

        $Huber_Weisses_id = Brand::where('slug', str_slug('Huber Weisses'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво Huber Weisses Dunkel 5,4% .0,5л', 'capacity' => 0.5, 'brand_id' => $Huber_Weisses_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Huber Weisses Original 5,4% .0,5л', 'capacity' => 0.5, 'brand_id' => $Huber_Weisses_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Huber Weisses Original 5.4% 30л', 'capacity' => 30, 'brand_id' => $Huber_Weisses_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Karlsbrau_id = Brand::where('slug', str_slug('Karlsbrau'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво Beckers Lager ж/б, 0,5 л', 'capacity' => 0.5, 'brand_id' => $Karlsbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Beckers Pils ж/б, 0,5 л', 'capacity' => 0.5, 'brand_id' => $Karlsbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Karlsbrau Lager ж/б, 0,5 л', 'capacity' => 0.5, 'brand_id' => $Karlsbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Karlsbrau Urpils ж/б, 0,5 л', 'capacity' => 0.5, 'brand_id' => $Karlsbrau_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Karlsbrau Weizen ж/б, 0,5 л', 'capacity' => 0.5, 'brand_id' => $Karlsbrau_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Magners_id = Brand::where('slug', str_slug('Magners'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво Tennents Stout 4,7% кега по 30л', 'capacity' => 30, 'brand_id' => $Magners_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Tennents Whisky світле 6%, 0,33л', 'capacity' => 0.33, 'brand_id' => $Magners_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сидр яблучний Magners, з/банка. 0,5л', 'capacity' => 0.5, 'brand_id' => $Magners_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $ODA_id = Brand::where('slug', str_slug('ODA'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво ADA Ambree 6.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво ADA Blonde 6.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво ADA Brune 6.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Blanche de Charleroi 5.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Cherie a la Cerise 5.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Cherie a la Framboise 3.0% 0.33л', 'capacity' => 0.33, 'brand_id' => $ODA_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Paderborner_id = Brand::where('slug', str_slug('Paderborner'))->first()->id;
        $products = [
            [
                'name_uk' => 'Пиво Paderborner Export ж/б, 0,5 л',
                'capacity' => 0.5,
                'brand_id' => $Paderborner_id,
                'image' => $imgPath . 'products/Paderborner/SKU/1.png',
                'is_displayed' => true,
                'contractor_slug' => $tsPlusSlug,
                'display_name'    => 'Export',
                'degree'          => 5.5
            ],
            [
                'name_uk' => 'Пиво Paderborner Pilsener ж/б, 0,33 л',
                'capacity' => 0.33,
                'brand_id' => $Paderborner_id,
                'image' => $imgPath . 'products/Paderborner/SKU/5.png',
                'is_displayed' => true,
                'contractor_slug' => $tsPlusSlug,
                'display_name'    => 'Pilsener',
                'degree'          => 4.9
            ],
            [
                'name_uk' => 'Пиво Paderborner Pilsener ж/б, 0,5 л',
                'capacity' => 0.5,
                'brand_id' => $Paderborner_id,
                'image' => $imgPath . 'products/Paderborner/SKU/4.png',
                'is_displayed' => true,
                'contractor_slug' => $tsPlusSlug,
                'display_name'    => 'Pilsener',
                'degree'          => 4.9
            ]
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            if (isset($product['display_name'])){
                $_product->display_name = $product['display_name'];
            }
            if (isset($product['degree'])){
                $_product->degree = $product['degree'];
            }
            $_product->is_displayed = isset($product['is_displayed']) ? $product['is_displayed'] : false;
            $_product->image = $product['image'];

            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Praga_id = Brand::where('slug', str_slug('Praga'))->first()->id;
        $products = [
            [
                'name_uk' => 'Пиво PRAGA Dark Lager кега по 30л',
                'capacity' => 30,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво PRAGA Dark Lager пляшка скло по 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво Praga Dark Lager Темне, 4,8% 0,5л, з/б',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/6.png',
                'is_displayed' => true,
                'contractor_slug' => $madiatreidingfSlug,
                'display_name'    => 'Pilsener',
                'degree'          => 4.9
            ],
            [
                'name_uk' => 'Пиво Praga Dark Lager темне, 4,5% 0,5л',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/4.png',
                'is_displayed' => true,
                'contractor_slug' => $madiatreidingfSlug,
                'display_name'    => 'Praga Dark Lager',
                'degree'          => 4.5
            ],
            [
                'name_uk' => 'Пиво Praga Hefeweizen пляшка скло 0.5л',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво Praga Premiium Pils світле, 3,8% 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво Praga Premium Pils (Silver), 4,0% 0,5л, з/б',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво PRAGA Premium Pils кега по 30л',
                'capacity' => 30,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво PRAGA Premium Pils пляшка скло по 0,33л',
                'capacity' => 0.33,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png'
            ],
            [
                'name_uk' => 'Пиво Praga Premium Pils світле, 4,7% 0,5л',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/1.png',
                'is_displayed' => true,
                'contractor_slug' => $madiatreidingfSlug,
                'display_name'    => 'Premium Pils світле',
                'degree'          => 4.7
            ],
            [
                'name_uk' => 'Пиво Praga Premium Pils світле, 4,7% 0,5л, з/б',
                'capacity' => 0.5,
                'brand_id' => $Praga_id,
                'image' => $imgPath . 'products/Praga/SKU/2.png',
                'is_displayed' => true,
                'contractor_slug' => $madiatreidingfSlug,
                'display_name'    => 'Premium Pils світле',
                'degree'          => 4.7
            ]
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            if (isset($product['display_name'])){
                $_product->display_name = $product['display_name'];
            }
            if (isset($product['degree'])){
                $_product->degree = $product['degree'];
            }
            $_product->is_displayed = isset($product['is_displayed']) ? $product['is_displayed'] : false;
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $Rauch_id = Brand::where('slug', str_slug('Rauch'))->first()->id;
        $products = [
            ['name_uk' => 'Гранатовий мультифруктовий соковий напій Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Нектар Груша 50% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Нектар Манго 26% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Нектар Персик 50% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Нектар Рожева Гуава 25% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Апельсиновий 100% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Апельсиновий 100% Happy Day Tetrapak 0.2л', 'capacity' => 0.2, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Мультивітамін 100% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Мультивітамін Червоні Фрукти 100% Happy Day Tetrapak 0.2л', 'capacity' => 0.2, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Раух Грейпфрут 100% скло 0,2л', 'capacity' => 0.3, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Яблучний 100% Happy Day Gabletop 1л', 'capacity' => 1, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Сік Яблучний 100% Happy Day Tetrapak 0.2л', 'capacity' => 0.2, 'brand_id' => $Rauch_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $macu_id = Brand::where('slug', str_slug('Микулинецьке'))->first()->id;
        $products = [
            ['name_uk' => 'Пиво Kaltenberg spezial 0,5', 'capacity' => 1, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке "900" ПЕТ-1 л', 'capacity' => 1, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке "Микулин" світле ПЕТ-1 л', 'capacity' => 1, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке "Микулин" світле, скло 0,5 л', 'capacity' => 0.5, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке 900, скло 0,5 л', 'capacity' => 0.5, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке Медове, скло 0,5 л', 'capacity' => 0.5, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке Тернове поле, скло 0,5 л', 'capacity' => 0.5, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Пиво Микулинецьке Троян, скло 0,5 л', 'capacity' => 0.5, 'brand_id' => $macu_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }
        $umv_id = Brand::where('slug', str_slug('Українські мінеральні води'))->first()->id;
        $products = [
            ['name_uk' => 'Лужанська, вода мінеральна ПЕТ 1.5л', 'capacity' => 1.5, 'brand_id' => $umv_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Лужанська, вода мінеральна т/у 0.5л', 'capacity' => 0.5, 'brand_id' => $umv_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Поляна квасова, вода мінеральна т/у 0.5л', 'capacity' => 0.5, 'brand_id' => $umv_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Свалява, вода мінеральна ПЕТ 1.5л', 'capacity' => 1.5, 'brand_id' => $umv_id, 'image' => $imgPath . 'beer.png'],
            ['name_uk' => 'Тонус-Кислород, вода мінеральна столова ПЕТ 1.5л', 'capacity' => 1.5, 'brand_id' => $umv_id, 'image' => $imgPath . 'beer.png']
        ];
        foreach ($products as $product)
        {
            $_product = new Product();
            $_product->name_uk = $product['name_uk'];
            $_product->name_en = str_slug($product['name_uk']);
            $_product->brand_id = $product['brand_id'];
            $_product->capacity = $product['capacity'];
            $_product->image = $product['image'];
            $_product->save();
            if (isset($product['contractor_slug']))
            {
                $_product->contractors()->attach(Contractor::whereSlug($novusSlug)->first()->id);
            }
        }


        Product::whereNameUk('Набір подарунковий "Erdinger Oktoberfest" 5+1')
            ->first()
            ->contractors()
            ->attach($contractorId);;


        BackendAuth::register([
            'first_name'            => 'erdinger',
            'login'                 => 'erdinger',
            'email'                 => 'erdinger@website.tld',
            'password'              => 'erdinger',
            'password_confirmation' => 'erdinger',
            'brand_id'              => $ERDINGER_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Estrella',
            'login'                 => 'estrella',
            'email'                 => 'estrella@website.tld',
            'password'              => 'estrella',
            'password_confirmation' => 'estrella',
            'brand_id'              => $Estrella_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Faxe',
            'login'                 => 'faxe',
            'email'                 => 'faxe@website.tld',
            'password'              => 'faxe',
            'password_confirmation' => 'faxe',
            'brand_id'              => $Faxe_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Hofbrau',
            'login'                 => 'hofbrau',
            'email'                 => 'hofbrau@website.tld',
            'password'              => 'hofbrau',
            'password_confirmation' => 'hofbrau',
            'brand_id'              => $Hofbrau_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Huber Weisses',
            'login'                 => 'weisses',
            'email'                 => 'weisses@website.tld',
            'password'              => 'weisses',
            'password_confirmation' => 'weisses',
            'brand_id'              => $Huber_Weisses_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Karlsbrau',
            'login'                 => 'karlsbrau',
            'email'                 => 'karlsbrau@website.tld',
            'password'              => 'karlsbrau',
            'password_confirmation' => 'karlsbrau',
            'brand_id'              => $Karlsbrau_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Magners',
            'login'                 => 'magners',
            'email'                 => 'magners@website.tld',
            'password'              => 'magners',
            'password_confirmation' => 'magners',
            'brand_id'              => $Magners_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'ODA',
            'login'                 => 'oda',
            'email'                 => 'oda@website.tld',
            'password'              => 'odaoda',
            'password_confirmation' => 'odaoda',
            'brand_id'              => $ODA_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Paderborner',
            'login'                 => 'paderborner',
            'email'                 => 'paderborner@website.tld',
            'password'              => 'paderborner',
            'password_confirmation' => 'paderborner',
            'brand_id'              => $Paderborner_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Praga',
            'login'                 => 'praga',
            'email'                 => 'praga@website.tld',
            'password'              => 'praga',
            'password_confirmation' => 'praga',
            'brand_id'              => $Praga_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Микулинецьке',
            'login'                 => 'makulinicke',
            'email'                 => 'makulinicke@website.tld',
            'password'              => 'makulinicke',
            'password_confirmation' => 'makulinicke',
            'brand_id'              => $macu_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

        BackendAuth::register([
            'first_name'            => 'Українські мінеральні води',
            'login'                 => 'uminv',
            'email'                 => 'uminv@website.tld',
            'password'              => 'uminv',
            'password_confirmation' => 'uminv',
            'brand_id'              => $umv_id,
            'permissions'           => ['allatrack.eurodrinks.see_stat' => 1]
        ]);

    }
}