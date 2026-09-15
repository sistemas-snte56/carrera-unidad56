<?php

namespace App\Filament\Resources\Participantes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class ParticipanteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('folio')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('numero_corredor')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric(),

                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

                TextInput::make('apellido_paterno')
                    ->required()
                    ->maxLength(255),

                TextInput::make('apellido_materno')
                    ->nullable()
                    ->maxLength(255),

                DatePicker::make('fecha_nacimiento')
                    ->required()
                    ->native(false),

                Select::make('rama')
                    ->required()
                    ->options([
                        'femenil' => 'Femenil',
                        'varonil' => 'Varonil',
                    ]),

                Select::make('distancia')
                    ->required()
                    ->options([
                        '3K' => '3 km',
                        '5K' => '5 km',
                        '10K' => '10 km',
                    ]),

                Select::make('tipo_corredor')
                    ->required()
                    ->options([
                        'agremiado' => 'Agremiado',
                        'publico' => 'Público en general',
                    ]),

                Select::make('delegacion_id')
                    ->label('Delegación')
                    ->relationship('delegacion', 'delegacion')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('correo')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('telefono')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                FileUpload::make('ine_path')
                    ->label('INE o credencial de elector')
                    ->required()
                    ->disk('local')
                    ->directory('participantes/ine')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'application/pdf',
                    ])
                    ->maxSize(5120),

                FileUpload::make('voucher_path')
                    ->label('Comprobante de pago')
                    ->required()
                    ->disk('local')
                    ->directory('participantes/vouchers')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'application/pdf',
                    ])
                    ->maxSize(5120),




                Select::make('estatus')
                    ->label('Estatus')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'validado' => 'Validado',
                        'rechazado' => 'Rechazado',
                    ])
                    ->required(),

                            
            ]);




                            
        }
}