<?php
/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace ApaiIO\Test\Request;

use ApaiIO\Request\RequestFactory;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCallback()
    {
        $request = $this->getMock('\ApaiIO\Request\RequestInterface');
        $callback = $this->getMock(__NAMESPACE__ . '\CallableClass', array('foo'));
        $callback->expects($this->once())
            ->method('foo')
            ->with($this->isInstanceOf('\ApaiIO\Request\RequestInterface'))
            ->will($this->returnValue($request));

        $configuration = $this->getMock(
            '\ApaiIO\Configuration\ConfigurationInterface',
            array(
                'getRequest',
                'getRequestFactory',
                'getCountry',
                'getAccessKey',
                'getSecretKey',
                'getAssociateTag',
                'getResponseTransformer',
                'getResponseTransformerFactory',
            )
        );
        $configuration->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        $configuration->expects($this->once())
            ->method('getRequestFactory')
            ->will($this->returnValue(array($callback, 'foo')));

        RequestFactory::createRequest($configuration);
    }
}

class CallableClass
{
    public function foo()
    {
    }
}
