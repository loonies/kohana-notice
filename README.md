## Introduction

Notice is simple and easy to use class for displaying notification messages to the user for Kohana 3.x.

## Instalation

	$ git submodule add git://github.com/loonies/kohana-notice.git modules/notice
	$ git submodule update --init

## General

A Notice message consist of:

*  *type* - the message type
*  *message* - the message itself
*  *variables* - the message varibles
*  *items* - additional messages

## Configuration

Configuration is done by using class properties:

*  *Notice::$session* - session type
*  *Notice::$view* - view file

## Usage

Add a new message.

	Notice::add(Notice::ERROR, 'Unable to download :module. Please:', array('module' => $module), array(
		'Check your connection', 'Check configuration settings'
	));

	Notice::add(Notice::VALIDATION, 'Validation failded:', NULL, $validate->errors('validation'));

	Notice::add(Notice::INFO, Kohana::message('notice', 'no_data'));

Render the notifications.

	View::factory('download')
		->bind('notice', $notice);

	$notice = Notice::render();

Render the notifications as json (useful for AJAX response).

	Notice::render(NULL, 'json');

Get all the *error* notices as array.

	$errors = Notice::as_array(Notice::ERROR);

Clear the *warning* notices.

	Notice::clear(Notice::WARNING);
