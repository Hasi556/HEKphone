<?php

class hekphoneCheckresidentsmovingoutTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),

      new sfCommandOption('mail', null, sfCommandOption::PARAMETER_NONE, 'Residents who move out tomorrow get an informational email'),
      new sfCommandOption('lock', null, sfCommandOption::PARAMETER_NONE, 'All residents who move out today get locked'),
      new sfCommandOption('notifyTeam', null, sfCommandOption::PARAMETER_NONE, 'The hekphone team gets a summary of who\'s moving out. NOT IMPLEMENTED.'),

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Supress informative output, only print errors')
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'check-residents-moving-out';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [hekphone:check-residents-moving-out|INFO] fetches all users moving out tomorrow. Sends a goodbye-email
to them and locks them.
If called withoud parameters it prints a list of all residents moving out today and tomorrow.
Call it with:

  [php symfony hekphone:check-residents-moving-out|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    /* Notify residents that they are going to be locked tomorrow */
    $residentsMovingOutTomorrow = Doctrine_Core::getTable('Residents')->findResidentsMovingOutTomorrow();
    foreach ($residentsMovingOutTomorrow as $resident)
    {
        if($options['mail'])
        {
            $resident->sendLockEmail();
        }
    }

    /* Lock residents who move out today and notify the list */
    // TODO: Notify the list
    $residentsMovingOutToday = Doctrine_Core::getTable('Residents')->findResidentsMovingOutToday();
    foreach ($residentsMovingOutToday as $resident)
    {
        if($options['lock'])
        {
            $resident->setUnlocked('false');
        }

    }

    /* Print a list of all users moving out today or tomorrow if no commandline options are set*/
    if( ! $options['lock'] && ! $options['mail'] && ! $options['notifyTeam'] && ! $options['silent']) {
        if(count($residentsMovingOutToday) < 0) {
            $this->log($this->formatter->format("Residents moving out today:", 'INFO'));
            print_r($residentsMovingOutToday->toArray());
        } else {
            $this->log($this->formatter->format("There are no residents moving out today.", 'INFO'));
        }

        if(count($residentsMovingOutTomorrow) < 0) {
            $this->log($this->formatter->format("Residents moving out tomorrow:", 'INFO'));
            print_r($residentsMovingOutTomorrow->toArray());
        } else {
            $this->log($this->formatter->format("There are no residents moving out tomorrow.", 'INFO'));
        }
    }

  }
}