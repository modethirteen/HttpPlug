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

class withoutPort_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_remove_port() : void {

        // arrange
        $uriStr = 'https://user:password@test.mindtouch.dev:80/?a=b&e=f#fragment';

        // act
        $result = XUri::tryParse($uriStr)->withoutPort();

        // assert
        $this->assertEquals('https://user:password@test.mindtouch.dev/?a=b&e=f#fragment', $result);
    }

    /**
     * @test
     */
    public function No_port_is_noop() : void {

        // arrange
        $uriStr = 'https://user:password@test.mindtouch.dev/?a=b&e=f#fragment';

        // act
        $result = XUri::tryParse($uriStr)->withoutPort();

        // assert
        $this->assertEquals('https://user:password@test.mindtouch.dev/?a=b&e=f#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_return_extended_instance() : void {

        // act
        $result = TestXUri::tryParse('http://user:password@test.mindtouch.dev:80/somepath?a=b&c=d&e=f#foo')->withoutPort();

        // assert
        $this->assertInstanceOf(TestXUri::class, $result);
    }
}
