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

	// Notice message types
	const ERROR      = 'error';
	const WARNING    = 'warning';
	const VALIDATION = 'validation';
	const INFO       = 'information';
	const SUCCESS    = 'success';

	/**
	 * Adds a new notice message
	 *
	 * @param   string  Message type
	 * @param   string  Message text
	 * @param   array   Message variables
	 * @param   array   Additional messages
	 * @return	void
	 */
	public static function add($type, $message = NULL, array $variables = NULL, array $items = array())
	{
		$session = Session::instance(Notice::$session);

		$notices = $session->get('notice', array());

		$notices[$type][] = array(
			'type'      => $type,
			'message'   => $message,
			'variables' => $variables,
			'items'     => $items,
		);

		$session->set('notice', $notices);
	}

	/**
	 * Render the notices
	 *
	 * If notice type omitted, render all notice types
	 *
	 * @param   string  Notice type
	 * @return	array
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
					'message' => __($notice['message'], $notice['variables']),
					'items'   => array_map('__', $notice['items']),
				);
			}
		}

		// Clear the notices
		Notice::clear($type);

		return $rendered;
	}

	/**
	 * Return notices as raw array
	 *
	 * @param    string  Notice type
	 * @return   array
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
	 * Clears the notices
	 *
	 * @param    string  Notice type
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