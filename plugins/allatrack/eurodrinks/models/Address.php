<?php namespace Allatrack\Eurodrinks\Models;

use Model;

/**
 * Address Model
 */
class Address extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $timestamps = false;

    public $rules = [
        'name_en'        => 'required|between:3,255',
        'name_ru'        => 'between:0,255',
        'name_uk'        => 'between:0,255',
        'latitude'       => 'required|numeric|regex:/[0-9.].+$/',
        'longitude'      => 'required|numeric|regex:/[0-9.].+$/',
    ];

    public $customMessages = [
        'latitude.required' => 'allatrack.eurodrinks::lang.address.select_on_map',
        'longitude.required' => 'allatrack.eurodrinks::lang.address.select_on_map'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'allatrack_eurodrinks_addresses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'contractors' => ['Allatrack\Eurodrinks\Models\Contractor', 'table'=>'contractor_address'],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
