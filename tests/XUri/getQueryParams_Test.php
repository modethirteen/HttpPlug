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

use modethirteen\Http\IQueryParams;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class getQueryParams_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_params() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->getQueryParams();

        // assert
        $this->assertInstanceOf(IQueryParams::class, $result);
        $this->assertEquals(['a' => 'b', 'c' => 'd'], $result->toArray());
    }

    /**
     * @test
     */
    public function Can_get_empty_params() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar#fragment';

        // act
        $result = XUri::tryParse($uriStr)->getQueryParams();

        // assert
        $this->assertEquals([], $result->toArray());
    }

    /**
     * @test
     */
    public function Can_iterate_param_values_as_string() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar?a=b&123=d&c=#fragment';

        // act
        $params = XUri::tryParse($uriStr)->getQueryParams();

        // assert
        foreach($params as $param => $value) {
            $this->assertIsString($param);
        }
    }
}
