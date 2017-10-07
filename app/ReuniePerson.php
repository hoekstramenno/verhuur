<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Material
 * @package App
 */
class ReuniePerson extends Model
{
    protected $table = 'reunie_person';
    protected $guarded = [];



    /**
     * Get the path of the material
     *
     * @return string
     */
    public function path()
    {
        return "/reunie/person/{$this->id}";
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
