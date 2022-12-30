<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Model properties for mass assignment
     *
     *@var array
     * */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'strenght',
        'speed',
        'reaction',
        'tournaments_won'
    ];

    /**
     * Get player's full name
     *
     **/
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    /**
     * Get the player that owns the Tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function player(): HasMany
    {
        return $this->hasMany(Tournament::class, 'champion_id');
    }
}
