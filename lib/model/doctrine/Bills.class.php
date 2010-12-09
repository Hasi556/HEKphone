<?php

/**
 * Bills
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Bills extends BaseBills
{
    /**
     * Get all calls associated with the bill.
     */
    public function getCalls()
    {
        return Doctrine_query::create()
               ->from('Calls c')
               ->addWhere('c.bill = ?', $this->id)
               ->execute();
    }


    /**
     * For one bill the content for the *.ctl file for the dtaus program is returned.
     * @param $start Start date for bill period
     * @param $end End date for the bill period
     * @return string The string of the dtaus entry or an empty string if the dtaus entry could not be generated
     */
    public function getDtausEntry($start, $end)
    {
    	$dtausEntry = null;

    	//If there is not the required information given to generate the dtaus entry for a resident an empty string is returned
    	if ($this['Residents']['last_name']  == null || $this['Residents']['account_number'] == null || $this['Residents']['bank_number'] == null )
    	{
    		//TODO: sfContext::getInstance()->getLogger()->info("No dtaus entry for bill ".$bill['id']." with amount ".$this['amount']."EUR");//$this->logMessage("No dtaus entry for bill ".$bill['id'], 'info');
    		echo "No dtaus entry for bill " . $this['id'] . " with amount " . $this['amount'] . " EUR" . PHP_EOL;
    	}
    	else
    	{
            $dtausEntry = "{
  Name  " . $this['Residents']['last_name'] . "
  Konto " . $this['Residents']['account_number'] ."
  BLZ   " . $this['Residents']['bank_number'] . "
  Transaktion   Einzug
  Betrag    " . $this['amount']."
  Zweck " . sfConfig::get("transactionName")."
  myName  " . sfConfig::get("hekphoneName")."
  myKonto " . sfConfig::get("hekphoneAccountnumber")."
  myBLZ " . sfConfig::get("hekphoneBanknumber")."
  Text  " . $start . " BIS " . $end."
}
";
     	}

    return $dtausEntry;
    }

    /**
     * A string with all itemized Bill entries for each related call of the bill is returned
     * @return string
     */
    public function getItemizedBill()
    {
    	$itemizedBill = null;
        foreach($this['Calls'] as $call)
        {
            $itemizedBill .= $call->getItemizedBillEntry()."\n";
  	    }

        return $itemizedBill;
    }
}
