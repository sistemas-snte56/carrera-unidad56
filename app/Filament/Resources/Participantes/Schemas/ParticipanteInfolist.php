<?php

namespace App\Filament\Resources\Participantes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\URL;

class ParticipanteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('folio'),
                TextEntry::make('numero_corredor')
                    ->numeric(),
                TextEntry::make('nombre'),
                TextEntry::make('apellido_paterno'),
                TextEntry::make('apellido_materno')
                    ->placeholder('-'),
                TextEntry::make('fecha_nacimiento')
                    ->date(),
                TextEntry::make('rama'),
                TextEntry::make('distancia'),
                TextEntry::make('tipo_corredor'),
                TextEntry::make('delegacion.id')
                    ->label('Delegacion')
                    ->placeholder('-'),
                TextEntry::make('correo'),
                TextEntry::make('telefono'),
                TextEntry::make('ine_path')
                    ->label('INE o credencial')
                    ->url(fn($record) => URL::temporarySignedRoute(
                        'admin.documento',
                        now()->addMinutes(10),
                        [
                            'participante' => $record->id,
                            'tipo' => 'ine',
                        ]
                    ))
                    ->openUrlInNewTab(),

                TextEntry::make('voucher_path')
                    ->label('Comprobante de pago')
                    ->url(fn($record) => URL::temporarySignedRoute(
                        'admin.documento',
                        now()->addMinutes(10),
                        [
                            'participante' => $record->id,
                            'tipo' => 'voucher',
                        ]
                    ))
                    ->openUrlInNewTab(),
                TextEntry::make('estatus'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
