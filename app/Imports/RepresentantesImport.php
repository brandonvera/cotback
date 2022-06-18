<?php

namespace App\Imports;

use App\Models\Representante;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RepresentantesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Representante([
            'nombre'    => $row['nombre'],
            'apellido'  => $row['apellido'],
            'cargo'     => $row['cargo'],
            'telefono'  => $row['telefono'],
            'correo'    => $row['correo'],
            'direccion' => $row['direccion'],
            'estado'    => $row['estado'],
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
            'nombre'    => ['required', 'string'],
            'apellido'  => ['required', 'string'],
            'cargo'     => ['required', 'string'],
            'correo'    => ['string', 'email'],
            'direccion' => ['string', 'max:1000'],
            'estado'    => ['string', 'in:ACTIVO,INACTIVO'],
        ];
    }
}