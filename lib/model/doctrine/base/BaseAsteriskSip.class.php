<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AsteriskSip', 'hekphone');

/**
 * BaseAsteriskSip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $type
 * @property string $callerid
 * @property string $context
 * @property string $name
 * @property string $secret
 * @property string $host
 * @property string $defaultip
 * @property string $mac
 * @property string $language
 * @property string $mailbox
 * @property string $defaultuser
 * @property string $regexten
 * @property string $regserver
 * @property string $regseconds
 * @property string $fromuser
 * @property string $fromdomain
 * @property string $ipaddr
 * @property string $port
 * @property string $fullcontact
 * @property string $useragent
 * @property string $lastms
 * 
 * @method integer     getId()          Returns the current record's "id" value
 * @method enum        getType()        Returns the current record's "type" value
 * @method string      getCallerid()    Returns the current record's "callerid" value
 * @method string      getContext()     Returns the current record's "context" value
 * @method string      getName()        Returns the current record's "name" value
 * @method string      getSecret()      Returns the current record's "secret" value
 * @method string      getHost()        Returns the current record's "host" value
 * @method string      getDefaultip()   Returns the current record's "defaultip" value
 * @method string      getMac()         Returns the current record's "mac" value
 * @method string      getLanguage()    Returns the current record's "language" value
 * @method string      getMailbox()     Returns the current record's "mailbox" value
 * @method string      getDefaultuser() Returns the current record's "defaultuser" value
 * @method string      getRegexten()    Returns the current record's "regexten" value
 * @method string      getRegserver()   Returns the current record's "regserver" value
 * @method string      getRegseconds()  Returns the current record's "regseconds" value
 * @method string      getFromuser()    Returns the current record's "fromuser" value
 * @method string      getFromdomain()  Returns the current record's "fromdomain" value
 * @method string      getIpaddr()      Returns the current record's "ipaddr" value
 * @method string      getPort()        Returns the current record's "port" value
 * @method string      getFullcontact() Returns the current record's "fullcontact" value
 * @method string      getUseragent()   Returns the current record's "useragent" value
 * @method string      getLastms()      Returns the current record's "lastms" value
 * @method AsteriskSip setId()          Sets the current record's "id" value
 * @method AsteriskSip setType()        Sets the current record's "type" value
 * @method AsteriskSip setCallerid()    Sets the current record's "callerid" value
 * @method AsteriskSip setContext()     Sets the current record's "context" value
 * @method AsteriskSip setName()        Sets the current record's "name" value
 * @method AsteriskSip setSecret()      Sets the current record's "secret" value
 * @method AsteriskSip setHost()        Sets the current record's "host" value
 * @method AsteriskSip setDefaultip()   Sets the current record's "defaultip" value
 * @method AsteriskSip setMac()         Sets the current record's "mac" value
 * @method AsteriskSip setLanguage()    Sets the current record's "language" value
 * @method AsteriskSip setMailbox()     Sets the current record's "mailbox" value
 * @method AsteriskSip setDefaultuser() Sets the current record's "defaultuser" value
 * @method AsteriskSip setRegexten()    Sets the current record's "regexten" value
 * @method AsteriskSip setRegserver()   Sets the current record's "regserver" value
 * @method AsteriskSip setRegseconds()  Sets the current record's "regseconds" value
 * @method AsteriskSip setFromuser()    Sets the current record's "fromuser" value
 * @method AsteriskSip setFromdomain()  Sets the current record's "fromdomain" value
 * @method AsteriskSip setIpaddr()      Sets the current record's "ipaddr" value
 * @method AsteriskSip setPort()        Sets the current record's "port" value
 * @method AsteriskSip setFullcontact() Sets the current record's "fullcontact" value
 * @method AsteriskSip setUseragent()   Sets the current record's "useragent" value
 * @method AsteriskSip setLastms()      Sets the current record's "lastms" value
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAsteriskSip extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asterisk_sip');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 11,
             ));
        $this->hasColumn('type', 'enum', 6, array(
             'type' => 'enum',
             'length' => 6,
             'values' => 
             array(
              0 => 'user',
              1 => 'peer',
              2 => 'friend',
             ),
             'notnull' => true,
             'default' => 'friend',
             ));
        $this->hasColumn('callerid', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('context', 'string', 20, array(
             'type' => 'string',
             'default' => 'locked',
             'length' => 20,
             ));
        $this->hasColumn('name', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 80,
             ));
        $this->hasColumn('secret', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('host', 'string', 31, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'dynamic',
             'length' => 31,
             ));
        $this->hasColumn('defaultip', 'string', 15, array(
             'type' => 'string',
             'length' => 15,
             ));
        $this->hasColumn('mac', 'string', 20, array(
             'type' => 'string',
             'default' => '',
             'length' => 20,
             ));
        $this->hasColumn('language', 'string', 2, array(
             'type' => 'string',
             'default' => 'de',
             'length' => 2,
             ));
        $this->hasColumn('mailbox', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('defaultuser', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 80,
             ));
        $this->hasColumn('regexten', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('regserver', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('regseconds', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('fromuser', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('fromdomain', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('ipaddr', 'string', 15, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 15,
             ));
        $this->hasColumn('port', 'string', 5, array(
             'type' => 'string',
             'unsigned' => true,
             'notnull' => true,
             'default' => '',
             'length' => 5,
             ));
        $this->hasColumn('fullcontact', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 80,
             ));
        $this->hasColumn('useragent', 'string', 20, array(
             'type' => 'string',
             'default' => '',
             'length' => 20,
             ));
        $this->hasColumn('lastms', 'string', 11, array(
             'type' => 'string',
             'default' => '',
             'length' => 11,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}