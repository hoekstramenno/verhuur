<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Material
 * @package App
 */
class Material extends Model
{
    protected $table = 'material';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('remarksCount', function ($builder) {
            $builder->withCount('remarks');
        });


    }

    /**
     * @param $remark
     */
    public function addRemark($remark)
    {
        $this->remarks()->create($remark);
    }

    /**
     * Get the path of the material
     *
     * @return string
     */
    public function path()
    {
        return "/magazijn/materiaal/{$this->id}";
    }


    /**
     * Material has many remarks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remarks()
    {
        return $this->hasMany(MaterialRemark::class);
    }

    /**
     * Material has one type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function type()
    {
        return $this->hasOne(MaterialType::class);
    }

    /**
     * Material has one brand
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brand()
    {
        return $this->hasOne(MaterialBrand::class);
    }

    /**
     * Scope of Filters
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
