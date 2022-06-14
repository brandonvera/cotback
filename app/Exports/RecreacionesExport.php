<?php

namespace App\Exports;

use App\Models\Recreacion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RecreacionesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.recreaciones', [
        	'recreaciones' => Recreacion::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio',
           		'Representante'
            )->get()
        ]);
    }
}
