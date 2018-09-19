<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class TipoUsuarioEnum extends Enum
{
	const ADMINISTRADOR = 1;
	const OSC = 2;
	const GOVERNO_MUNICIPAL = 3;
	const GOVERNO_ESTADUAL = 4;
}
