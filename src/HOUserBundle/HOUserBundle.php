<?php

namespace HOUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HOUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}
