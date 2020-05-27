<?php

namespace Admin\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Google_Client;
use Google_Service_Analytics;

class AnalyticsComponent extends Component
{
	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	public $Analytics;

	public function initialize(array $config)
	{
		// Create and configure a new client object.
		$client = new Google_Client();
		$client->setApplicationName("Hello Analytics Reporting");
		$client->setAuthConfig(WWW_ROOT . '/keys/service-account-credentials.json');
		$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
		$this->AnalyticsService = new Google_Service_Analytics($client);
	}

	function getFirstProfileIdByProperty($accountId, $webpropertyId) {
		$profiles = $this->AnalyticsService->management_profiles->listManagementProfiles($accountId, $webpropertyId);

		if (count($profiles->getItems()) > 0) {
			$items = $profiles->getItems();
			return $items[0]->getId();
		}

		return null;
	}

	function getUsersNumbers($profileId) {
		$today = $this->AnalyticsService->data_ga->get('ga:' . $profileId, 'today', 'today', 'ga:users');
		$todayCount = (count($today->getRows() > 0)) ? $today->getRows()[0][0] : 0;

		$week = $this->AnalyticsService->data_ga->get('ga:' . $profileId, '7daysAgo', 'today', 'ga:users');
		$weekCount = (count($week->getRows() > 0)) ? $week->getRows()[0][0] : 0;

		$month = $this->AnalyticsService->data_ga->get('ga:' . $profileId, '30daysAgo', 'today', 'ga:users');
		$monthCount = (count($month->getRows() > 0)) ? $month->getRows()[0][0] : 0;

		return [
			'today' => $todayCount,
			'week' => $weekCount,
			'month' => $monthCount
		];
	}

	public function getUsersNumbersByDate($profileId, $initialDate, $finalDate) {
		$users = $this->AnalyticsService->data_ga->get('ga:' . $profileId, $initialDate, $finalDate, 'ga:users');
		$usersCount = (count($users->getRows() > 0)) ? $users->getRows()[0][0] : 0;
		return $usersCount;
	}
}
