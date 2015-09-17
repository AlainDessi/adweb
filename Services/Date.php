<?php

namespace Core\Services;

class Date
{

  private $DateStamp;
  private $str_date;


  public function __construct($DateStamp)
  {
      $this->DateStamp = $DateStamp;

      $date_exist = preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}#', $this->DateStamp, $matches);
      if ( $date_exist )
      {
          $this->str_date = $matches[0];
      }
  }

	/**
	 * Ajoute des jours/mois ou année
	 * @param datestamp  $date
	 * @param integer $day
	 * @param integer $mth
	 * @param integer $yr
	 */
	public static function add_date($date,$day=0,$mth=0,$yr=0)
	{
  		$cd = strtotime($date);
  		$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
  		date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
  		date('d',$cd)+$day, date('Y',$cd)+$yr));

  		return $newdate;
  }

  /**
   * Transforme une date
   * au format Français au format US
   */
	public function DateFRtoUS()
  {
  		$var = explode('/',$this->str_date);
  		$DateUS = $var[2].'-'.$var[1].'-'.$var[0];

  		return $DateUS;
	}

	/**
	 * Transforme une date Us
	 * en Format français
	 */
	public function DateUStoFR()
  {
  		$var = explode('-',$this->str_date);
  		$DateFR = $var[2].'/'.$var[1].'/'.$var[0];

  		return $DateFR;
	}


	public static function DateFr($datestamp)
	{
  		$date = new \DateTime($datestamp);
	   	return $date->format('d/m/Y');
	}

} // end class
