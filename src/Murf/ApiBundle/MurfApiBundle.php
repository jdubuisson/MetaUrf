<?php

namespace Murf\ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MurfApiBundle extends Bundle
{

    public function getParent()
    {
        return 'DowdowLeagueOfLegendsAPIBundle';
    }
}
