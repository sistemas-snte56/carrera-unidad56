<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Delegacion extends Model
{
    protected $table = 'delegaciones';
    protected $fillable = ['region_id', 'delegacion', 'sede'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    } 

    public function participantes(): HasMany
    {
        return $this->hasMany(Participante::class);
    }
    
    protected function delegacionCompleta(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->delegacion . ' - ' . $this->sede,
        );
    }

}
