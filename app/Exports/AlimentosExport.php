<?php

namespace App\Exports;

use App\Models\Alimento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class AlimentosExport implements FromView, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.alimentos', [
        	'alimentos' => Alimento::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio',
           		'Representante'
            )->get()
        ]);
    }
}
