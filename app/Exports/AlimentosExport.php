<?php

namespace App\Exports;

use App\Models\Alimento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlimentosExport implements FromView, ShouldAutoSize
{
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
