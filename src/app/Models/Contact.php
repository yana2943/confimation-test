<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail'
    ];

    public function scopeSearch($query, $params)
    {
        if (!empty($params['keyword'])) {
            $query->where(function ($q) use ($params){
                $q->where('first_name', 'like', '%' . $params['keyword'] . '%')
                  ->orWhere('last_name', 'like', '%' . $params['keyword'] . '%')
                  ->orWhere('email', 'like', '%' . $params['keyword'] . '%');
            });
        }

          if (!empty($params['gender'])) {
            $query->where('gender', $params['gender']);
        }

        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

         if (!empty($params['date'])) {
            $query->whereDate('created_at', $params['date']);
        }

        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
