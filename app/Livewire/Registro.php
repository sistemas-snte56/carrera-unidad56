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

    public function mount()
    {
        // Carga inicial única de regiones para optimizar las consultas SQL
        $this->regiones = Region::orderBy('id')->get();
    }

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
            'telefono' => 'required|digits:10',
            'ine' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'voucher' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'nombre' => 'nombre',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'rama' => 'rama o género',
            'distancia' => 'distancia',
            'tipo_corredor' => 'tipo de corredor',
            'region_id' => 'región',
            'delegacion_id' => 'delegación',
            'correo' => 'correo electrónico',
            'telefono' => 'número de teléfono',
            'ine' => 'identificación (INE)',
            'voucher' => 'comprobante de pago',
        ];
    }

    protected function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'required_if' => 'El campo :attribute es obligatorio para participantes agremiados.',
            'email' => 'Ingresa una dirección de :attribute válida.',
            'digits' => 'El :attribute debe contener exactamente 10 dígitos numéricos.',
            'mimes' => 'El archivo de :attribute debe estar en formato JPG, PNG o PDF.',
            'exists' => 'La opción seleccionada para :attribute no es válida.',
            'ine.max' => 'La imagen o PDF del INE no debe pesar más de 5 MB.',
            'voucher.max' => 'El archivo del comprobante de pago no debe pesar más de 5 MB.',
        ];
    }

    public function updatedTipoCorredor($value)
    {
        if ($value === 'publico') {
            $this->region_id = '';
            $this->delegacion_id = '';
            $this->delegaciones = [];
        }
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
        // Ejecuta la validación combinando rules(), validationAttributes() y messages()
        $this->validate();

        // Validar coherencia de Delegación vs Región si es agremiado
        if ($this->tipo_corredor === 'agremiado' && $this->delegacion_id) {
            $delegacionPertenece = Delegacion::where('id', $this->delegacion_id)
                ->where('region_id', $this->region_id)
                ->exists();

            if (!$delegacionPertenece) {
                $this->addError(
                    'delegacion_id',
                    'La delegación seleccionada no corresponde a la región elegida.'
                );
                return;
            }
        }

        // Guardar archivos subidos
        $inePath = $this->ine->store('participantes/ine', 'local');
        $voucherPath = $this->voucher->store('participantes/vouchers', 'local');

        // Insertar en Base de Datos
        $participante = Participante::create([
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'rama' => $this->rama,
            'distancia' => $this->distancia,
            'tipo_corredor' => $this->tipo_corredor,
            'delegacion_id' => $this->tipo_corredor === 'agremiado' ? $this->delegacion_id : null,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'ine_path' => $inePath,
            'voucher_path' => $voucherPath,
        ]);

        // Formatear folios para confirmación y envío
        $this->folioGenerado = $participante->folio;
        $this->acuseTokenGenerado = $participante->acuse_token;
        $this->numeroCorredorGenerado = str_pad(
            $participante->numero_corredor,
            5,
            '0',
            STR_PAD_LEFT
        );

        // Envío de correo electrónico
        Mail::to($participante->correo)->send(
            new RegistroCarreraMail($participante)
        );

        $this->registroExitoso = true;

        // Limpiar el estado del formulario
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

        $this->delegaciones = [];
    }

    public function render()
    {
        return view('livewire.registro');
    }
}