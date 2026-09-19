<?php

namespace App\Filament\Exports;

use App\Models\Participante;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ParticipanteExporter extends Exporter
{
    protected static ?string $model = Participante::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('folio')
                ->label('Folio'),

            ExportColumn::make('numero_corredor')
                ->label('Número de corredor')
                ->formatStateUsing(fn ($state) => str_pad($state, 5, '0', STR_PAD_LEFT)),

            ExportColumn::make('nombre')
                ->label('Nombre'),

            ExportColumn::make('apellido_paterno')
                ->label('Apellido paterno'),

            ExportColumn::make('apellido_materno')
                ->label('Apellido materno'),

            // ExportColumn::make('nombre_completo')
            //     ->label('Nombre completo')
            //     ->state(function (Participante $record): string {
            //         return trim(
            //             $record->nombre . ' ' .
            //             $record->apellido_paterno . ' ' .
            //             $record->apellido_materno
            //         );
            //     }),

            ExportColumn::make('fecha_nacimiento')
                ->label('Fecha de nacimiento')
                ->state(function (Participante $record): string {
                    return $record->fecha_nacimiento?->format('d/m/Y') ?? '';
                }),

            ExportColumn::make('rama')
                ->label('Rama'),

            ExportColumn::make('distancia')
                ->label('Distancia'),

            ExportColumn::make('tipo_corredor')
                ->label('Tipo de corredor'),

            ExportColumn::make('delegacion')
                ->label('Delegación')
                ->state(function (Participante $record): string {
                    return $record->delegacion?->delegacion ?? '';
                }),

            ExportColumn::make('correo')
                ->label('Correo'),

            ExportColumn::make('telefono')
                ->label('Teléfono'),

            ExportColumn::make('estatus')
                ->label('Estatus'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de participantes ha terminado y '
            . number_format($export->successful_rows)
            . ' '
            . str('registro')->plural($export->successful_rows)
            . ' fueron exportados correctamente.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '
                . number_format($failedRowsCount)
                . ' '
                . str('registro')->plural($failedRowsCount)
                . ' no pudieron ser exportados.';
        }

        return $body;
    }
}
