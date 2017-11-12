<?php

namespace GSRO\DotKernel\MVC2\Model;

use Dot_Paginator;
use function FastRoute\TestFixtures\empty_options_cached;

trait TransactionHelperTrait
{
    /**
     * Begin a transaction
     * @return mixed
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }
    
    /**
     * Commit a transaction
     * @return mixed
     */
    public function commit()
    {
        return $this->db->commit();
    }
    
    /**
     * Rollback a transaction
     * @return mixed
     */
    public function rollBack()
    {
        return $this->db->rollBack();
    }
}
