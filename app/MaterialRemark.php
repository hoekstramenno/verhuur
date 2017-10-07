<?php

namespace App;

use App\Material;
use Illuminate\Database\Eloquent\Model;

class MaterialRemark extends Model
{
    /**
     * @var string
     */
    protected $table = 'material_remark';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['owner'];

    /**
     * A remark belongs to an owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A remarks belongs to a Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
