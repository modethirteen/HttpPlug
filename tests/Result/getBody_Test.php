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
namespace modethirteen\Http\Tests\Result;

use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;

class getBody_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_array_body_as_array() {

        // arrange
        $data = [
            'status' => 200,
            'body' => [
                'foo' => [
                    '@id' => '123',
                    '@baz' => 'qux',
                    'baz' => [
                        '#text' => 'fred',
                        '@foo' => 'abc'
                    ]
                ]
            ]
        ];
        $result = new Result($data);

        // act
        $result = $result->getBody();

        // assert
        $this->assertEquals($data['body'], $result->toArray());
    }

    /**
     * @test
     */
    public function Can_get_string_body_as_array() {

        // arrange
        $data = [
            'status' => 200,
            'body' => 'foo'
        ];
        $result = new Result($data);

        // act
        $result = $result->getBody();

        // assert
        $this->assertEquals(['body' => 'foo'], $result->toArray());
    }
}
