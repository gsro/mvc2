<?php

namespace GSRO\DotKernel\MVC2\View;

use Zend_Registry;

trait ViewTrait
{
    /**
     * @var Dot_Template
     */
    protected $tpl;
    
    /**
     * @return Dot_Template
     */
    public function getTpl(): Dot_Template
    {
        return $this->tpl;
    }
    
    /**
     * @param Dot_Template $tpl
     */
    public function setTpl(Dot_Template $tpl)
    {
        $this->tpl = $tpl;
    }
    
    public function __construct($tpl)
    {
        $this->tpl = $tpl;
    }
    
    public function blockList($list, $blockName, $parent = 'tpl_main')
    {
        $this->tpl->setBlock($parent, $blockName, $blockName.'_block');
    
        // sanitize before showing
        foreach ($list as $element) {
            foreach ($element as $key => $value) {
                $this->tpl->setVar(strtoupper($key), $value);
            }
            $this->tpl->parse($blockName.'_block', $blockName, true);
        }
    }
}