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
namespace modethirteen\Http\Tests\Content\SerializedPhpArrayContent;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Content\SerializedPhpArrayContent;
use modethirteen\Http\Tests\PlugTestCase;

class newFromArray_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_return_valid_instance() {

        // assert
        $array = ['foo' => ['bar' => ['bar', 'qux']]];

        // act
        $content = SerializedPhpArrayContent::newFromArray($array);

        // assert
        $this->assertInstanceOf(SerializedPhpArrayContent::class, $content);
        $this->assertEquals('a:1:{s:3:"foo";a:1:{s:3:"bar";a:2:{i:0;s:3:"bar";i:1;s:3:"qux";}}}', $content->toString());
        $this->assertEquals('a:1:{s:3:"foo";a:1:{s:3:"bar";a:2:{i:0;s:3:"bar";i:1;s:3:"qux";}}}', $content->toRaw());
        $this->assertEquals(ContentType::PHP, $content->getContentType());
    }
}
