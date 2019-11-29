<?php



// DATABSE
require_once 'db/DBPDO.php';
require_once 'db/DbFactory.php';

// CORE
require_once 'core/HTTP.php';
require_once 'core/Router.php';
require_once 'core/MyException.php';

// COMPOSER
require_once 'vendor/autoload.php';

// CONTROLLERS
require_once 'app/Controllers/Controller.php';
require_once 'app/Controllers/HomeController.php';
// require_once 'app/Controllers/BlogController.php';
// require_once 'app/Controllers/PostController.php';
require_once 'app/Controllers/UserController.php';
require_once 'app/Controllers/SigninController.php';
require_once 'app/Controllers/SignupController.php';
// require_once 'app/Controllers/PasswordController.php';
require_once 'app/Controllers/DocsController.php';
require_once 'app/models/Docs.php';
// require_once 'app/models/Blog.php';
// require_once 'app/models/Post.php';
// require_once 'app/models/Comment.php';
// require_once 'app/models/Profile.php';

// MODELS
require_once 'app/models/Signin.php';
require_once 'app/models/Signup.php';
require_once 'app/models/SignupConfirm.php';
require_once 'app/models/User.php';
// require_once 'app/models/Password.php';
// require_once 'app/models/Image.php';
// require_once 'app/models/Email.php';

// HELPERS
require_once 'helpers/functions.php';
require_once 'helpers/ExecutionTime.php';
require_once 'helpers/Validation.php';
require_once 'helpers/email/Email.php';
require_once 'helpers/email/EmailSubscription.php';
require_once 'helpers/Log.php';
require_once 'helpers/Sessions.php';


