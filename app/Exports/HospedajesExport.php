<?php

namespace App\Exports;

use App\Models\Hospedaje;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HospedajesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.hospedajes', [
        	'hospedajes' => Hospedaje::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio',
           		'Representante'
            )->get()
        ]);
    }
}
