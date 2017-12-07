<?php
namespace Allatrack\Eurodrinks\Traits;

use Allatrack\Eurodrinks\Models\Brand;

trait BrandOptions {
    public function getBrandIdOptions()
    {
        $result = [];
        foreach (Brand::all() as $brand) {
            $result[$brand->id] = [$brand->import_name];
        }
        return $result;
    }

}