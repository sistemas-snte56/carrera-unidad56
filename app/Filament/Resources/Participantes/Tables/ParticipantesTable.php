<?php

namespace App\Filament\Resources\Participantes\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\URL;


class ParticipantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('folio')
                    ->label('Folio')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('numero_corredor')
                    ->label('Número')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('nombre_completo')
                    ->label('Nombre completo')
                    ->getStateUsing(function ($record) {
                        return trim(
                            $record->nombre . ' ' .
                            $record->apellido_paterno . ' ' .
                            $record->apellido_materno
                        );
                    })
                    ->searchable(
                        query: function ($query, string $search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('nombre', 'like', "%{$search}%")
                                    ->orWhere('apellido_paterno', 'like', "%{$search}%")
                                    ->orWhere('apellido_materno', 'like', "%{$search}%");
                            });
                        }
                    ),

                TextColumn::make('fecha_nacimiento')
                    ->label('Fecha nacimiento')
                    ->date()
                    ->sortable(),

                TextColumn::make('rama')
                    ->label('Rama')
                    ->searchable(),

                TextColumn::make('distancia')
                    ->label('Distancia')
                    ->searchable(),

                TextColumn::make('tipo_corredor')
                    ->label('Tipo corredor')
                    ->searchable(),

                TextColumn::make('delegacion.delegacion')
                    ->label('Delegación')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('correo')
                    ->label('Correo')
                    ->searchable(),

                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable(),

                TextColumn::make('estatus')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'validado' => 'success',
                        'rechazado' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(
                        fn (string $state): string => ucfirst($state)
                    ),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                ActionGroup::make([
                    Action::make('ine')
                        ->label('Ver INE')
                        ->icon('heroicon-o-identification')
                        ->url(fn ($record) => URL::temporarySignedRoute(
                            'admin.documento',
                            now()->addMinutes(10),
                            [
                                'participante' => $record->id,
                                'tipo' => 'ine',
                            ]
                        ))
                        ->openUrlInNewTab()
                        ->visible(fn ($record) => filled($record->ine_path)),

                    Action::make('voucher')
                        ->label('Ver Voucher')
                        ->icon('heroicon-o-document-text')
                        ->url(fn ($record) => URL::temporarySignedRoute(
                            'admin.documento',
                            now()->addMinutes(10),
                            [
                                'participante' => $record->id,
                                'tipo' => 'voucher',
                            ]
                        ))
                        ->openUrlInNewTab()
                        ->visible(fn ($record) => filled($record->voucher_path)),
                    ViewAction::make(),
                    EditAction::make(),
                ])
                    ->label('Acciones')
                    ->icon('heroicon-o-ellipsis-vertical'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('cambiarEstatus')
                        ->label('Cambiar estatus')
                        ->icon('heroicon-o-arrow-path')
                        ->schema([
                            Select::make('estatus')
                                ->label('Nuevo estatus')
                                ->options([
                                    'pendiente' => 'Pendiente',
                                    'validado' => 'Validado',
                                    'rechazado' => 'Rechazado',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'estatus' => $data['estatus'],
                                ]);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
