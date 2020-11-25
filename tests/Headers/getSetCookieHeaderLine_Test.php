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
namespace modethirteen\Http\Tests\Headers;

use modethirteen\Http\Headers;
use modethirteen\Http\Tests\PlugTestCase;

class getSetCookieHeaderLine_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_header_lines_by_cookie_names() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('Set-Cookie', 'dekisession=foo');
        $headers->addHeader('Set-Cookie', 'mtwebsession=baz');

        // act
        $result1 = $headers->getSetCookieHeaderLine('dekisession');
        $result2 = $headers->getSetCookieHeaderLine('dekiSESSION');
        $result3 = $headers->getSetCookieHeaderLine('authtoken');
        $result4 = $headers->getSetCookieHeaderLine('mtwebsession');

        // assert
        $this->assertEquals('dekisession=foo', $result1);
        $this->assertNull($result2);
        $this->assertNull($result3);
        $this->assertEquals('mtwebsession=baz', $result4);
    }

    /**
     * @test
     */
    public function Will_get_null_if_no_set_cookie_headers_set() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('foo', 'bar');
        $headers->addHeader('qux', 'baz');

        // act
        $result = $headers->getSetCookieHeaderLine('foo');

        // assert
        $this->assertNull($result);
    }
}
