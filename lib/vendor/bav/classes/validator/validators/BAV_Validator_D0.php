<?php
BAV_Autoloader::add('BAV_Validator_20.php');
BAV_Autoloader::add('BAV_Validator_09.php');
BAV_Autoloader::add('../BAV_Validator.php');
BAV_Autoloader::add('../../bank/BAV_Bank.php');


/**
 * Copyright (C) 2008  Markus Malkusch <bav@malkusch.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *
 * @package classes
 * @subpackage validator
 * @author Markus Malkusch <bav@malkusch.de>
 * @copyright Copyright (C) 2008 Markus Malkusch
 */
class BAV_Validator_D0 extends BAV_Validator {


    const SWITCH_PREFIX = '57';


    private
    /**
     * @var BAV_Validator
     */
    $validator;


    public function __construct(BAV_Bank $bank) {
        parent::__construct($bank);
    }
    
    
    protected function validate() {
        $this->validator = substr($this->account, 0, 2) !== self::SWITCH_PREFIX
                         ? new BAV_Validator_20($this->bank)
                         : new BAV_Validator_09($this->bank);
    }
    
    
    /**
     * @return bool
     */
    protected function getResult() {
        return $this->validator->isValid($this->account);
    }
    

}


?>