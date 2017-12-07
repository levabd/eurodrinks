<?php namespace Allatrack\Eurodrinks\Controllers;

use Allatrack\Eurodrinks\Services\BrandStatisticImporter;
use Allatrack\Eurodrinks\Widgets\Error;
use Backend\Classes\Controller;
use Carbon\Carbon;
use BackendMenu;
use Validator;
use System\Classes\SettingsManager;
use Log;
use App;
/**
 * Stat Back-end Controller
 */
class Stat extends Controller {

    /**
     * @var BrandStatisticImporter
     */
    private $statImporter;

    public function __construct(BrandStatisticImporter $statImporter)
    {
        parent::__construct();
        $this->statImporter = $statImporter;

        $errorWidget = new Error($this);
        $errorWidget->bindToController();
    }

    public function index()
    {

        App::setLocale('ru');
        $this->pageTitle = trans("allatrack.eurodrinks::lang.stat.menu_title");
        $this->addCss('/plugins/allatrack/eurodrinks/assets/css/brand_stat/style.css');
        $statisticsPath = storage_path(config("allatrack.eurodrinks::stat_importer.stat_file_path"));
        $this->vars['brandName'] = $this->user->brand ? $this->user->brand->slug : trans('allatrack.eurodrinks::lang.brand.errors.no_brand');


        if ( ! file_exists($statisticsPath))
        {
            $this->vars['errors'][] = trans('allatrack.eurodrinks::lang.brand.errors.stat_file_is_absent');
        }

        $user = $this->user;

        if ($this->user->is_superuser)
        {
            $this->vars['brandName'] = trans('allatrack.eurodrinks::lang.superuser');
        } else
        {
            // todo: доделать
        }

        if ( ! $user->brand)
        {
            $this->vars['errors'][] = trans('allatrack.eurodrinks::lang.brand.errors.user_not_assigned');
        }

        try
        {
            $statisticsFull = json_decode(file_get_contents($statisticsPath), true);
        } catch (\Exception $e)
        {
            $this->vars['errors'][] = trans('allatrack.eurodrinks::lang.brand.errors.file_open_error', ['error' => $e->getMessage()]);
            $this->widget->errorsWidget->setErrors($this->vars['errors']);

            return;
        }

        if ( ! isset($statisticsFull[$user->brand_id]))
        {
            $this->vars['errors'][] = trans('allatrack.eurodrinks::lang.brand.errors.stat_file_is_absent');
        }

        if (isset($this->vars['errors']))
        {
            $this->widget->errorsWidget->setErrors($this->vars['errors']);

            return;
        }

        $statisticsPerBrand = $statisticsFull[$user->brand_id];
        $statTabTitles = array_keys($statisticsPerBrand);
        if (count($statTabTitles) === 0)
        {
            $this->vars['errors'][] = trans('allatrack.eurodrinks::lang.brand.errors.nothing_to_show');

            return;
        }

        $this->vars['previousYear'] = $statTabTitles[0];
        $this->vars['currentYear'] = $statTabTitles[1];
        $this->vars['percentageDifferenceTitle'] = trans('allatrack.eurodrinks::lang.brand.percentage_difference');
        $this->vars['percentageDifferenceKey'] = 'percentage_difference';

        // rename percentage key in $statisticsPerBrand array
        $percentageTable = $statisticsPerBrand["0"];
        unset($statisticsPerBrand["0"]);
        $statisticsPerBrand['percentage_difference'] = $percentageTable;

        $this->vars['statisticsPerBrand'] = $statisticsPerBrand;
    }

    public function upload()
    {
        BackendMenu::setContext('October.System', 'system');
        SettingsManager::setContext('Allatrack.Eurodrinks', 'upload_brands_stat');

        $this->pageTitle = trans('allatrack.eurodrinks::lang.brand.stat_upload');

        $statFilePath = storage_path(config('allatrack.eurodrinks::stat_importer.stat_file_path'));

        if (request()->isMethod('post'))
        {
            $requestHasFile = request()->hasFile('stat_file');

            $validator = Validator::make(
                [
                    'stat_file' => request()->stat_file,
                    'extension' => $requestHasFile ? strtolower(request()->stat_file->getClientOriginalExtension()) : "",
                ],
                [
                    'stat_file' => 'required',
                    'extension' => 'required|in:xlsx,xls',
                ], [
                    'stat_file.required' => trans('allatrack.eurodrinks::validation.stat_file_required'),
                    'extension.in'       => trans('allatrack.eurodrinks::validation.stat_file_in', ['range' => "xlsx,xls"]),
                ]
            );

            if ($validator->fails())
            {
                $this->widget->errorsWidget
                    ->setErrors(! $requestHasFile ? $validator->errors()->get('stat_file') : $messages = $validator->errors()->all());

                return;
            }

            // store file
            request()->file("stat_file")->move(storage_path('app/media/brands_statistics/nomenclatures'), "nomenclature_imported.xls");

            // put file in importer
            $this->statImporter->putNomenclature(file_get_contents(storage_path('app/media/brands_statistics/nomenclatures/nomenclature_imported.xls')));

            if ( ! $this->statImporter->import())
            {
                $this->widget->errorsWidget->setErrors($this->statImporter->getErrors());

                return;
            }

            if (count($this->statImporter->getErrors()))
            {
                $this->widget->errorsWidget->setErrors($this->statImporter->getErrors());

                return;
            }

            $this->vars['success'] = true;
        }

        $this->vars['last_update'] = Carbon::createFromTimestampUTC(filemtime($statFilePath))
            ->setTimezone(config('app.timezone'))
            ->format(config('allatrack.eurodrinks::dt_format_d_m_y_h_i'));


        Log::info($this->format_bytes(memory_get_peak_usage(1)));
    }


    private function format_bytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'Kb', 'Mb', 'Gb', 'Tb'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    public function download()
    {
        if ( ! request()->has('fileName'))
        {
            return response("fileName not set");
        }

        $path = storage_path(request()->fileName);
        if (file_exists($path))
        {
            return response()->download($path);
        }

        return response("file not found " . $path);
    }

    public function getDirectionClass($contentKey, $rawValue)
    {
        if ($contentKey!='percentage_difference'){
            return '';
        }

        $rawValue = round(floatval($rawValue), 2, PHP_ROUND_HALF_UP);
        $cssClass='equal';
        if($rawValue>0){
            $cssClass="up";
        }  elseif ($rawValue<0){
            $cssClass="down";
        }
        return $cssClass;
    }

    public function getRawValue($rawValue)
    {
        return  round(floatval($rawValue), 2, PHP_ROUND_HALF_UP);
    }


}
