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

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Content\JsonContent;
use modethirteen\Http\Content\TextContent;
use modethirteen\Http\Content\XmlContent;
use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;

class withContent_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_instance_with_text_content() : void {

        // arrange
        $data = [
            'type' => ContentType::JSON,
            'body' => '{"foo":"bar"]'
        ];
        $result = new Result($data);

        // act
        $result = $result->withContent(new TextContent('qux'));

        // assert
        $this->assertEquals([
            'type' => ContentType::TEXT,
            'body' => 'qux'
        ], $result->toArray());
    }

    /**
     * @test
     */
    public function Can_get_instance_with_json_content() : void {

        // arrange
        $data = [
            'type' => ContentType::XML,
            'body' => '<groups></groups>'
        ];
        $result = new Result($data);

        // act
        $result = $result->withContent(JsonContent::newFromArray([
            'foo' => [
                'bar',
                'baz'
            ]
        ]));

        // assert
        $this->assertEquals([
            'type' => ContentType::JSON,
            'body' => '{"foo":["bar","baz"]}'
        ], $result->toArray());
    }

    /**
     * @test
     */
    public function Can_get_instance_with_xml_content() : void {

        // arrange
        $data = [
            'type' => ContentType::JSON,
            'body' => '{"foo":"bar"]'
        ];
        $result = new Result($data);

        // act
        $result = $result->withContent(XmlContent::newFromArray([
            'users' => [
                'user' => [
                    [
                        '@id' => 123
                    ],
                    [
                        '@id' => 321
                    ]
                ]
            ]
        ]));

        // assert
        $this->assertEquals([
            'type' => ContentType::XML,
            'body' => '<users><user id="123"></user><user id="321"></user></users>'
        ], $result->toArray());
    }
}
