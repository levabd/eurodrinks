<?php namespace Allatrack\Eurodrinks\Models;

use Allatrack\Eurodrinks\Traits\BrandOptions;
use Model;

/**
 * Brand Model
 */
class Brand extends Model
{
    use \October\Rain\Database\Traits\Validation;


    public $timestamps = false;

    public $rules = [
        'slug' => 'required|unique:allatrack_eurodrinks_brands'
    ];

    public $customMessages = [
        'slug.required' => 'allatrack.eurodrinks::lang.slug_required',
        'slug.unique' => 'allatrack.eurodrinks::lang.slug_unique'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'allatrack_eurodrinks_brands';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name'];

    protected $appends = ['product_chunk_by_four', 'product_chunk_by_two'];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'user' => ['Backend\Models\User', 'table' => 'backend_users']
    ];
    public $hasMany = [
        'products' => 'Allatrack\Eurodrinks\Models\Product'
    ];
    public $belongsTo = [];
    public $belongsToMany = [
        'contractors' => ['Allatrack\Eurodrinks\Models\Contractor']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'image' => 'System\Models\File',
        'public' => false
    ];
    public $attachMany = [];

    public function getProductChunkByFourAttribute()
    {
        if ($this->products()->count()>0){

            return $this->products()->where('is_displayed', true)->with('image')->get()->chunk(4);
        }
        return $this->products;
    }

    public function getProductChunkByTwoAttribute()
    {
        if ($this->products()->count()>0){
            return $this->products()->where('is_displayed',true)->with('image')->get()->chunk(2);
        }
        return $this->products;
    }
}
