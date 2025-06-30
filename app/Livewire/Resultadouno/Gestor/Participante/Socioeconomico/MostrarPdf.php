<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Socioeconomico;

use App\Http\Controllers\Controller;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\SocioeconomicoForm;
use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Participante;
use App\Models\Proyecto;
use App\Models\Socioeconomico;
use App\Traits\SocioeconomicoUtility;
use Illuminate\Support\Facades\Storage;

class MostrarPdf extends  Controller
{
    use SocioeconomicoUtility;

    public Socioeconomico $socioeconomico;

    public Participante $participante;

    public Proyecto $proyecto;

    public Pais $pais;

    public Cohorte $cohorte ;

    function socioeconomicoPdf(Pais $pais, Proyecto $proyecto, Cohorte $cohorte, Participante $participante)
    {
        $this->socioeconomico = $participante->socioeconomico;
        $this->participante = $participante;
        $this->proyecto = $proyecto;
        $this->pais = $pais;
        $this->cohorte = $cohorte;

        $file_path = $participante->socioeconomico->pdf;

        $file_path = $this->generatePDF();

         if($file_path && Storage::disk('s3')->exists($file_path)){
             $url = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(30));
             return redirect()->away($url);
         }
         
        abort(404);
    }

}
