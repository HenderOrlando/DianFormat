<?php

namespace PuertoUDES\FosUsuarioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PuertoUDESFosUsuarioBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
