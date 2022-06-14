<?php

namespace App\Exports;

use App\Models\AtractivoNatural;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NaturalesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.naturales', [
        	'naturales' => AtractivoNatural::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio'            
            )->get()
        ]);
    }
}