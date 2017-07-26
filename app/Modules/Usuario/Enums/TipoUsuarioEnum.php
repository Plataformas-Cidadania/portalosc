<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class TipoUsuarioEnum extends Enum
{
	const Administrador = 1;
	const OSC = 2;
	const GovernoMunicipal = 3;
	const GovernoEstadual = 4;
}
