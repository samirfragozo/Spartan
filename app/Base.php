<?php

namespace App;

use App\Traits\Uppercase;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string full_name
 */
class Base extends Model
{
    use Uppercase;

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'full_name', 'select_value',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'data',
    ];

    /**
     * The attributes that should be exported.
     *
     * @var array
     */
    protected $exported = [
        'full_name',
    ];

    /**
     * The data to build the layout.
     *
     * @var array
     */
    protected $layout = [];

    // Methods

    /**
     * @return array
     */
    public function getExport(): array
    {
        return $this->exported;
    }

    /**
     * Get the data to build the layout.
     *
     * @return array
     */
    public function getLayout(): array
    {
        return $this->layout;
    }

    /**
     * Set baseQuery variable
     *
     * @param string $field
     * @return array
     */
    public function select($field = 'select_value')
    {
        return $this->get()->sortBy($field)->pluck($field, 'id');
    }

    // Mutator

    /**
     * Mutator for the full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Mutator for the value to show in the select
     *
     * @return string
     */
    public function getSelectValueAttribute()
    {
        return $this->full_name;
    }
}
