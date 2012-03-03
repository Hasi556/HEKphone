<?php

/**
 * CallsTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CallsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CallsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Calls');
    }

    public function deleteOldCalls()
    {
        return $this->createQuery()
            ->delete()
            ->where('date <= ?', date('Y-m-d',strtotime('-' . sfConfig::get('monthsToKeepCdrsFor') . ' months')))
            ->execute();
    }
}