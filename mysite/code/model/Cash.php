<?php

class Cash {

	public static function make($tla, $amount) {

		$money = new Money();
		$money->setValue(array(
			'Currency' => $tla,
			'Amount' => $amount
		));
		return $money;

	}


}