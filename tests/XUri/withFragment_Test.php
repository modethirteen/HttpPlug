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

class withFragment_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_set_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d';

        // act
        $result = XUri::tryParse($uriStr)->withFragment('foo');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/?a=b&c=d#foo', $result);
    }

    /**
     * @test
     */
    public function Can_change_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#foo';

        // act
        $result = XUri::tryParse($uriStr)->withFragment('bar');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/?a=b&c=d#bar', $result);
    }

     /**
     * @test
     */
    public function Can_remove_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d';

        // act
        $result = XUri::tryParse($uriStr)->withFragment(null);

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/?a=b&c=d', $result);
    }

    /**
     * @test
     */
    public function Can_return_extended_instance() : void {

        // act
        $result = TestXUri::tryParse('http://user:password@test.mindtouch.dev/somepath?a=b&c=d&e=f')->withFragment('foo');

        // assert
        $this->assertInstanceOf(TestXUri::class, $result);
    }
}
