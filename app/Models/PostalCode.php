<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    protected $table = 'db_postal_code_data';
    protected $connection = 'pgsql';
    public $timestamps = false;

    protected $fillable = [
        'urban',
        'sub_district',
        'city',
        'province_code',
        'postal_code'
    ];

    /**
     * Relationship to Province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    /**
     * Search postal codes by postal code number
     */
    public function scopeSearchByPostalCode($query, $postalCode)
    {
        return $query->where('postal_code', 'LIKE', $postalCode . '%')
            ->limit(10);
    }
}
