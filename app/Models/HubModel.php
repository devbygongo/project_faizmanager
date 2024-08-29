<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubModel extends Model
{
    use HasFactory;

    protected $table = 't_hub';

    protected $fillable = [
        'name',
        'year',
        'event',
        'hub',
        'prev_paid',
        'added_by',
        'last_modified',
        'short_closed',
    ];

    // Define the relationship with the Year model
    public function get_year()
    {
        return $this->belongsTo(YearModel::class, 'year', 'year'); 
    }
}
