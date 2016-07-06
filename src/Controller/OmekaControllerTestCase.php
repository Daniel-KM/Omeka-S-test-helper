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


    public function persistAndSave($entity)
    {
      $em= $this->getApplicationServiceLocator()->get('Omeka\EntityManager');
      $em->persist($entity);
      $em->flush();
    }


    public function cleanTable($table_name) {
      $this->getApplicationServiceLocator()->get('Omeka\Connection')->exec('DELETE FROM '.$table_name);
    }

    public function setSettings($id,$value)
    {
      $settings = $this->getApplicationServiceLocator()->get('Omeka\Settings');
      $settings->set($id,$value);
    }


}
