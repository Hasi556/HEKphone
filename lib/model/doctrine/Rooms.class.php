<?php

/**
 * Rooms
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Rooms extends BaseRooms
{
  public function __toString()
  {
    return str_pad($this->getRoomNo(), 3, "0", STR_PAD_LEFT);
  }
}
