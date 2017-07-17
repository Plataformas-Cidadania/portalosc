<?php

namespace App\Http\Enums;

use App\Http\Enums\Enum;

abstract class UserTypeEnum extends Enum
{
	const Admin = 1;
	const OSC = 2;
	const GovCity = 3;
	const GovState = 4;
}
