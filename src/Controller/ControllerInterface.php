<?php

namespace GSRO\DotKernel\MVC2\Controller;

interface ControllerInterface
{
    /**
     * General controller bootstrap
     * @return mixed
     */
    public function bootstrap();
    
    /**
     * Custom bootstrap for controller
     * @return mixed
     */
    public function customBootstrap();
}
