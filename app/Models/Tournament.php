<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
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
        'champion_id',
        'gender'
    ];


    /**
     * Get the player that owns the Tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'champion_id');
    }
}
