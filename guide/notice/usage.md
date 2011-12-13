# Usage

## General

Predefined notice types are:

 - `Notice::ERROR`
 - `Notice::WARNING`
 - `Notice::VALIDATION`
 - `Notice::INFO`
 - `Notice::SUCCESS`

[!!] You should always use one of predefined constant for the notice type.

## Adding a notice

To add a new notice use [Notice::add] method. Method parameters are:

TYPE
: Defines a type of notice.

MESSAGE
:  Notice message text. If you prefix **message** parameter with a colon (:) it will get a message text from the message file as [defined](config) by [Notice::$message_file].

VALUES
:  Values to replace in the message text.

[!!] Values are replaced when rendering notices.

ITEMS
:  Array of additional messages.

## Getting notices

There are two methods to get notices:

 - [Notice::as_array]
 - [Notice::render]

Both methods will return notices as array grouped by *type* and they both accept *type* parameter to filter returned notices (default is to return all notices).

[Notice::as_array] will return raw notices, while [Notice::render] will translate message text by using __() function defined in the [I18n] class and will remove them from the session.

## Deleting notices

Use [Notice::clear] to remove notices. Filter them by *type* parameter (default is to remove all notices).

## Displaying notices

This module comes with Kohana view file (*views/notice/base*), however the Notice class doesn't limit the way notices are displayed to the user. Use them as json, with KOstache, KOtal or whatever you like.