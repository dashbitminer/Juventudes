<?php
namespace App\Livewire\Resultadotres\Gestor\Prealianzas;

use App\Models\OrganizacionAlianza;
use App\Models\Pais;
use App\Models\PaisOrganizacionAlianza;
use Str;

trait Organizaciones
{

    public function getOrganizaciones($pais)
    {
        return PaisOrganizacionAlianza::with('organizacionAlianza')
            ->where('pais_id', $pais->id)
            ->get();
    }

    public function getOrganizacionPorNombre($nombre_organizacion){
        return PaisOrganizacionAlianza::with('organizacionAlianza')
            ->whereHas('organizacionAlianza', function ($query) use ($nombre_organizacion) {
                $query->where('nombre', $nombre_organizacion);
            })
            ->first();
    }

    public function getOrganizacionPorId($id){
        return PaisOrganizacionAlianza::with('organizacionAlianza')->find($id);
    }

    public function createOrUpdateOrganizacion(array $data)
    {

        $organizaciones = $this->getOrganizaciones($data['pais']);
        $match = null;
        $minDistancia = 3; // tolerancia: 0 = igual, hasta 3 caracteres de diferencia
        $inputNormalizado = $this->normalizarNombre($data['nombre']);

        foreach ($organizaciones as $org) {
            $nombreOrg = $this->normalizarNombre($org->organizacionAlianza->nombre);
            $distancia = levenshtein($inputNormalizado, $nombreOrg);

            if ($distancia <= $minDistancia) {
                $match = $org;
                break;
            }
        }

        if ($match) {
            return $this->updateOrganizacion($match, $data);
        }
        
        return $this->createOrganizacion($data);
    }

    public function createOrganizacion(array $data)
    {
        $organizacionAlianza = OrganizacionAlianza::create([
            'nombre' => $data['nombre'],
            'active_at' => now(),
        ]);

        $paisOrganizacion = PaisOrganizacionAlianza::create([
            'pais_id' => $data['pais']->id,
            'organizacion_alianza_id' => $organizacionAlianza->id,
            'email' => $data['email'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'nombre_contacto' => $data['nombre_contacto'] ?? null,
            'active_at' => now(),
        ]);

        return $paisOrganizacion;
    }

    public function updateOrganizacion(PaisOrganizacionAlianza $paisOrganizacion, array $data)
    {

        $paisOrganizacion->update([
            'email' => $data['email'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'nombre_contacto' => $data['nombre_contacto'] ?? null,
        ]);

        return $paisOrganizacion;
    }

    private function normalizarNombre($nombre)
    {
        $nombre = Str::lower($nombre);
        $nombre = preg_replace('/[^a-z0-9\s]/u', '', $nombre);
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        return trim($nombre);
    }
}
