<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name', 'address',
    ];

    // Relationship
    public function hotel()
    {
        return $this->belongsToMany('App\Models\User','user_hotel', 'hotel_Id','user_id');
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

    // Validation
    public static function getValidationRules()
    {
        return 
        [
            'name'                  => 'required',
            'address'               => 'required',
        ];
    }

}
