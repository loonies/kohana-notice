# Examples

Add a new notice:

    Notice::add(Notice::ERROR, 'Some error occured');

Add a notice with message text from the message file:

    Notice::add(Notice::INFO, ':no_data');

Add a notice with values:

    $module = 'blackbox';

    Notice::add(Notice::WARNING, 'Are you sure you want to remove :module?', array(
        ':module' => $module,
    ));

Add a notice with additional messages:

    $validate = Validation::factory($data);

    $errors = $validate->errors('validation');

    Notice::add(Notice::VALIDATION, 'Validation failded:', NULL, $errors);

Add a notice with additional messages:

	Notice::add(Notice::ERROR, 'Some error occured while activating the module:', NULL, array(
		'Check configuration settings',
		'Check file permissions',
	));

Get all the *error* notices as array:

	$errors = Notice::as_array(Notice::ERROR);

Display the notices:

	$notices = Notice::render();

	echo View::factory('notice/base')
		->set('notices', $notices);

Remove the *warning* notices:

	Notice::clear(Notice::WARNING);
