<?php

namespace App\Exports;

use App\Models\AtractivoCultural;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CulturalesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.culturales', [
        	'culturales' => AtractivoCultural::with( 
        		'UsuarioCreador',
            	'UsuarioModificador',
            	'Municipio'            
            )->get()
        ]);
    }
}
