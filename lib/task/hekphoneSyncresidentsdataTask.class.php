<?php

class hekphoneSyncresidentsdataTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('sourceDb', null, sfCommandOption::PARAMETER_REQUIRED, 'The source connection name', 'hekdb'),
      new sfCommandOption('destinationDb', null, sfCommandOption::PARAMETER_REQUIRED, 'The destination connection name', 'hekphone'),
      new sfCommandOption('source', null, sfCommandOption::PARAMETER_REQUIRED, 'The source db name', 'HekdbCurrentResidents'),
      new sfCommandOption('destination', null, sfCommandOption::PARAMETER_REQUIRED, 'The destination db name', 'Residents'),
      // add your own options here
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'sync-residents-data';
    $this->briefDescription = 'Syncs the residents data between source[default: hekdb->HekdbCurrentResidents] and destination[default: hekphone->Residents])';
    $this->detailedDescription = <<<EOF
The [hekphone:sync-residents-data|INFO] task does things.
Call it with:

  [php symfony hekphone:sync-residents-data|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connections
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connSource = $databaseManager->getDatabase($options['sourceDb'])->getConnection();
    $connDestination = $databaseManager->getDatabase($options['destinationDb'])->getConnection();

    $sourceResidentsTable = Doctrine_Core::getTable($options['source']);
    $destinationResidentsTable = Doctrine_Core::getTable($options['destination']);
    $roomTable = Doctrine_Core::getTable('Rooms');

    // Sets the key of the Collection Array to the ID of the record
    $sourceResidentsTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');
    $destinationResidentsTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');
    $roomTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');

    // Limit the fetched entry from hekDb to the ones of the last year.
    // We fetch changes which only affect the past, so we don't miss corrective actions.
    // You could limit this even more, but performance doesn't matter in this case.
    // XXX: Think about this again. How does Doctrine lock entries in the Table? READ!
    $thisYear = date('Y');
    $sourceResidents = $sourceResidentsTable->findByDql("move_out > ? OR move_out IS NULL ORDER BY id", $thisYear.'-01-01');
    $destinationResidents = $destinationResidentsTable->findByDql("move_out > ? OR move_out IS NULL", $thisYear.'-01-01');

    $numNew = 0;
    $numOld = 0;
    $failedPartly = false;
    foreach ($sourceResidents as $sourceResident) {
        //Keep track of what we do (statitics):
        if ( ! isset($destinationResidents[$sourceResident->id])) {
            echo("Syncing new user with id={$sourceResident->id} name='{$sourceResident->first_name} {$sourceResident->last_name}'.".PHP_EOL);
            $numNew++;
        } else {
            if ($destinationResidents[$sourceResident->id]->first_name != $sourceResident->first_name
                && $destinationResidents[$sourceResident->id]->first_name != $sourceResident->last_name) {
                echo("Name of user with id={$sourceResident->id} changed from '{$sourceResident->first_name} {$sourceResident->last_name}' "
                    ."to '{$hekdphoneResident->first_name} {$destinationResident->last_name}'".PHP_EOL); // Normaly the name of a user should not change. Something might be wrong.
            }
            $numOld++;
        }

        // Transfer the base date for the record from hekDb to hekphoneDb.
        // If it does not yet exist it will be generated automatically:
        $destinationResident = $destinationResidents[$sourceResident->id]; // = does not clone the object but merely references to it.
        $destinationResident->id         = $sourceResident->id;
        $destinationResident->first_name = $sourceResident->first_name;
        $destinationResident->last_name  = $sourceResident->last_name;
        $destinationResident->move_in    = $sourceResident->move_in;
        $destinationResident->move_out   = $sourceResident->move_out;
        if( ! $sourceResident->room_no) {
            $destinationResident->room   = $destinationResident->room;  // Room No stays the same even on move_out
        } else {
            $roomId = $roomTable->findOneByRoom_no($sourceResident->room_no)->id;
            if ( ! $roomId ) {
                echo("Syncing user id={$sourceResident->id}, name='{$sourceResident->first_name} {$sourceResident->last_name}' failed: Room not found!.".PHP_EOL);
                $failedPartly = true;
                $roomId = NULL;
            }
            $destinationResident->room = $roomId;
        }
    }

    $destinationResidents->save();
    echo("Synced $numOld old user entries and $numNew new entries.".PHP_EOL);
    if ( $failedPartly )
        exit(1);
    else
        exit(0);
  }
}
