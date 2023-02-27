<?php namespace Modules\Livestream\Configuration;

use Modules\Livestream\Omnia;
use Exception;
use Laravel\Spark\Plan;

trait ManagesAvailableAddons {

	/**
	 * @param int|string $id Searches by the Title of the Addon
	 **
	 *
	 * @return Plan
	 * @throws Exception
	 */
	public static function getAddonByTitle( $id ) {
//		if ($teamPlans === false) {
//			$plans = Omnia::plans();
//		} else {
//			$plans = Omnia::teamPlans();
//		}
//		$plan = $plans->where('id', $id)->first();

//		if (empty($plan)) {
//			throw new Exception('Could not find that plan by identifier: ' . $id);
//		} else {
//			return $plan;
//		}
	}

	public static function getAllAddons() {
		return array(
			[
				'title'       => 'Automatic Live Schedules',
				'slug'        => 'live-schedules',
				'description' => 'Setup time blocks that your Episode Templates will follow to simplify your workflow and have your livestream start on-time',
				'icon'        => 'clock-o',
				'price'       => 4
			],
			[
				'title'       => 'Remove Ads',
				'slug'        => 'remove-ads',
				'description' => 'Video Players have family-friendly ads Only, but you can remove Ads all together',
				'icon'        => 'television',
				'price'       => 14
			],
			[
				'title'       => 'iOS & Android Mobile App',
				'slug'        => 'mobile-apps',
				'description' => 'Customized App for iPhones and Androids',
				'icon'        => 'apple',
				'price'       => 49
			],
			[
				'title'       => 'DVR',
				'slug'        => 'dvr',
				'description' => 'Live DVR recording. Allows playback to be started from beginning',
				'icon'        => 'fast-backward',
				'price'       => 4
			],
			[
				'title'       => 'Apple TV App',
				'slug'        => 'apple-tv-app',
				'description' => 'Apple TV App so your viewers can watch from their Apple TV',
				'icon'        => 'apple',
				'price'       => 9
			],
			[
				'title'       => 'Roku Channel',
				'slug'        => 'roku-app',
				'description' => 'Roku Channel so your members can watch from their Roku',
				'icon'        => 'users',
				'price'       => 9
			],
//			[
//				'title'       => 'Phone Support',
//				'slug'        => 'support-phone',
//				'description' => 'Get your questions answered on the phone in addition to Email and Live Chat support',
//				'icon'        => 'life-ring',
//				'price'       => 14
//			],
			[
				'title'       => '24/7 Dedicated Technician',
				'slug'        => 'support-24-7',
				'description' => 'Dedicated Support Technician assigned to your organization to help support you in any way 24/7 (Phone, Email, Live Chat, Heck, you could even write letters to them if you\'d like :D)',
				'icon'        => 'life-ring',
				'price'       => 59,
				'premium'     => true
			],
			[
				'title'       => '+5 Team Members',
				'slug'        => 'team-members-five',
				'description' => 'Add 5 More Team Members to your team to allow Role Permissions and different logins for each member',
				'icon'        => 'users',
				'price'       => 9
			],
			[
				'title'       => 'Worldwide CDN - Video On Demand ',
				'slug'        => 'cdn-vod',
				'description' => 'Content Delivery Netwrok for lightning speed and performance for your On-Demand Videos',
				'icon'        => 'bolt',
				'price'       => 79,
				'premium'     => true
			],
			[
				'title'       => 'Worldwide CDN - Live',
				'slug'        => 'cdn-live',
				'description' => 'Content Delivery Netwrok for lightning speed and performance for your Live Videos',
				'icon'        => 'bolt',
				'price'       => 79,
				'premium'     => true
			],
			[
				'title'       => 'Youtube Live Streaming',
				'slug'        => 'stream-target-youtube',
				'description' => 'Stream straight to Youtube from Omnia with little setup',
				'icon'        => 'youtube',
				'price'       => 0,
				'premium'     => false
			],
			[
				'title'       => 'Facebook Live Streaming',
				'slug'        => 'stream-target-facebook',
				'description' => 'Stream straight to Facebook from Omnia with little setup',
				'icon'        => 'facebook',
				'price'       => 14,
				'premium'     => false
			]
			//			[
//				'title'       => 'Video Storage',
//				'slug'        => 'Video Storage',
//				'description' => '5GB Video Storage Included + $1/GB overage *',
//				'icon'        => 'hdd-o',
//				'price'       => 0,
//	        ],
//			[
//				'title'       => 'Video On Demand (Archive)',
//				'slug'        => 'Video Storage',
//				'description' => 'Video on demand so people can see your services whenever they want',
//				'icon'        => 'power-off',
//				'price'       => 0
//			],
//			[
//				'title'       => 'Live Player Embedding',
//				'slug'        => 'Video Storage',
//				'description' => 'Live player embed on your website',
//				'icon'        => 'youtube-play',
//				'price'       => 0
//			],
//			[
//				'title'       => 'Admin Dashboard',
//				'slug'        => 'Video Storage',
//				'description' => 'Easily Manage your Livestream on the web or on your phone',
//				'icon'        => 'tachometer',
//				'price'       => 0
//			],
//			[
//				'title'       => 'Live Player works on any device',
//				'slug'        => 'Video Storage',
//				'description' => 'Complete Responsive design so it works on every device',
//				'icon'        => 'tablet',
//				'price'       => 0
//			],
//			[
//				'title'       => '24/7 Email & Live Chat Support',
//				'slug'        => 'Video Storage',
//				'description' => 'We will answer all your questions as quick as possible. Yes, that even means on Sunday mornings. ;)',
//				'icon'        => 'life-ring',
//				'price'       => 0
//			],
		);
	}
}
