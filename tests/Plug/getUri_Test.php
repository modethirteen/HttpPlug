<?php declare(strict_types=1);
/**
 * HyperPlug
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace modethirteen\Http\Tests\Plug;

use modethirteen\Http\Plug;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class getUri_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_uri_with_credentials() : void {

        // arrange
        $plug = (new Plug(XUri::tryParse('http://foo.com/bar/baz?a=b&c=d')))
            ->withCredentials('aaa', 'bbb');

        // act
        $result = $plug->getUri(true);

        // assert
        $this->assertEquals('http://aaa:bbb@foo.com/bar/baz?a=b&c=d', $result->toString());
    }

    /**
     * @test
     */
    public function Can_get_uri_with_username_credential() : void {

        // arrange
        $plug = (new Plug(XUri::tryParse('http://foo.com/bar/baz?a=b&c=d')))
            ->withCredentials('aaa', null);

        // act
        $result = $plug->getUri(true);

        // assert
        $this->assertEquals('http://aaa:@foo.com/bar/baz?a=b&c=d', $result->toString());
    }

    /**
     * @test
     */
    public function Can_get_uri_without_credentials() : void {

        // arrange
        $plug = (new Plug(XUri::tryParse('http://foo.com/bar/baz?a=b&c=d')))
            ->withCredentials('aaa', 'bbb');

        // act
        $result = $plug->getUri();

        // assert
        $this->assertEquals('http://foo.com/bar/baz?a=b&c=d', $result);
    }
}
