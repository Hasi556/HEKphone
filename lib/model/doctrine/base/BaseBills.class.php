<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Bills', 'hekphone');

/**
 * BaseBills
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $resident
 * @property date $date
 * @property decimal $amount
 * @property boolean $debit_failed
 * @property Residents $Residents
 * @property Doctrine_Collection $Calls
 * 
 * @method integer             getId()           Returns the current record's "id" value
 * @method integer             getResident()     Returns the current record's "resident" value
 * @method date                getDate()         Returns the current record's "date" value
 * @method decimal             getAmount()       Returns the current record's "amount" value
 * @method boolean             getDebitFailed()  Returns the current record's "debit_failed" value
 * @method Residents           getResidents()    Returns the current record's "Residents" value
 * @method Doctrine_Collection getCalls()        Returns the current record's "Calls" collection
 * @method Bills               setId()           Sets the current record's "id" value
 * @method Bills               setResident()     Sets the current record's "resident" value
 * @method Bills               setDate()         Sets the current record's "date" value
 * @method Bills               setAmount()       Sets the current record's "amount" value
 * @method Bills               setDebitFailed()  Sets the current record's "debit_failed" value
 * @method Bills               setResidents()    Sets the current record's "Residents" value
 * @method Bills               setCalls()        Sets the current record's "Calls" collection
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBills extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('bills');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'sequence' => 'bills_id',
             'length' => 6,
             ));
        $this->hasColumn('resident', 'integer', 6, array(
             'type' => 'integer',
             'notnull' => true,
             'primary' => false,
             'length' => 6,
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('amount', 'decimal', 18, array(
             'type' => 'decimal',
             'notnull' => true,
             'length' => 18,
             ));
        $this->hasColumn('debit_failed', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 'false',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Residents', array(
             'local' => 'resident',
             'foreign' => 'id'));

        $this->hasMany('Calls', array(
             'local' => 'id',
             'foreign' => 'bill'));
    }
}