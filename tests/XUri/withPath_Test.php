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
namespace modethirteen\Http\Tests\XUri;

use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class withPath_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_replace_path() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar/baz?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->withPath('qux/fred');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/qux/fred?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_replace_path_with_preceding_slash() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar/baz?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->withPath('/qux/fred');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/qux/fred?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_replace_path_with_trailing_slash() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar/baz?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->withPath('qux/fred/');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/qux/fred?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_return_extended_instance() : void {

        // act
        $result = TestXUri::tryParse('http://user:password@test.mindtouch.dev:80/somepath?a=b&c=d&e=f#foo')->withPath('foo');

        // assert
        $this->assertInstanceOf(TestXUri::class, $result);
    }
}
