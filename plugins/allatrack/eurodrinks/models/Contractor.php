<?php namespace Allatrack\Eurodrinks\Models;

use Model;

/**
 * Contractor Model
 */
class Contractor extends Model {

    use \October\Rain\Database\Traits\Validation;

    public $timestamps = false;

    public $rules = [
        'name_ru'       => 'required|max:255',
        'name_en'       => 'max:255',
        'name_uk'       => 'max:255',
        'edrpoy'        => 'digits:8',
        'is_group'      => 'boolean',
        'slug'          => 'required|unique:allatrack_eurodrinks_contractors',
        'import_name'   => 'unique:allatrack_eurodrinks_contractors|max:255',
        'contractor_id' => 'exists:allatrack_eurodrinks_contractors,id',
    ];

    public $customMessages = [
        'slug.required' => 'allatrack.eurodrinks::lang.slug_required',
        'slug.unique'   => 'allatrack.eurodrinks::lang.slug_unique'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'allatrack_eurodrinks_contractors';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'edrpoy',
        'contractor_id',
        'is_group',
        'created_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];

    public $hasMany = [

    ];

    public $belongsToMany = [
        'addresses' => ['Allatrack\Eurodrinks\Models\Address', 'table'=>'contractor_address'],
        'brands' => ['Allatrack\Eurodrinks\Models\Brand', 'table' => 'brand_contractor']
    ];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];

    public function getContractorIdOptions()
    {
        $result = [];
        foreach (Contractor::all() as $contractor)
        {
            $result[$contractor->id] = [$contractor->import_name];
        }

        return $result;
    }

    public function getAddressOptions()
    {
        $result = [];
        foreach ($this->addresses as $address)
        {
            $result[$address->id] = [$address->name_en];
        }

        return $result;
    }

}
