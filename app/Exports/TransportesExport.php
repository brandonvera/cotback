<?php

namespace App\Exports;

use App\Models\Transporte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransportesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.transportes', [
        	'transportes' => Transporte::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio',
           		'Representante'
            )->get()
        ]);
    }
}
