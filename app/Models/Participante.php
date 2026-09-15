<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Participante extends Model
{
    protected $table = 'participantes';
    protected $fillable = [
        'folio',
        'numero_corredor',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'rama',
        'distancia',
        'tipo_corredor',
        'delegacion_id',
        'correo',
        'telefono',
        'ine_path',
        'voucher_path',
        'estatus',
        'acuse_token'
    ];

    public function delegacion(): BelongsTo
    {
        return $this->belongsTo(Delegacion::class);
    }

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Participante $participante) {
            $participante->acuse_token = (string) Str::uuid();

            $participante->folio = 'CAR-' . now()->format('Y') . '-' . strtoupper(Str::random(6));

            $participante->numero_corredor =
                (static::max('numero_corredor') ?? 0) + 1;
        });
        
        static::saving(function (Participante $participante) {
            $participante->nombre = mb_strtoupper(
                trim($participante->nombre), 'UTF-8'
            );

            $participante->apellido_paterno = mb_strtoupper(
                trim($participante->apellido_paterno),
                'UTF-8'
            );

            $participante->apellido_materno = $participante->apellido_materno
                ? mb_strtoupper(trim($participante->apellido_materno), 'UTF-8')
                : null;
        });
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->nombre,
                $this->apellido_paterno,
                $this->apellido_materno,
            ])
            ->filter() //filter() elimina los valores vacíos o null
            ->implode(' '), // los une utilizando un espacio:
        );
    }
    
}
