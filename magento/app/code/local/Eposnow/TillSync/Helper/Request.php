<?php

/**
 *
 *  Copyright 2011 EposNow
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
class Eposnow_TillSync_Helper_Request extends Mage_Core_Helper_Abstract {

    private $tillUrl;
    private $apiUrl;
    private $oauthUrl;
    private $consumerKey;
    private $consumerKeySecret;
    private $accessToken;
    private $accessTokenSecret;

    public function __construct()  {
        $settings               = Mage::helper('Eposnow_TillSync');
        $this->consumerKey      = $settings->getConfig('oauthConsumerKey');
        $this->consumerKeySecret= $settings->getConfig('oauthConsumerKeySecret');
        $this->accessToken      = $settings->getConfig('oauthAccessToken');
        $this->accessTokenSecret= $settings->getConfig('oauthAccessTokenSecret');
        $this->tillUrl          = $settings->getConfig('tillUrl');
        $this->tillUrl          = trim($this->tillUrl, "/");
        $this->apiUrl           = $this->tillUrl.'/api.svc/';
        $this->oauthUrl         = $this->tillUrl.'/OAuth.ashx';
    }

    /*
    *
        Example Usage:
        ==================================================================
        $data = ;
        $response = $request->request(
            'TestGetData', 
            'GET', 
            array(
                'magentoID' => '1',
                'title'     => 'title, sent to and thro',
            )
        );
        returns the response as an object
    */
    public function request($url, $method = 'GET', $data = array()) {
        $observer   = Mage::getModel('Eposnow_TillSync/Observer');
        $sessionKey = 'eposnow.oauth.requesttoken';

        switch($method) {
            case 'POST': $method = Zend_Http_Client::POST;
                break;
            case 'PUT': $method = Zend_Http_Client::PUT;
                break;
            case 'DELETE': $method = Zend_Http_Client::DELETE;
                break;
            default: $method = Zend_Http_Client::GET;
                break;
        }

        $config   = array(
            'callbackUrl'    => Mage::helper('core/url')->getCurrentUrl(),
            'consumerKey'    => $this->consumerKey,
            'consumerSecret' => $this->consumerKeySecret,
            'siteUrl'        => $this->oauthUrl,
            'requestTokenUrl'=> $this->oauthUrl,
            'accessTokenUrl' => $this->oauthUrl,
            'authorizeUrl'   => $this->oauthUrl,
        );
        $consumer = new Zend_Oauth_Consumer($config);

        // Step 3 (Authenticated)
        if (! empty($this->accessToken)) { 
            
            $tokenManager  = new Zend_Oauth_Token_Access();
            $tokenManager->setToken($this->accessToken);
            $tokenManager->setTokenSecret($this->accessTokenSecret);

            $client = $tokenManager->getHttpClient($config, $this->apiUrl.$url, array('timeout' => 600));
        
            $client->setMethod($method);
            $client->setHeaders('content-type: text/json; charset=utf-8');


            if ($method === Zend_Http_Client::POST) {
                $client->setRawData(json_encode($data));
            } else {
                $client->setParameterGet($data);
            }

            try {
                $response = $client->request();
            } catch (Exception $e) {
                Mage::throwException('Request.php:'.__LINE__.' - '. $e->getMessage());
            }

            if ($response->isError()) {
                Mage::throwException('Request.php:'.__LINE__.' - Request failed: '. $response->getStatus() .' - ' . $response->getMessage());
            }

            try {
                $result   = $response->getBody();
                $data     = json_decode($result);              
            } catch (Exception $e) {
                Mage::throwException('Request.php:'.__LINE__.' - '. $e->getMessage());
                
            }

            if (is_object($data) && property_exists($data, 'd')) {
                $data = json_decode($data->d);
            } elseif (is_object($data) && property_exists($data, 'ExceptionDetail')) {
                Mage::throwException('Request.php:'.__LINE__.' - '. $data->ExceptionDetail);
            } else {
                Mage::throwException('Request.php:'.__LINE__.' - Request failed: '.$result);
            }

            return $data; 


        // Step 2 (Get Access Token)
        } elseif (!empty($_GET) && isset($_SESSION[$sessionKey])) {
            $observer->log("Request Access Token");
            try {
                $accessToken = $consumer->getAccessToken($_GET, unserialize($_SESSION[$sessionKey]));
            } catch (Exception $e) {
                Mage::throwException('Request.php:'.__LINE__.' - '. $e->getMessage());
            }
            $_SESSION[$sessionKey] = null;

            $this->accessToken       = $accessToken->getToken();
            $this->accessTokenSecret = $accessToken->getTokenSecret();

            $settings = Mage::helper('Eposnow_TillSync');
            $settings->saveConfig('oauthAccessToken',       $this->accessToken);
            $settings->saveConfig('oauthAccessTokenSecret', $this->accessTokenSecret);

            $request = $this->request($url, $method, $data);
            $observer->log("Received Access Token");

            return $request;


        // Step 1 (Get Request Token)
        } else {
            $observer->log("Request Request Token");
            try {
                $requestToken = $consumer->getRequestToken(null, Zend_Http_Client::GET);
            } catch (Exception $e) {
                Mage::throwException('Request.php:'.__LINE__.' - '. $e->getMessage());
            }

            $_SESSION[$sessionKey] = serialize($requestToken);
            $observer->log("Received Request Token");
        
            $consumer->redirect();
        }
    }
}