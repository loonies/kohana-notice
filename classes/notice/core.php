<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Notification messages
 *
 * @package	Notice
 * @author	Miodrag Tokić
 * @copyright	Copyright (c) 2009 - 2010, Miodrag Tokić
 * @license	http://www.opensource.org/licenses/bsd-license.php	BSD
 */
class Notice_Core {

	/**
	 * @var	string	Messages file
	 */
	public static $file = 'notice';

	/**
	 * @var	string	View file
	 */
	public static $view = 'notice/base';

	// Notice message types
	const ERROR   = 'error';
	const WARNING = 'warning';
	const VALID   = 'validation';
	const INFO    = 'information';
	const SUCCESS = 'success';

	/**
	 * Adds new notification message
	 *
	 * @param	string	Message type
	 * @param	string	Message text
	 * @param	array	Message variables
	 * @param	array	Additional message items
	 * @return	void
	 */
	public static function add($type, $message = NULL, array $variables = NULL, array $items = array())
	{
		$session = Session::instance('native');

		$notifications = $session->get('notice', array());

		$notifications[$type][] = array(
			'message'	=>	__($message, $variables),
			'items'		=>	$items,
		);

		$session->set('notice', $notifications);
	}

	/**
	 * Returns a message from a file.
	 *
	 * @uses	Kohana::message
	 *
	 * @param	string	Message key
	 * @return	string
	 */
	public static function message($key)
	{
		return Kohana::message(Notice::$file, $key);
	}

	/**
	 * Displays notification
	 *
	 * If notification type omitted, displays all notification types
	 *
	 * @param	string	Notification type
	 * @return	void
	 */
	public static function render($type = NULL)
	{
		if ($type === NULL)
		{
			$session = Session::instance('native');

			// Import all notification types localy
			$notifications = $session->get('notice', array());

			// Clear notice session
			$session->set('notice', array());
		}
		else
		{
			$notifications[$type] = Notice::get_once($type);
		}

		return View::factory(Notice::$view)
			->set('notifications', $notifications)
			->render();
	}

	/**
	 * Implemened K 2.3 get_once() method from Session class
	 */
	protected static function get_once($type)
	{
		$session = Session::instance('native');

		$notifications = $session->get('notice', array());

		$data = Arr::get($notifications, $type, array());

		// Remove flash data
		unset($notifications[$type]);

		$session->set('notice', $notifications);

		return $data;
	}

	final private function __construct()
	{
		// Enforce singleton behavior
	}

	private function __clone()
	{
		// Enforce singleton behavior
	}
}
