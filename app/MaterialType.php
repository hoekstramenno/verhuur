<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    /**
     * @var string
     */
    protected $table = 'material_type';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * A type belongs to a Material
     */
    public function material()
    {
        return $this->belongsTo('App\Material');
    }
}
