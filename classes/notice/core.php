<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Simple and easy to use class for storing and displaying
 * the application notice messages to the user.
 * The Notice class uses session to store the notice messages.
 *
 * @package    Notice
 * @category   Base
 * @author     Miodrag Tokić <mtokic@gmail.com>
 * @copyright  (c) 2010-2012, Miodrag Tokić
 * @license    MIT
 */
class Notice_Core {

	// Current version
	const VERSION = '0.4.0-dev';

	// Notice types
	const ERROR      = 'error';
	const WARNING    = 'warning';
	const VALIDATION = 'validation';
	const INFO       = 'information';
	const SUCCESS    = 'success';

	/**
	 * @var  string  Session type
	 */
	public static $session = NULL;

	/**
	 * @var  string  The message file
	 */
	public static $message_file = 'notice';

	/**
	 * Adds a new notice message
	 *
	 *     // Add INFO notice
	 *     Notice::add(Notice::INFO, 'Simple example');
	 *
	 *     // Add INFO notice, with a message from the "notice" message file
	 *     Notice::add(Notice::INFO, ':no_data');
	 *
	 * @param   string  Notice type
	 * @param   string  Message text
	 * @param   array   Values to replace in the message text
	 * @param   array   Additional messages
	 * @return  void
	 */
	public static function add($type, $message = NULL, array $values = NULL, array $items = array())
	{
		$session = Session::instance(Notice::$session);

		$notices = $session->get('notice', array());

		if (strpos($message, ':') === 0)
		{
			// Get a message from a file
			$message = Kohana::message(Notice::$message_file, substr($message, 1), $message);
		}

		$notices[$type][] = array(
			'type'    => $type,
			'message' => $message,
			'values'  => $values,
			'items'   => $items,
		);

		$session->set('notice', $notices);
	}

	/**
	 * Clears the notices
	 *
	 * If notice type omitted, render all notice types.
	 *
	 *     // Clears all notices
	 *     Notice::clear();
	 *
	 *     // Clears only INFO notices
	 *     Notice::clear(Notice::INFO);
	 *
	 * @param   string  Notice type to filter by
	 * @return  void
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

	/**
	 * Return notices as raw array
	 *
	 * If notice type omitted, render all notice types.
	 *
	 *     // Return all notices
	 *     Notice::as_array();
	 *
	 *     // Return only INFO notices
	 *     Notice::as_array(Notice::INFO);
	 *
	 * @param   string  Notice type to filter by
	 * @return  array
	 */
	public static function as_array($type = NULL)
	{
		$session = Session::instance(Notice::$session);

		$notices = $session->get('notice', array());

		$filtered = array();

		foreach ($notices as $_type => $set)
		{
			if ($type === $_type OR $type === NULL)
			{
				// Add to filtered
				$filtered[$_type] = $set;
			}
		}

		return $filtered;
	}

	/**
	 * Render the notices
	 *
	 * Notice messages will be translated, grouped by type and cleared.
	 * If notice type omitted, render all notice types.
	 *
	 *     // Renders all notices
	 *     Notice::render();
	 *
	 *     // Renders only INFO notices
	 *     Notice::render(Notice::INFO);
	 *
	 * @param   string  Notice type to filter by
	 * @return  array
	 */
	public static function render($type = NULL)
	{
		$rendered = array();

		$notices = Notice::as_array($type);

		foreach ($notices as $_type => $set)
		{
			foreach ($set as $notice)
			{
				// Translate the notice
				$rendered[$_type][] = array(
					'type'    => __($notice['type']),
					'message' => __($notice['message'], $notice['values']),
					'items'   => array_map('__', $notice['items']),
				);
			}
		}

		// Clear the notices
		Notice::clear($type);

		return $rendered;
	}
}
