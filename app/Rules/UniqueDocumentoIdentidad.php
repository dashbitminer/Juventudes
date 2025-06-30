<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueDocumentoIdentidad implements ValidationRule
{

    protected $proyectoId;

    protected $participanteId;

    public function __construct($proyectoId, $participanteId = null)
    {
        $this->proyectoId = $proyectoId;

        $this->participanteId = $participanteId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $allowed = $this->allowDuplicates();

        if (in_array($value, $allowed)) {
            return;
        }

        $sinGuiones = str_replace('-', '', trim($value));

        // where('documento_identidad', $value)
        //     ->orWhere('documento_identidad', $sinGuiones)

        $documentoCount = \App\Models\Participante::where(function ($query) use ($value, $sinGuiones) {
            $query->where('documento_identidad', $value)
                ->orWhere('documento_identidad', $sinGuiones);
            })
            ->when(!empty($allowed), function ($query) use ($allowed) {
                return $query->whereNotIn('documento_identidad', $allowed);
            })
            ->when($this->participanteId, function ($query) {
                return $query->where('participantes.id', '!=', $this->participanteId);
            })
            ->count();



        // $exists = DB::table('cohorte_participante_proyecto')
        //     ->leftJoin('cohorte_pais_proyecto', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id', '=', 'cohorte_pais_proyecto.id')
        //     ->leftJoin('pais_proyecto', 'cohorte_pais_proyecto.pais_proyecto_id', '=', 'pais_proyecto.id')
        //     ->leftJoin('participantes', 'cohorte_participante_proyecto.participante_id', '=', 'participantes.id')
        //     //->where('pais_proyecto.proyecto_id', $this->proyectoId)
        //     ->where('participantes.documento_identidad', $value)
        //     // ->whereNotIn('participantes.documento_identidad', $allowed)
        //     // ->when(!empty($allowed), function ($query) {
        //     //     return $query->whereNotIn('participantes.documento_identidad', $this->allowDuplicates());
        //     // })
        //     ->when($this->participanteId, function ($query) {
        //         return $query->where('participantes.id', '!=', $this->participanteId);
        //     })
        //     ->exists();

        if ($documentoCount > 0) {
            $fail('El documento de identidad ya está registrado en el proyecto.');
        }

    }


    private function allowDuplicates(): array
    {
        return [
            '3340850631301',
            '3177442161303',
            '3176273331303',
            '3154218431301',
            '3515932091301',
            '3150807601301',
            '3075905851207',
            '2786588650901',
            '2754238910914',
            '2946249880909',
            '2930566331301',
            '3162515931302',
            '3461270681303',
            '3248049621330',
            '3212864801320',
            '2841598671320',
            '2312929531301',
            '3196891071306',
            '2905484891311',
            '3151337321301',
            '2835275281302',
            '3154367940902',
            '3341047851301',
            '3148305610901',
            '3649947970901',
            '3357398060901',
            '3161614540804',
            '3192361610911',
        ];

    }

}
