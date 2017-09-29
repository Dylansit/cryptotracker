<?php

class UpdateCurrenciesTask extends BuildTask {

	protected $title = 'Update Currencies and Prices Task';

	protected $description = 'Sends a request to an external API to retrieve all currencies and their current price';

	public function run($request) {
		ini_set('max_execution_time', 0);
		$fetcher = new PriceFetcher();
		$fetcher->process();
	}
}
