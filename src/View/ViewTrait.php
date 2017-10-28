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
    
    public function blockList($list, $blockName, $prefix = '', $parent = 'tpl_main')
    {
        $this->tpl->setBlock($parent, $blockName, $blockName.'_block');
    
        // sanitize before showing
        foreach ($list as $element) {
            foreach ($element as $key => $value) {
                $this->tpl->setVar(strtoupper($prefix.$key), $value);
            }
            $this->tpl->parse($blockName.'_block', $blockName, true);
        }
    }
    
    /**
     * Set vars recursively
     *
     * positive $levels => limited levels
     * negative $levels => unlimited levels
     * $levels = 0, non-recursive
     *
     * @param $vars
     * @param string $prefix
     * @param int $levels
     */
    public function setVarsRecursive($vars, $levels = -1, $prefix = '')
    {
        foreach ($vars as $key => $value) {
            if (is_string($value)) {
                $this->tpl->setVar(strtoupper($prefix.$key), $value);
            }
            if (is_array($value)) {
                $prefix.= $key.'_';
                if ($levels != 0) {
                    $this->setVarsRecursive($value, $levels-1, $prefix);
                }
            }
        }
    }
}
