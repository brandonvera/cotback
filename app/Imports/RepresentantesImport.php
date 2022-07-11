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
            'codigo'    => $row['codigo'],
            'persona'   => $row['persona'],
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

    public function rules():array
    {
        return [
            "codigo"    => "required|string|regex:/[COD]/|regex:/[0-9]/|starts_with:COD|min:8|max:8|unique:representantes",
            'persona'   => ['required', 'string'],
            "telefono"  => "nullable|string|regex:/[0-9]/|min:11|max:11",
            "correo"    => "nullable|string|email",
            "direccion" => "nullable|string|max:1000",
            'estado'    => ['required', 'required' ,'string', 'in:ACTIVO,INACTIVO'],
        ];
    }
}
