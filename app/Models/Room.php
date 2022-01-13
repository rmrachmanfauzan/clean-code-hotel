<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    
    protected $guarded = ['id'];
    protected $fillable = [
        'name','type',
    ];

   

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel');
    }

    public function scopeFilter($query, $filter)
    {
        foreach ($filter as $key => $value) {
            if ($key == 'keyword' && !empty($value)) {
                $query->where(function ($query2) use ($value) {
                    $query2->where('name', 'like', '%' . $value . '%');
                });
            }
        }
        return $query;
    }

    public static function getValidationRules(){
        return[
            'name'    => 'required',
            'address'    => 'required',
        ];
    }
}
