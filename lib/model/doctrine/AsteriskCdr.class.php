<?php

/**
 * AsteriskCdr
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */

class AsteriskCdr extends BaseAsteriskCdr
{
    private $resident = NULL; // holds the resident associated with the call


    /*
     * Gets the resident associated with the call. This function will fetch the
     * resident from the database only if neccesary.
     */
    private function getResident() {
        if( ! ($this->resident instanceof Residents)) {
            $roomNumber = $this->getRoomNumber();

            /* Find the user living in this room at the calldate */
            $residentsTable = Doctrine_Core::getTable('Residents');
            $this->resident = $residentsTable->findByRoomNo($roomNumber,$this->calldate);
        }

        return $this->resident;
    }

    private function getRoomNumber() {
        // Extract the room number from the source.
        // The expression matches analog telephones were
        // $this->src is like 004972186951NNN as well as SIP phones which
        // have $this->src = "SIP/1NNN" where NNN is the room number.
        if($this->isIncomingCall()) {
            return substr($this->dst, -3);
        } else {
            return substr($this->src, -3);
        }
    }

    /**
     * Checks wheter the cdr represents a free call. Determined by the userfield
     * @return bool
     */
    function isFreeCall() {
        if($this->userfield == 'free') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks wheter the call is an incoming call or not.
     * @return bool
     */
    function isIncomingCall() {
        if(sfConfig::get('asteriskIncomingContext') == $this->dcontext) {
          return true;
        } else {
          return false;
        }
    }

    /**
     * Returns the destination number as string conformed to the prefixes
     * stored in the Prefixes relation e.g. 072186951 results in 00497218695.
     * It's supposed to work on outgoing calls on incoming calls it returns
     * $destination unmodified.
     *
     * Free calls specific to our Asterisk setup
     * (RSH: 0313NNN -> 00497211306NNN) are also taken into account
     * This is "hardcoded" - which is bad - and should be moved to a config variable.
     *
     * @throws Exception
     * @return string
     */
    function getFormattedDestination() {
        if ( ! $this->isIncomingCall()) {
            return $this->dst;
        }

        /* Conform $this->dst to  "0049+prefix+number" */
        if ( substr($this->dst,0,7) == '8695020' ) {
             //It's a free call using *721
             $destination = '0049' . substr($this->dst,7);
         } elseif ( substr($this->dst,0,4) == '0313' ) {
             // It's a free call to RSH
             $destination = '00497211306' . substr($this->dst,4);
         } elseif ( substr($this->dst,0,4) == '0315' ) {
             // It's a free call to ABH
             $destination = '00497211307' . substr($this->dst,4);
         } elseif ( substr($this->dst,0,2) == '00') {
             $destination = $this->dst;
         } elseif ( substr($this->dst,0,1) == '0' ) {
             $destination = '0049' . substr($this->dst,1);
         } elseif ( substr($this->dst,0,1) > 0 ) {
             $destination = '0049721' . $this->dst;
         } else {
             throw new Exception("Unable to match dialed number to any pattern");
         }

         return $destination;
    }

    /*
     * Replace last 3 digits of the destination with xxx
     * if $resident->shortened_itemized_bill is true.
     */
    function shortenDestination() {
        if ( $this->getResident()->shortened_itemized_bill) {
            return substr($this->dst, 0, -3) . 'xxx';
        } else {
            return $this->dst;
        }
    }

    function rebill() {
        // Delete old entry if it exists
        Doctrine_Query::create()
            ->delete('Calls')
            ->where('asterisk_uniqueid = ?', $this->uniqueid)
            ->execute();

        // mark cdr as unbilled
        $this->billed = false;

        //bill cdr again
        return $this->bill();
    }
    /**
     * Calculates the cost of an AsteriskCdr-Record (a finished call), creates
     * an record in the Calls table and marks the AsteriskCdr-Record as billed.
     * @throws Exception
     * @return AsteriskCdr
     */
    function bill() {
        /* Warn and abort if the call is already billed and no rebilling is whished */
        if($this->billed) {
            throw New Exception("The cdr has already been billed");
        }
        /* Only bill outgoing calls */
        if($this->isIncomingCall()) {
            throw new Exception("Trying to bill an incoming call");
        }
        /* Warn if trying to bill outgoing non-free calls of locked users */
        if( ! in_array($this->dcontext, sfConfig::get('asteriskUnlockedPhonesContexts')) && ! $free) {
            echo "[security warning] locked user made an outgoing call";
        }

        /* Parse the calls details */
        $destinationToBill = $this->getFormattedDestination();
        $destinationToSave = $this->shortenDestination();

        /* Create an entry in the calls table */
        $call = New Calls();
        $call->resident     = $this-getResident()->id;
        $call->extension    = 1000+$this->getRoomNumber();
        $call->date         = $this->calldate;
        $call->duration     = $this->billsec;
        $call->destination  = $destinationToSave;
        $call->asterisk_uniqueid = $this->uniqueid;

        /* Calculate the cost of the outgoing call */
        if($this->isFreeCall()) {
            $call->charges = 0;
            $call->rate    = 9999;
        } else {
            // Get the provider
            $provider = $this->userfield;

            $ratesTable = Doctrine_Core::getTable('Rates');
            $collRate = $ratesTable->findByNumberAndProvider(substr($destinationToBill,2), $provider);

            $call->charges     = $collRate->getCharge($this->billsec);
            $call->rate        = $collRate->id;
        }

        $call->save();

        /* Mark the cdr as billed */
        $this->billed = true;
        $this->save();

        // This message will show up in the postgres-logfile
        echo "[NOTICE] Billed call. Extension:" . $call->extension
             . "; Cost: ".round($call->charges,2) . "ct" . PHP_EOL;

        /* Check if the resident has (almost) reached) his limit, send warning emails and eventually lock the resident*/
        $resident->checkIfBillLimitIsAlmostReached();

        return $this;
    }
}