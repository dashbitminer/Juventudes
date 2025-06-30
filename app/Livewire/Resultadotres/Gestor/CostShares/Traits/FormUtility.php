<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Traits;

use App\Models\TipoSector;

trait FormUtility
{
    public function getPaisTipoSectorId()  {
        return \DB::table('pais_tipo_sector')
            ->where('tipo_sector_id', $this->tipoSectorSelected)
            ->where('pais_id', $this->pais->id)
            ->value('id');
    }

    public function getPaisTipoSectorPublicoId() {
        return \DB::table('pais_tipo_sector_publico')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_publico_id', $this->tipoSectorPublicoSelected)
            ->value('id');
    }

    public function getPaisTipoSectorPrivadaId() {
        return \DB::table('pais_tipo_sector_privado')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_privado_id', $this->tipoSectorPrivadoSelected)
            ->value('id');
    }

    public function getTipoSectorAcademicaSelected()
    {
        return \DB::table('pais_tipo_sector_academica')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_academica_id', $this->tipoSectorAcademicaSelected)
            ->value('id');
    }

    public function getTipoSectorComunitariaSelected()
    {
        return \DB::table('pais_tipo_sector_comunitaria')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_comunitaria_id', $this->tipoSectorComunitariaSelected)
            ->value('id');
    }

    public function getTamanoEmpresaPrivadaSelected()
    {
        return \DB::table('pais_tamano_empresa_privada')
            ->where('pais_id', $this->pais->id)
            ->where('tamano_empresa_privada_id', $this->tamanoEmpresaPrivadaSelected)
            ->value('id');
    }

    public function getOrigenEmpresaPrivadaSelected()
    {
        return \DB::table('pais_origen_empresa_privada')
            ->where('pais_id', $this->pais->id)
            ->where('origen_empresa_privada_id', $this->origenEmpresaPrivadaSelected)
            ->value('id');
    }

    private function updateCategorias(): void
    {
        $this->costShare->categoria()->detach();
        $this->costShare->categoria()->sync($this->categoriaSelected);
    }

    private function updateActividades(): void
    {
        $this->costShare->actividad()->detach();
        $this->costShare->actividad()->sync($this->actividadSelected);
    }

    private function updateResultados(): void
    {
        $this->costShare->resultado()->detach();

        $resultadoData = [];

        foreach ($this->resultadoSelected as $resultadoId) {
            $porcentaje = $this->resultadoPorcentajes[$resultadoId] ?? null;

            if ($porcentaje) {
                if($porcentaje < 0 || $porcentaje > 100){
                    $porcentaje = 0;
                }
                $resultadoData[$resultadoId] = ['porcentaje' => $porcentaje];
            }
        }

        $this->costShare->resultado()->sync($resultadoData);
    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }



    public function getFieldsData($costShare, $relation, $fieldId): array
    {
        
        $records = $costShare->$relation;

        return $records->pluck($fieldId)->toArray();
    }
}