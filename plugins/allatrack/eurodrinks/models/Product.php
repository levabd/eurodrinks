<?php namespace Allatrack\Eurodrinks\Models;


use Allatrack\Eurodrinks\Traits\BrandOptions;
use Model;

/**
 * Product Model
 */
class Product extends Model {

    use \October\Rain\Database\Traits\Validation;
    use BrandOptions;

    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'allatrack_eurodrinks_products';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name_ru', 'brand_id', 'capacity'];

    /**
     * Validation rules
     */
    public $rules = [
        'name_ru'        => 'between:0,255',
        'name_en'        => 'required|between:3,255',
        'name_uk'        => 'between:0,255',
//        'capacity'       => 'required|numeric|digits_between:0,4|regex:/[0-9.,].+$/',
        'brand_id'       => 'required|exists:allatrack_eurodrinks_brands,id',
        'description_ru' => 'between:0,3000',
        'description_uk' => 'between:0,3000',
        'description_en' => 'between:0,3000',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];

    public $hasMany = [];

    public $belongsTo = [
        'brand' => ['Allatrack\Eurodrinks\Models\Brand', 'table' => 'allatrack_eurodrinks_brands'],
    ];

    public $belongsToMany = [
        'contractors' => ['Allatrack\Eurodrinks\Models\Contractor', 'table' => 'product_contractor'],
    ];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [
        'image' => 'System\Models\File',
        'public' => true
    ];

    public $attachMany = [];

    public $hasManyThrough = [];
}
