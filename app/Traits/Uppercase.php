<?php

namespace App\Traits;

/**
 * Save your data on UpperCase
 * 
 */
trait Uppercase
{
    /**
     * Default params that will be saved on lowercase
     * 
     * @var array No Uppercase keys
     */
    protected $noUppercase = [
        'password',
        'username',
        'email',
        'remember_token',
        'token',
        'picture'
    ];

    /**
     * String to Uppercase method
     * 
     * @param  string  $key
     * @param  string  $value
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);
        
        if(is_string($value)){
            if($this->noUpper !== null){
                if (!in_array($key, $this->noUppercase)) {
                    if(!in_array($key, $this->noUpper)){
                        $this->attributes[$key] = trim(mb_strtoupper($value, "UTF-8"));
                    }
                }
            } else {
                if (!in_array($key, $this->noUppercase)) {
                    $this->attributes[$key] = trim(mb_strtoupper($value, "UTF-8"));
                }
            }
        }
    }    
}
