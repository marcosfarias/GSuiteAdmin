<?php

	
	
	
	public function index() {


		$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());

		$optParams = array('domain' => 'marcosfarias.com', 'maxResults' => '100');

		$results = $service->users->listUsers($optParams);

		foreach ($results->getUsers() as $user) {
			printf("<br/>%s (%s) %s\n", $user->getPrimaryEmail(),
					$user->getName()->getFullName(),$user->getPassword());
		}

	}