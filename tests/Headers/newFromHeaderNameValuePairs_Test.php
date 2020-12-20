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

use InvalidArgumentException;
use modethirteen\Http\Headers;
use modethirteen\Http\Tests\PlugTestCase;

class newFromHeaderNameValuePairs_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_return_headers_from_pairs() : void {

        // act
        $headers = Headers::newFromHeaderNameValuePairs([
            ['x-foo', 'bar'],
            ['x-FOO', 'baz'],
            ['x-qux-quxx', 'fred']
        ]);

        // assert
        $this->assertEquals([
            'X-Foo' => ['bar', 'baz'],
            'X-Qux-Quxx' => ['fred']
        ], $headers->toArray());
    }

    /**
     * @test
     */
    public function Cannot_return_headers_from_pairs_if_invalid_structure() : void {

        // act
        $exceptionThrown = false;
        try {
            Headers::newFromHeaderNameValuePairs([
                ['x-foo', 'bar'],
                ['baz' => 'foo'],
                ['x-qux-quxx', 'fred']
            ]);
        } catch(InvalidArgumentException $e) {
            $exceptionThrown = true;
        }

        // assert
        $this->assertTrue($exceptionThrown);
    }
}
