<?php

namespace Ign\Bundle\GincoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IgnGincoBundle extends Bundle
{
	public function getParent()
	{
		return 'OGAMBundle';
	}
}
