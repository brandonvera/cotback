<?php

namespace App\Exports;

use App\Models\Representante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RepresentantesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.representantes', [
        	'representantes' => Representante::with( 
        		'UsuarioCreador',
            	'UsuarioModificador'
            )->get()
        ]);
    }
}
