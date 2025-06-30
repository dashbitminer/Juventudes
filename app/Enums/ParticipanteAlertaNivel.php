<?php

namespace App\Enums;

enum ParticipanteAlertaNivel: int
{
    case Alta = 4;
    case MedioAlto = 3;
    case Medio = 2;
    case Bajo = 1;
    case Desertado = 0;

    public static function fromPercentage(int $percentage): self
    {
        if ($percentage === 0) {
            return self::Bajo;
        }

        if ($percentage >= 80) {
            return self::Alta;
        }

        if ($percentage >= 70) {
            return self::MedioAlto;
        }

        if ($percentage >= 60) {
            return self::Medio;
        }

        return self::Bajo;
    }
}
