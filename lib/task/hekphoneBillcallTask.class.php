<?php

class hekphoneBillcallTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('uniqueid', sfCommandArgument::REQUIRED, 'The uniqueid in asterisk_cdr to bill'),
    ));

    $this->addOptions(array(
      new sfCommandOption('rebill', null, sfCommandOption::PARAMETER_REQUIRED, 'Bill a given call even though it has been marked as billed already', 'false'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The database connection name', 'hekphone'),
      // add your own options here
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'bill-call';
    $this->briefDescription = 'Bills an entry in AsteriskCdr with given uniqueid';
    $this->detailedDescription = <<<EOF
The [hekphone:bill-call|INFO] task takes one uniqueid from asterisk_cdr as argument, tries to match the source to a room and matches the room to an resident/user;
It tries to match the dialed number to an rate and calculates the cost of the call in euro-cents (ct).
Then an entry in the "calls" table is created and the call is marked as billed in the asterisk_cdr table.

It's supposed to be called everytime an outgoing call has ended.

Call it with:

  [php symfony hekphone:bill-call uniqueid|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $collCdr  = Doctrine_Query::create()
              ->from('AsteriskCdr')
              ->where('uniqueid = ?', $arguments['uniqueid'])
              ->fetchOne();
    if ( ! $collCdr)
      die("error: a call with uniqueid=".$arguments['uniqueid']." is not present in asterisk_cdr" . PHP_EOL);

    try
    {
      $collCdr->bill($options['rebill']);
    }
    catch (Exception $e)
    {
      die('[ERROR]'.$e->getMessage().PHP_EOL);
    }

  }
}
