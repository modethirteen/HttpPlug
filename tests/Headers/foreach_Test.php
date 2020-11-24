<?php declare(strict_types=1);
/**
 * HttpPlug
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
use modethirteen\Http\Tests\HttpPlugTestCase;

class foreach_Test extends HttpPlugTestCase {

    /**
     * @test
     */
    public function Can_iterate_headers() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('X-Foo-BAZ', 'bar');
        $headers->addHeader('x-bar-qux', 'baz');
        $headers->addHeader('Content-length', '0');

        // act
        $results = [];
        foreach($headers as $name => $value) {
            $results[$name] = $value;
        }

        // assert
        $this->assertEquals(3, count($results));
        $this->assertArrayHasKeyValue('X-Foo-Baz', 'bar', $results);
        $this->assertArrayHasKeyValue('X-Bar-Qux', 'baz', $results);
        $this->assertArrayHasKeyValue('Content-Length', '0', $results);
    }
}
