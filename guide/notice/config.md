# Configuration

Configuration is done by using class properties:

    // Session type
    Notice::$session = NULL;

    // The message file
    Notice::$message_file = 'notice';

SESSION
:  Session type (adapter) to use.

MESSAGE_FILE
:  Message file to use.

If you want to change properties set them somewhere in the *bootstrap*.