<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialBrand extends Model
{
   protected $table = 'material_brand';
    protected $guarded = [];
    /**
     * A brand belongs to a Material
     */
    public function material()
    {
        return $this->belongsTo('App\Material');
    }
}
