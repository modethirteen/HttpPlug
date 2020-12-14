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

class at_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_add_path_segments() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';
        $object = new class {
            public function __toString() : string {
                return 'xyz';
            }
        };
        $func = function() {
            return 'asdf';
        };

        // act
        $result = XUri::tryParse($uriStr)->at('foo', 'bar', 'baz', true, 123, $object, $func);

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar/baz/true/123/xyz/asdf?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_add_path_string() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

         // act
        $result = XUri::tryParse($uriStr)->at('foo/bar/baz');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar/baz?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_preserve_slashes() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev';

        // act
        $result = XUri::tryParse($uriStr)->atPath('a/b/c')->at('foo', 'bar', 'baz');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/a/b/c/foo/bar/baz', $result);
    }

    /**
     * @test
     */
    public function Will_do_nothing_if_empty_path_segments() {

            // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/a/b/c';

        // act
        $result = XUri::tryParse($uriStr)->at();

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/a/b/c', $result);
    }
}
