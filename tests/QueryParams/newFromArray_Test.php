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

class newFromArray_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_construct_from_array() {

        // act
        $params = QueryParams::newFromArray([
            'foo' => '!@%$',
            'sherlock' => 'holmes',
            'baz' => true,
            'qux' => false,
            'a' => 0,
            'b' => -10,
            'c' => new class {
                public function __toString() : string {
                    return 'fred';
                }
            },
            'd' => ['qux', true, -10, 5],
            'e' => function() { return 'bazz'; }
        ]);

        // assert
        $this->assertEquals('foo=%21%40%25%24&sherlock=holmes&baz=true&qux=false&a=0&b=-10&c=fred&d=qux%2C1%2C-10%2C5&e=bazz', $params->toString());
    }
}
