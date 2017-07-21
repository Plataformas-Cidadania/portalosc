<?php

namespace App\Http\Enums;

use App\Http\Enums\Enum;

abstract class TipoUsuarioEnum extends Enum
{
	const Admin = 1;
	const OSC = 2;
	const EstatalMunicipio = 3;
	const EstatalEstado = 4;
}
