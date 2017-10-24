<?php

namespace GSRO\DotKernel\MVC2\Model;

use Dot_Paginator;
use function FastRoute\TestFixtures\empty_options_cached;

trait CrudModelTrait
{
    /**
     * Get List, Paginated or non paginated
     *
     * If page 0 or -x requested, all entities will be returned
     * If page is a positive integer
     * @param $table
     * @param int $page
     * @param array $options
     * @return array
     */
    public function getList($table, $page = 1, $options = [])
    {
        $select = $this->db->select()->from($table);
        
        if (isset($options) && !empty($options)) {
            foreach ($options as $sqlAction => $sqlSpot) {
                if ($sqlAction === 'join') {
                    foreach ($sqlSpot as $tableJoin => $data) {
                        $select->join($tableJoin, $tableJoin . "." . $data['withColumn'] . " = " . $data['onTable'] . "." . $data['onTableColumn'], $data['return']);
                    }
                } elseif ($sqlAction === 'where') {
                    foreach ($sqlSpot as $filter => $filterValue) {
                        $select->where($filter . " = ?", $filterValue);
                    }
                }
            }
        }
        
        if ($page <= 0) {
            return $this->db->fetchAll($select);
        }
        $dotPaginator = new Dot_Paginator($select, $page, $this->settings->resultsPerPage);
        return $dotPaginator->getData();
    }
    
    /**
     * Get list of details for specific item
     *
     * @param $table
     * @param $id
     * @param array $options
     * @return mixed
     */
    public function getDetails($table, $id, $options = [])
    {
        $select = $this->db->select()->from($table);
        
        if (isset($options) && !empty($options)) {
            foreach ($options as $sqlAction => $sqlSpot) {
                if ($sqlAction === 'join') {
                    foreach ($sqlSpot as $tableJoin => $data) {
                        $select->join($tableJoin, $tableJoin . "." . $data['withColumn'] . " = " . $data['onTable'] . "." . $data['onTableColumn'], $data['return']);
                    }
                } elseif ($sqlAction === 'where') {
                    foreach ($sqlSpot as $filter => $filterValue) {
                        $select->where($filter . " = ?", $filterValue);
                    }
                }
            }
        }
        $select->where($table . '.id = ?', $id);
        return $this->db->fetchRow($select);
    }
    
    /**
     * @param $table
     * @param $id
     * @param $data
     */
    public function updateDetails($table, $id, $data)
    {
        $this->db->update($table, $data, $table.'.id = '.$id);
    }
    
    /**
     * @param $table
     * @param $data
     * @return mixed
     */
    public function createNewItem($table, $data)
    {
        $select = $this->db->insert($table, $data);
        return $this->db->lastInsertId($table);
    }
}