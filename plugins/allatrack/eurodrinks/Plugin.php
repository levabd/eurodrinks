<?php namespace Allatrack\Eurodrinks;

use Allatrack\Eurodrinks\Console\RemoveTemporalUsers;
use Allatrack\Eurodrinks\Models\Brand;
use Backend\Models\User;
use Allatrack\Eurodrinks\Console\Dev;
use Backend;
use Event;
use Indikator\News\Models\Posts;
use System\Classes\PluginBase;
use BackendAuth;
use Backend\Models\User as UserModel;
use App;
use Log;

/**
 * Eurodrinks Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * @var array Plugin dependencies
     */
    public $require = ['Indikator.News', 'RainLab.Translate', 'RainLab.Pages'];

    /**
     * Returns information about this plugin.
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Eurodrinks',
            'description' => 'No description provided yet...',
            'author'      => 'allatrack@peshkov_maxim',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('eurodrinks.dev', Dev::class);
        $this->registerConsoleCommand('eurodrinks.remove_temporal_users', RemoveTemporalUsers::class);

        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }

    /**
     * Boot method, called right before the request route.
     * @return array
     */
    public function boot()
    {

        Event::listen('backend.menu.extendItems', function ($navigationManager) {
            if (BackendAuth::check() && ! BackendAuth::getUser()->is_superuser)
            {
                $navigationManager->removeMainMenuItem('October.System', 'system');
            }
        });

        UserModel::extend(function ($model) {

            $model->belongsTo['brand'] = ['Allatrack\Eurodrinks\Models\Brand', 'table' => 'allatrack_eurodrinks_brands'];
            $model->bindEvent('model.beforeValidate', function () use ($model) {

                if ($model->insert_update !== "true")
                {
                    return;
                }
                if ($model->temporal_user)
                {
                    $model->rules['available_until'] = 'required';
                    $model->customMessages['available_until.required'] = trans('backend::lang.validation.available_until');
                    $model->setPermissionsAttribute(json_encode(['allatrack.eurodrinks.see_presentations' => true]));
                } else
                {
                    unset($model->available_until);
                }

                if ($model->use_brand)
                {
                    $model->rules['brand_id'] = 'required|exists:allatrack_eurodrinks_brands,id';
                    $model->customMessages['brand_id.required'] = trans('backend::lang.validation.brand_id');
                } else
                {
                    unset($model->brand_id);
                }

                if ($model->exists && ! $model->use_brand)
                {
                    $model->brand_id = null;
                }

                unset($model->temporal_user);
                unset($model->use_brand);
                unset($model->insert_update);
            });
        });

        // Extend all backend list usage
        Event::listen('backend.list.extendColumns', function ($widget) {

            // Only for the User model
            if ( ! $widget->model instanceof UserModel)
            {
                return;
            }

            // Add an extra birthday column
            $widget->addColumns([
                'brand' => [
                    'label'    => trans('allatrack.eurodrinks::lang.brand.one'),
                    'relation' => 'brand',
                    'select'   => 'slug',
                ]
            ]);

            // Remove a Surname column
            $widget->removeColumn('email');
        });

        // Extend all backend form usage
        Event::listen('backend.form.extendFields', function ($widget) {
            // Only for the User model
            if ( ! $widget->model instanceof User)
            {
                return;
            }

            // Add an extra birthday field
            $widget->addTabFields([
                'use_brand'       => [
                    'context' => ['create', 'update'],
                    'type'    => 'checkbox',
                    'label'   => 'backend::lang.user.use_brand',
                    'default' => 'false'
                ],
                'brand_id'        => [
                    'context'     => ['create', 'update'],
                    'type'        => 'dropdown',
                    'label'       => 'backend::lang.user.brand',
                    'emptyOption' => 'backend::lang.user.select_brand',
                    'trigger'     => [
                        'action'    => 'show|empty',
                        'field'     => 'use_brand',
                        'condition' => 'checked',
                    ],
                ],
                'temporal_user'   => [
                    'context' => ['create', 'update'],
                    'type'    => 'checkbox',
                    'label'   => 'backend::lang.user.temporal_user',
                    'default' => 'false'
                ],
                'available_until' => [
                    'context' => ['create', 'update'],
                    'type'    => 'datepicker',
                    'label'   => 'backend::lang.user.available_until',
                    'comment' => 'backend::lang.user.available_until_comment',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'temporal_user',
                        'condition' => 'checked',
                    ],
                ],
                'insert_update'   => [
                    'context' => ['create', 'update'],
                    'type'    => 'partial',
                    'path'    => '$/allatrack/eurodrinks/models/user/_hidden_field.htm'
                ],
            ]);
        });

    }

    /**
     * Registers any front-end components implemented in this plugin.
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

//        return [
//            'Allatrack\Eurodrinks\Components\StatUploader' => 'StatUploader',
//        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     * @return array
     */
    public function registerPermissions()
    {
        // return []; // Remove this line to activate

        return [
            'allatrack.eurodrinks.manage_brands'     => [
                'tab'   => 'Brands',
                'label' => 'Manage Brands'
            ],
            'allatrack.eurodrinks.see_stat'          => [
                'tab'   => 'Eurodrinks',
                'label' => 'See my stat'
            ],
            'allatrack.eurodrinks.see_presentations' => [
                'tab'   => 'Presentations',
                'label' => 'allatrack::lang.presentations'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     * @return array
     */
    public function registerNavigation()
    {
//        return []; // Remove this line to activate

        return [
            'eurodrinks'    => [
                'label'       => trans('allatrack.eurodrinks::lang.eurodinks_statistics'),
                'url'         => Backend::url('allatrack/eurodrinks/stat'),
                'icon'        => 'icon-line-chart',
                'permissions' => ['allatrack.eurodrinks.see_stat'],
                'order'       => 500,
            ],
            'presentations' => [
                'label'       => trans('allatrack.eurodrinks::lang.presentations'),
                'url'         => url('/presentations'),
                'icon'        => 'icon-leaf',
                'permissions' => ['allatrack.eurodrinks.see_presentations'],
                'order'       => 100,
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'upload_brands_stat'  => [
                'label'       => trans('allatrack.eurodrinks::lang.brand.stat_upload'),
                'description' => trans('allatrack.eurodrinks::lang.brand.stat_upload_description'),
                'category'    => 'eurodrinks',
                'icon'        => 'oc-icon-download',
                'url'         => Backend::url('allatrack/eurodrinks/stat/upload'),
                'order'       => 300,
                'context'     => 'system',
                'code'        => 'brands_stat_upload',
                'keywords'    => 'geography place placement',
                'permissions' => ['allatrack.eurodrinks.manage_brands'],
            ],
            'manage_brands'       => [
                'label'       => trans('allatrack.eurodrinks::lang.brand.title'),
                'description' => trans('allatrack.eurodrinks::lang.brand.manage_title'),
                'category'    => 'eurodrinks',
                'icon'        => 'icon-black-tie',
                'url'         => Backend::url('allatrack/eurodrinks/brands'),
                'order'       => 400,
                'context'     => 'system',
                'code'        => 'brands_manage',
                'keywords'    => 'brand company',
                'permissions' => ['allatrack.eurodrinks.manage_brands'],
            ],
            'manager_products'    => [
                'label'       => trans('allatrack.eurodrinks::lang.product.title'),
                'description' => trans('allatrack.eurodrinks::lang.product.manage_title'),
                'category'    => 'eurodrinks',
                'icon'        => 'icon-align-justify',
                'url'         => Backend::url('allatrack/eurodrinks/products'),
                'order'       => 500,
                'context'     => 'system',
                'code'        => 'products',
                'keywords'    => 'product erdpy',
                'permissions' => ['allatrack.eurodrinks.manage_brands'],
            ],
            'manager_contractors' => [
                'label'       => trans('allatrack.eurodrinks::lang.contractor.title'),
                'description' => trans('allatrack.eurodrinks::lang.contractor.manage_title'),
                'category'    => 'eurodrinks',
                'icon'        => 'icon-american-sign-language-interpreting',
                'url'         => Backend::url('allatrack/eurodrinks/contractors'),
                'order'       => 600,
                'context'     => 'system',
                'code'        => 'contractors',
                'keywords'    => 'contractors sales company',
                'permissions' => ['allatrack.eurodrinks.manage_contractors'],
            ],
            'manager_addresses'   => [
                'label'       => trans('allatrack.eurodrinks::lang.address.title'),
                'description' => trans('allatrack.eurodrinks::lang.address.manage_title'),
                'category'    => 'eurodrinks',
                'icon'        => 'icon-map',
                'url'         => Backend::url('allatrack/eurodrinks/addresses'),
                'order'       => 700,
                'context'     => 'system',
                'code'        => 'addresses',
                'keywords'    => 'addresses house street',
                'permissions' => ['allatrack.eurodrinks.manage_addresses'],
            ],
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->command('eurodrinks:remove-temporal-users')->everyFiveMinutes();
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                // A local method, i.e $this->makeTextAllCaps()
                'handle_news_date' => [$this, 'handleNewsDate']
            ]
        ];
    }

    public function handleNewsDate($date)
    {

        if (is_null($date)){
            return "No data in post";
        }

        return trans('allatrack.eurodrinks::lang.months_by_number.'.$date->month, [
            'd'=>$date->day,
            'y'=>$date->year
        ]);
    }
}
