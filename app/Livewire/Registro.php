<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Delegacion;
use App\Models\Region;
use App\Models\Participante;
use Livewire\WithFileUploads;

use App\Mail\RegistroCarreraMail;
use Illuminate\Support\Facades\Mail;





class Registro extends Component
{
    use WithFileUploads;


    public $nombre = '';
    public $apellido_paterno = '';
    public $apellido_materno = '';
    public $fecha_nacimiento = '';
    public $rama = '';
    public $distancia = '';
    public $tipo_corredor = '';
    public $region_id = '';

    public $delegacion_id = '';
    public $regiones = [];
    public $delegaciones = [];

    public $correo = '';
    public $telefono = '';

    public $ine;
    public $voucher;

    public $registroExitoso = false;
    public $folioGenerado = '';
    public $numeroCorredorGenerado = '';

    public $acuseTokenGenerado = '';


    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',

            'fecha_nacimiento' => 'required|date',
            'rama' => 'required|in:femenil,varonil',
            'distancia' => 'required|in:3K,5K,10K',

            'tipo_corredor' => 'required|in:agremiado,publico',

            'region_id' => 'required_if:tipo_corredor,agremiado|nullable|exists:regiones,id',
            'delegacion_id' => 'required_if:tipo_corredor,agremiado|nullable|exists:delegaciones,id',

            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:10',

            'ine' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'voucher' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    public function updatedRegionId($value)
    {
        $this->delegacion_id = '';

        if ($value) {
            $this->delegaciones = Delegacion::where('region_id', $value)
                ->orderBy('delegacion')
                ->get();
        } else {
            $this->delegaciones = [];
        }
    }

    public function continuar()
    {
        $this->validate();

        if (
            $this->tipo_corredor === 'agremiado' &&
            $this->delegacion_id
        ) {
            $delegacionPertenece = Delegacion::where('id', $this->delegacion_id)
                ->where('region_id', $this->region_id)
                ->exists();

            if (! $delegacionPertenece) {
                $this->addError(
                    'delegacion_id',
                    'La delegación seleccionada no pertenece a la región indicada.'
                );

                return;
            }
        }

        $inePath = $this->ine->store('participantes/ine', 'local');
        $voucherPath = $this->voucher->store('participantes/vouchers', 'local');

        $participante = Participante::create([
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'rama' => $this->rama,
            'distancia' => $this->distancia,
            'tipo_corredor' => $this->tipo_corredor,
            'delegacion_id' => $this->tipo_corredor === 'agremiado'
                ? $this->delegacion_id
                : null,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'ine_path' => $inePath,
            'voucher_path' => $voucherPath,
        ]);

        $this->folioGenerado = $participante->folio;


        Mail::to($participante->correo)->send(
            new RegistroCarreraMail($participante)
        );


        $this->acuseTokenGenerado = $participante->acuse_token;
        $this->numeroCorredorGenerado = str_pad(
            $participante->numero_corredor,
            5,
            '0',
            STR_PAD_LEFT
        );
        $this->registroExitoso = true;

        // Limpiar formulario
        $this->reset([
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'fecha_nacimiento',
            'rama',
            'distancia',
            'tipo_corredor',
            'region_id',
            'delegacion_id',
            'correo',
            'telefono',
            'ine',
            'voucher',
        ]);

        // Limpiar las colecciones
        $this->regiones = Region::orderBy('id')->get();
        $this->delegaciones = [];

    }

    public function updatedTipoCorredor($value)
    {
        if ($value === 'publico') {
            $this->region_id = '';
            $this->delegacion_id = '';
            $this->delegaciones = [];
        }
    }    

    public function render()
    {
        $this->regiones = Region::orderBy('id')->get();

        return view('livewire.registro');
    }    
}