<?php

namespace App\Imports;

use App\Models\AtractivoCultural;
use App\Models\Municipio;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CulturalesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    private $municipio;

    public function __construct()
    {
        $this->municipio = Municipio::pluck('id', 'nombre');
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AtractivoCultural([
            'nombre'       => $row['nombre'],
            'direccion'    => $row['direccion'],
            'estado'       => $row['estado'],
            'id_municipio' => $this->municipio[$row['municipio']],
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
            'nombre'    => ['required', 'string', 'unique:atractivo_culturals'],
            'estado'    => ['required', 'string', 'in:ACTIVO,INACTIVO'],
            'id_municipio' => ['required'],
        ];
    }
}
