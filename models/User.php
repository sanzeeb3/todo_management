<?php
namespace app\models;
use Yii;

//app\models\Users is the model generated using Gii from users table

use app\models\Profile as DbUser;

class User extends \yii\base\Object implements \yii\web\IdentityInterface {

public $id;
public $username;
public $password;
public $authKey;
public $token;
public $email;
public $position;
public $status;
public $user_type;

/**
 * @inheritdoc
 */

public static function findIdentity($id) {
    $dbUser = DbUser::find()
            ->where([
                "id" => $id
            ])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

/**
 * @inheritdoc
 */
public static function findIdentityByAccessToken($token, $userType = null) {

    $dbUser = DbUser::find()
            ->where(["token" => $token])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

/**
 * Finds user by username
 *
 * @param  string      $username
 * @return static|null
 */

public static function findByUsername($username) {
    $dbUser = DbUser::find()
            ->where([
                "username" => $username
            ])
            ->one();
    if (!count($dbUser)) 
    {
                    return null;
    }
    return new static($dbUser);
}

/**
 * @inheritdoc
 */
public function getId() {
    return $this->id;
}

/**
 * @inheritdoc
 */
public function getAuthKey() 
{
    return $this->authKey;
}

/**
 * @inheritdoc
 */
public function validateAuthKey($authKey) 
{
    return $this->authKey === $authKey;
}

/**
 * Validates password
 *
 * @param  string  $password password to validate
 * @return boolean if password provided is valid for current user
 */
public function validatePassword($password)
    {

        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    

// public function session_validate()
//     {

//         // Encrypt information about this session
//         $user_agent = $this->session_hash_string($_SERVER['HTTP_USER_AGENT'], 'asdfasfd');
    
//         // Check for instance of session
//         if ( session_exists() == false )
//         {
//             // The session does not exist, create it
//              $this->session_reset($user_agent);
//         }
        
//         // Match the hashed key in session against the new hashed string
//         if ( $this->session_match($user_agent) )
//         {
//             return true;
//         }
        
//         // The hashed string is different, reset session
//         $this->session_reset($user_agent);
//         return false;
//     }

//     /**
//      * session_exists()
//      * Will check if the needed session keys exists.
//      *
//      * @return {boolean} True if keys exists, else false
//      */
    
//     private function session_exists()
//     {
//         return isset($_SESSION['USER_AGENT_KEY']) && isset($_SESSION['INIT']);
//     }
    
//     /**
//      * session_match()
//      * Compares the session secret with the current generated secret.
//      *
//      * @param {String} $user_agent The encrypted key
//      */
    
//     private function session_match( $user_agent )
//     {
//         // Validate the agent and initiated
//         return $_SESSION['USER_AGENT_KEY'] == $user_agent && $_SESSION['INIT'] == true;
//     }
    
//     /**
//      * session_encrypt()
//      * Generates a unique encrypted string
//      *
//      * @param {String} $user_agent      The http_user_agent constant
//      * @param {String} $unique_string    Something unique for the user (email, etc)
//      */
    
//     private function session_hash_string( $user_agent, $unique_string )
//     {
//         return md5($user_agent.$unique_string);
//     }
    
//     /**
//      * session_reset()
//      * Will regenerate the session_id (the local file) and build a new
//      * secret for the user.
//      *
//      * @param {String} $user_agent
//      */
    
//     private function session_reset( $user_agent )
//     {
//         // Create new id
//         session_regenerate_id(TRUE);
//         $_SESSION = array();
//         $_SESSION['INIT'] = true;
        
//         // Set hashed http user agent
//         $_SESSION['USER_AGENT_KEY'] = $user_agent;
//     }
    
//     /**
//      * Destroys the session
//      */
    
//     private function session_destroy()
//     {
//         // Destroy session
//         session_destroy();
//     }

}