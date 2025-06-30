<?php

namespace App\Enums;

enum TipoActor:int
{
    case GobiernoCentral = 1; 
    case GobiernoLocal = 2;
    case SectorPrivado = 3;
    case OrganismosInt = 4;
    case SociedadCivil = 5;
    case PueblosIndigenas = 6;
    case OtrosYVarios = 7;

    public function label(){
        return match($this) {
            static::GobiernoCentral => "Gobierno central", 
            static::GobiernoLocal => "Gobierno local",
            static::SectorPrivado => "Sector Privado",
            static::OrganismosInt => "Organismos internacionales",
            static::SociedadCivil => "Sociedad Civil",
            static::PueblosIndigenas => "Pueblos Indígenas",
            static::OtrosYVarios => "Otros y varios"
        };
    }
}