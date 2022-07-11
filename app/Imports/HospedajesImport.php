<?php

namespace App\Imports;

use App\Models\Hospedaje;
use App\Models\Municipio;
use App\Models\Representante;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HospedajesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    private $municipio;
    private $representante;

    public function __construct()
    {
        $this->municipio = Municipio::pluck('id', 'nombre');
        
        if(!($this->representante == null || $this->representante == "")){
           $this->representante = Representante::pluck('id', 'persona'); 
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Hospedaje([
            'razon_social'        => $row['razon_social'],
            'establecimientos'    => $row['establecimientos'],
            'telefono'            => $row['telefono'],
            'correo'              => $row['correo'],
            'direccion_principal' => $row['direccion_principal'],
            'estado'              => $row['estado'],
            'id_municipio'        => $this->municipio[$row['municipio']],
            'id_representantes'   => $this->representante[$row['representante_legal']]
        ]);
    }

    public function batchSize():int
    {
        return 5;
    }

    public function chunkSize():int
    {
        return 5;
    }

    public function rules(): array
    {
        return [
            'razon_social' => ['required', 'string', 'unique:hospedajes'],
            'estado'       => ['required', 'string', 'in:ACTIVO,INACTIVO'],
            'municipio' => ['required'],
        ];
    }
}
