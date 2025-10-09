<?php

namespace Core\Services;

class Date
{

	private int $DateStamp;
	private string $str_date;
	private array $month = [
		'Janvier',
		'Février',
		'Mars',
		'Avril',
		'Mai',
		'Juin',
		'Juillet',
		'Août',
		'Septembre',
		'Octobre',
		'Novembre',
		'Décembre'
	];

	public function __construct(int $DateStamp)
	{
		$this->DateStamp = $DateStamp;

		$date_exist = preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}#', $this->DateStamp, $matches);
		if ($date_exist) {
			$this->str_date = $matches[0];
		}
	}

	/**
	 * Ajoute des jours/mois ou année
	 */
	public static function add_date(string $date, int $day = 0, int $mth = 0, int $yr = 0)
	{
		if (!is_null($date)) {
			$cd = strtotime($date);
			return date('Y-m-d h:i:s', mktime(
				date('h', $cd),
				date('i', $cd),
				date('s', $cd),
				date('m', $cd) + $mth,
				date('d', $cd) + $day,
				date('Y', $cd) + $yr
			));
		} else {
			return '1901-01-01 00:00:00';
		}
	}

	/**
	 * Transforme une date
	 * au format Français au format US
	 */
	public function DateFRtoUS()
	{
		$var = explode('/', $this->str_date);
		$DateUS = $var[2] . '-' . $var[1] . '-' . $var[0];

		return $DateUS;
	}

	/**
	 * Transforme une date Us
	 * en Format français
	 */
	public function DateUStoFR()
	{
		$var = explode('-', $this->str_date);
		$DateFR = $var[2] . '/' . $var[1] . '/' . $var[0];

		return $DateFR;
	}


	public static function DateFr($datestamp)
	{
		if (!is_null($datestamp)) {
			$date = new \DateTime($datestamp);
			return $date->format('d/m/Y');
		} else {
			return '1901-01-01 00:00:00';
		}
	}
}
