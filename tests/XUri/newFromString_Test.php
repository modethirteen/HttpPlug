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

use modethirteen\Http\Exception\MalformedUriException;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class newFromString_Test extends PlugTestCase {

    /**
     * @test
     */
    public function XUri_roundtrip_test_1() : void {

        // arrange
        $uriStr = 'http://test.mindtouch.dev/';

        // act
        $result = XUri::newFromString($uriStr);

        // assert
        $this->assertEquals($uriStr, $result);
    }

    /**
     * @test
     */
    public function XUri_roundtrip_test_2() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::newFromString($uriStr);

        // assert
        $this->assertEquals($uriStr, $result);
    }

    /**
     * @test
     */
    public function XUri_roundtrip_test_3() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::newFromString($uriStr);

        // assert
        $this->assertEquals($uriStr, $result);
    }

    /**
     * @test
     */
    public function Invalid_uri_throws_exception() : void {
        $this->expectException(MalformedUriException::class);

        // arrange
        $uriStr = 'totally_invalid_string';

        // act
        XUri::newFromString($uriStr);
    }

    /**
     * @test
     */
    public function Valid_uri_must_have_scheme() : void {
        $this->expectException(MalformedUriException::class);

        // arrange
        $uriStr = 'test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        XUri::newFromString($uriStr);
    }

    /**
     * @test
     */
    public function Valid_uri_must_have_valid_port() : void {
        $this->expectException(MalformedUriException::class);

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev:12322342332423/?a=b&c=d#fragment';

        // act
        XUri::newFromString($uriStr);
    }

    /**
     * @test
     */
    public function Can_return_extended_instance() : void {

        // act
        $result = TestXUri::newFromString('http://user:password@test.mindtouch.dev/?a=b&c=d#fragment');

        // assert
        $this->assertInstanceOf(TestXUri::class, $result);
    }
}
