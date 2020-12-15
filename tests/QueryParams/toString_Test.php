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
namespace modethirteen\Http\Tests\QueryParams;

use modethirteen\Http\QueryParams;
use modethirteen\Http\Tests\PlugTestCase;

class toString_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_build_query_string() {

        // arrange
        $params = new QueryParams();
        $params->set('foo', 'bar');
        $params->set('baz', 'qux');

        // act
        $result = $params->toString();

        // assert
        $this->assertEquals('foo=bar&baz=qux', $result);
    }
}
