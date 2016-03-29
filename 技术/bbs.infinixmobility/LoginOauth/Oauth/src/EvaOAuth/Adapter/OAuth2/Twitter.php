<?php
    
namespace EvaOAuth\Adapter\OAuth2;

use EvaOAuth\Adapter\OAuth2\AbstractAdapter;
use EvaOAuth\Service\Token\Access as AccessToken;

class Twitter extends AbstractAdapter
{
    //protected $accessTokenFormat = 'pair';
//protected $authorizeUrl = "https://oauth.twitter.com/2/authorize";
    protected $authorizeUrl = "https://api.twitter.com/oauth2/token";
    protected $accessTokenUrl = "https://api.twitter.com/oauth2/token";

}
