<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Residents', 'hekphone');

/**
 * BaseResidents
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $email
 * @property date $move_in
 * @property date $move_out
 * @property integer $bill_limit
 * @property integer $room
 * @property boolean $warning1
 * @property boolean $warning2
 * @property boolean $unlocked
 * @property boolean $vm_active
 * @property int $vm_seconds
 * @property boolean $mail_on_missed_call
 * @property boolean $shortened_itemized_bill
 * @property string $account_number
 * @property string $bank_number
 * @property string $password
 * @property boolean $hekphone
 * @property string $culture
 * @property Rooms $Rooms
 * @property Banks $Banks
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $Calls
 * @property Doctrine_Collection $Bills
 * @property AsteriskVoicemail $AsteriskVoicemail
 * 
 * @method integer             getId()                      Returns the current record's "id" value
 * @method string              getLastName()                Returns the current record's "last_name" value
 * @method string              getFirstName()               Returns the current record's "first_name" value
 * @method string              getEmail()                   Returns the current record's "email" value
 * @method date                getMoveIn()                  Returns the current record's "move_in" value
 * @method date                getMoveOut()                 Returns the current record's "move_out" value
 * @method integer             getBillLimit()               Returns the current record's "bill_limit" value
 * @method integer             getRoom()                    Returns the current record's "room" value
 * @method boolean             getWarning1()                Returns the current record's "warning1" value
 * @method boolean             getWarning2()                Returns the current record's "warning2" value
 * @method boolean             getUnlocked()                Returns the current record's "unlocked" value
 * @method boolean             getVmActive()                Returns the current record's "vm_active" value
 * @method int                 getVmSeconds()               Returns the current record's "vm_seconds" value
 * @method boolean             getMailOnMissedCall()        Returns the current record's "mail_on_missed_call" value
 * @method boolean             getShortenedItemizedBill()   Returns the current record's "shortened_itemized_bill" value
 * @method string              getAccountNumber()           Returns the current record's "account_number" value
 * @method string              getBankNumber()              Returns the current record's "bank_number" value
 * @method string              getPassword()                Returns the current record's "password" value
 * @method boolean             getHekphone()                Returns the current record's "hekphone" value
 * @method string              getCulture()                 Returns the current record's "culture" value
 * @method Rooms               getRooms()                   Returns the current record's "Rooms" value
 * @method Banks               getBanks()                   Returns the current record's "Banks" value
 * @method Doctrine_Collection getComments()                Returns the current record's "Comments" collection
 * @method Doctrine_Collection getCalls()                   Returns the current record's "Calls" collection
 * @method Doctrine_Collection getBills()                   Returns the current record's "Bills" collection
 * @method AsteriskVoicemail   getAsteriskVoicemail()       Returns the current record's "AsteriskVoicemail" value
 * @method Residents           setId()                      Sets the current record's "id" value
 * @method Residents           setLastName()                Sets the current record's "last_name" value
 * @method Residents           setFirstName()               Sets the current record's "first_name" value
 * @method Residents           setEmail()                   Sets the current record's "email" value
 * @method Residents           setMoveIn()                  Sets the current record's "move_in" value
 * @method Residents           setMoveOut()                 Sets the current record's "move_out" value
 * @method Residents           setBillLimit()               Sets the current record's "bill_limit" value
 * @method Residents           setRoom()                    Sets the current record's "room" value
 * @method Residents           setWarning1()                Sets the current record's "warning1" value
 * @method Residents           setWarning2()                Sets the current record's "warning2" value
 * @method Residents           setUnlocked()                Sets the current record's "unlocked" value
 * @method Residents           setVmActive()                Sets the current record's "vm_active" value
 * @method Residents           setVmSeconds()               Sets the current record's "vm_seconds" value
 * @method Residents           setMailOnMissedCall()        Sets the current record's "mail_on_missed_call" value
 * @method Residents           setShortenedItemizedBill()   Sets the current record's "shortened_itemized_bill" value
 * @method Residents           setAccountNumber()           Sets the current record's "account_number" value
 * @method Residents           setBankNumber()              Sets the current record's "bank_number" value
 * @method Residents           setPassword()                Sets the current record's "password" value
 * @method Residents           setHekphone()                Sets the current record's "hekphone" value
 * @method Residents           setCulture()                 Sets the current record's "culture" value
 * @method Residents           setRooms()                   Sets the current record's "Rooms" value
 * @method Residents           setBanks()                   Sets the current record's "Banks" value
 * @method Residents           setComments()                Sets the current record's "Comments" collection
 * @method Residents           setCalls()                   Sets the current record's "Calls" collection
 * @method Residents           setBills()                   Sets the current record's "Bills" collection
 * @method Residents           setAsteriskVoicemail()       Sets the current record's "AsteriskVoicemail" value
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseResidents extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('residents');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('last_name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('first_name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'email' => true,
             'length' => 255,
             ));
        $this->hasColumn('move_in', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('move_out', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('bill_limit', 'integer', 3, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => '75',
             'length' => 3,
             ));
        $this->hasColumn('room', 'integer', 3, array(
             'type' => 'integer',
             'unique' => true,
             'length' => 3,
             ));
        $this->hasColumn('warning1', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('warning2', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('unlocked', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('vm_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('vm_seconds', 'int', null, array(
             'type' => 'int',
             'notnull' => true,
             'default' => 15,
             ));
        $this->hasColumn('mail_on_missed_call', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => true,
             ));
        $this->hasColumn('shortened_itemized_bill', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('account_number', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));
        $this->hasColumn('bank_number', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('hekphone', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('culture', 'string', 5, array(
             'type' => 'string',
             'default' => 'de_DE',
             'length' => 5,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Rooms', array(
             'local' => 'room',
             'foreign' => 'id'));

        $this->hasOne('Banks', array(
             'local' => 'bank_number',
             'foreign' => 'bank_number'));

        $this->hasMany('Comments', array(
             'local' => 'id',
             'foreign' => 'resident'));

        $this->hasMany('Calls', array(
             'local' => 'id',
             'foreign' => 'resident'));

        $this->hasMany('Bills', array(
             'local' => 'id',
             'foreign' => 'resident'));

        $this->hasOne('AsteriskVoicemail', array(
             'local' => 'id',
             'foreign' => 'uniqueid'));
    }
}