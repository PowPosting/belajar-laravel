<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'db_province_data';
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $primaryKey = 'province_code';

    protected $fillable = [
        'province_name',
        'province_name_en',
        'province_code'
    ];

    /**
     * Relationship to PostalCodes
     */
    public function postalCodes()
    {
        return $this->hasMany(PostalCode::class, 'province_code', 'province_code');
    }
}
