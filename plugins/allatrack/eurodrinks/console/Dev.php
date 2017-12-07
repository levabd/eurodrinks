<?php namespace Allatrack\Eurodrinks\Console;

use Allatrack\Eurodrinks\Models\Brand;
use Allatrack\Eurodrinks\Models\Product;
use Allatrack\Eurodrinks\Services\BrandStatisticImporter;
use Backend\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Excel;
use DB;
use App;
use BackendAuth;
use Storage;

class Dev extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'eurodrinks:dev';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {

        $all=Brand::with('contractors.addresses')->get();

        foreach ($all as $item)
        {
            if ($item->contractors->count())
            {
                dd($item->contractors->first()->toArray());
            }

        }
        dd(345);
        dd(Product::with('brand.image')->get()->toArray());

        $importer = new BrandStatisticImporter();

        if ($importer->putNomenclature(file_get_contents(storage_path('app/media/brands_statistics/nomenclatures/nomenclature.xls'))) &&
            $importer->import())
        {
            dd("success");
        } else
        {
            dd("put nom error");
        }
    }

    private function format_bytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'Kb', 'Mb', 'Gb', 'Tb'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
