## Introduction

Notice is simple and easy to use class for displaying notification messages to the user for Kohana 3.x.

## Instalation

	$ git submodule add git://github.com/loonies/kohana-notice.git modules/notice
	$ git submodule update --init

## General

A Notice message consist of:

*  Type - The message type
*  Message - The message itself
*  Variables - The message varibles
*  Items - Additional message items i.e. submessages

## Usage

Add a new message.

	Notice::add(Notice::ERROR, 'Unable to download :module. Please:', array('module' => $module), array(
		'Check your connection', 'Check configuration settings'
	));

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
