<?php

namespace OmekaTestHelper\Controller;

use Omeka\Test\AbstractHttpControllerTestCase;
use Zend\Http\Request as HttpRequest;
abstract class OmekaControllerTestCase extends AbstractHttpControllerTestCase
{
    public function postDispatch($url, $data)
    {
        return $this->dispatch($url, HttpRequest::METHOD_POST, $data);
    }

    protected function resetApplication()
    {
        $this->application = null;
    }

    protected function getServiceLocator()
    {
        return $this->getApplication()->getServiceManager();
    }

    protected function api()
    {
        return $this->getServiceLocator()->get('Omeka\ApiManager');
    }

    protected function login($email, $password)
    {
        $serviceLocator = $this->getServiceLocator();
        $auth = $serviceLocator->get('Omeka\AuthenticationService');
        $adapter = $auth->getAdapter();
        $adapter->setIdentity($email);
        $adapter->setCredential($password);
        return $auth->authenticate();
    }

    protected function loginAsAdmin()
    {
        $this->login('admin@example.com', 'root');
    }
}
