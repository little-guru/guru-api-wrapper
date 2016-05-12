# guru-api-wrapper

##To install

Add the following to your composer.json file and run `composer update`

```

{
    "repositories":
    [
       {
         "type": "vcs",
         "url": "https://github.com/little-guru/guru-api-wrapper"
       }
    ],
    "require":
    {
       "little-guru/guru-api-wrapper" : "dev-master"
    }
}

```

##To use

You can authenticate to use the API in two ways. One with API keys (Guru::withKeys) which gives you full access to all resources. 


```
$url = 'http:://platform.mylittleguru.co.uk/api/v1/';
$publicKey = 'sdlkfjslklksnlkf';
$privateKey = 'smsdlkfjlkdnflksdf'

$guru = Guru::withKeys($url, $publicKey, $privateKey);

$endpoint = 'units';

$params = [];

$response = $guru->get($endpoint, $params);

```

Secondly with a uer JSON Web Token (JWT). Use Guru::getUserToken() to authenticate the user and recive the token.

```
$url = 'http://platform.mylittleguru.co.uk/api/v1/';
$email = 'bob@bob.com';
$password = '123456';
$endpoint = 'users/auth';

$reponse = Guru::getUserToken($url, $endpoint, $email, $password);

$user = Guru::decodeUserToken($response->data->token);

$guru = Guru::withUserToken($url, $resposne->data->token);

$guru->setAccountId(1);

$endpoint = 'units';

$params = [];

$response = $guru->get($endpoint, $params);


```
