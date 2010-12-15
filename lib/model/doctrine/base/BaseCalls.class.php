<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Calls', 'hekphone');

/**
 * BaseCalls
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $resident
 * @property string $extension
 * @property timestamp $date
 * @property string $duration
 * @property string $destination
 * @property string $asterisk_uniqueid
 * @property decimal $charges
 * @property integer $rate
 * @property integer $bill
 * @property Residents $Residents
 * @property Rates $Rates
 * @property AsteriskCdr $AsteriskCdr
 * @property Bills $Bills
 * 
 * @method integer     getId()                Returns the current record's "id" value
 * @method integer     getResident()          Returns the current record's "resident" value
 * @method string      getExtension()         Returns the current record's "extension" value
 * @method timestamp   getDate()              Returns the current record's "date" value
 * @method string      getDuration()          Returns the current record's "duration" value
 * @method string      getDestination()       Returns the current record's "destination" value
 * @method string      getAsteriskUniqueid()  Returns the current record's "asterisk_uniqueid" value
 * @method decimal     getCharges()           Returns the current record's "charges" value
 * @method integer     getRate()              Returns the current record's "rate" value
 * @method integer     getBill()              Returns the current record's "bill" value
 * @method Residents   getResidents()         Returns the current record's "Residents" value
 * @method Rates       getRates()             Returns the current record's "Rates" value
 * @method AsteriskCdr getAsteriskCdr()       Returns the current record's "AsteriskCdr" value
 * @method Bills       getBills()             Returns the current record's "Bills" value
 * @method Calls       setId()                Sets the current record's "id" value
 * @method Calls       setResident()          Sets the current record's "resident" value
 * @method Calls       setExtension()         Sets the current record's "extension" value
 * @method Calls       setDate()              Sets the current record's "date" value
 * @method Calls       setDuration()          Sets the current record's "duration" value
 * @method Calls       setDestination()       Sets the current record's "destination" value
 * @method Calls       setAsteriskUniqueid()  Sets the current record's "asterisk_uniqueid" value
 * @method Calls       setCharges()           Sets the current record's "charges" value
 * @method Calls       setRate()              Sets the current record's "rate" value
 * @method Calls       setBill()              Sets the current record's "bill" value
 * @method Calls       setResidents()         Sets the current record's "Residents" value
 * @method Calls       setRates()             Sets the current record's "Rates" value
 * @method Calls       setAsteriskCdr()       Sets the current record's "AsteriskCdr" value
 * @method Calls       setBills()             Sets the current record's "Bills" value
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCalls extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('calls');
        $this->hasColumn('id', 'integer', 7, array(
             'type' => 'integer',
             'primary' => true,
             'sequence' => 'calls_id',
             'length' => 7,
             ));
        $this->hasColumn('resident', 'integer', 6, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 6,
             ));
        $this->hasColumn('extension', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('date', 'timestamp', null, array(
             'type' => 'timestamp',
             'default' => 'now()',
             ));
        $this->hasColumn('duration', 'string', 6, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 6,
             ));
        $this->hasColumn('destination', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('asterisk_uniqueid', 'string', 30, array(
             'type' => 'string',
             'notnull' => false,
             'unique' => true,
             'length' => 30,
             ));
        $this->hasColumn('charges', 'decimal', 18, array(
             'type' => 'decimal',
             'notnull' => true,
             'length' => 18,
             ));
        $this->hasColumn('rate', 'integer', 6, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 6,
             ));
        $this->hasColumn('bill', 'integer', 6, array(
             'type' => 'integer',
             'length' => 6,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Residents', array(
             'local' => 'resident',
             'foreign' => 'id'));

        $this->hasOne('Rates', array(
             'local' => 'rate',
             'foreign' => 'id'));

        $this->hasOne('AsteriskCdr', array(
             'local' => 'asterisk_uniqueid',
             'foreign' => 'uniqueid'));

        $this->hasOne('Bills', array(
             'local' => 'bill',
             'foreign' => 'id'));
    }
}