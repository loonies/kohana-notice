<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Notification messages
 *
 * @package    Notice
 * @category   Base
 * @author     Miodrag Tokić
 * @copyright  (c) 2010-2011, Miodrag Tokić
 * @license    MIT
 */
class Notice_Core {

	// Current version
	const VERSION = '0.2';

	/**
	 * @var  string  Session type
	 */
	public static $session = NULL;

	/**
	 * @var  string  View file
	 */
	public static $view = 'notice/base';

	// Notice message types
	const ERROR      = 'error';
	const WARNING    = 'warning';
	const VALIDATION = 'validation';
	const INFO       = 'information';
	const SUCCESS    = 'success';

	/**
	 * Adds new notification message
	 *
	 * @param   string  Message type
	 * @param   string  Message text
	 * @param   array   Message variables
	 * @param   array   Additional message items
	 * @return	void
	 */
	public static function add($type, $message = NULL, array $variables = NULL, array $items = array())
	{
		$session = Session::instance(Notice::$session);

		$notifications = $session->get('notice', array());

		$notifications[$type][] = array(
			'message'	=>	__($message, $variables),
			'items'		=>	$items,
		);

		$session->set('notice', $notifications);
	}

	/**
	 * Displays notifications
	 *
	 * If notification type omitted, displays all notification types
	 *
	 * @param   string  Notification type
	 * @param   string  View type
	 * @return	void
	 */
	public static function render($type = NULL, $view = NULL)
	{
		switch ($view)
		{
			case 'json':
				$output = json_encode(Notice::as_array($type));
			break;

			default:
				$output = View::factory(Notice::$view)
					->set('notifications', Notice::as_array($type))
					->render();
		}

		// Clear the notifications after rendering
		Notice::clear($type);

		return $output;
	}

	/**
	 * Returns the current notification array.
	 *
	 * @param    string  Notification type
	 * @return   array
	 */
	public static function as_array($type = NULL)
	{
		$session = Session::instance(Notice::$session);

		// Import the session data localy
		$data = $session->as_array();

		if ($type === NULL)
		{
			return Arr::path($data, 'notice', array());
		}
		else
		{
			return array($type => Arr::path($data, 'notice.'.$type));
		}
	}

	/**
	 * Clears the notifications
	 *
	 * @param    string  Notification type
	 * @return   void
	 */
	public static function clear($type = NULL)
	{
		$session = Session::instance(Notice::$session);

		// Assign the session data localy
		$data =& $session->as_array();

		if ($type === NULL)
		{
			unset($data['notice']);
		}
		else
		{
			unset($data['notice'][$type]);
		}
	}
}