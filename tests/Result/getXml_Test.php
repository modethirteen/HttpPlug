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

class getXml_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_value_as_xml() : void {

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
        $xml = $result->getXml('body/foo');

        // assert
        $this->assertEquals('<baz foo="abc">fred</baz>', $xml);
    }

    /**
     * @test
     */
    public function Can_get_result_as_xml() : void {

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
        $xml = $result->getXml();

        // assert
        $this->assertEquals('<result><status>200</status><body><foo id="123" baz="qux"><baz foo="abc">fred</baz></foo></body></result>', $xml);
    }
}
