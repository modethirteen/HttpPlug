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

use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class withoutQuery_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_add_query_parameter() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

         // act
        $result = XUri::tryParse($uriStr)->withQueryParam('foo', 'bar')->withoutQuery();

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_add_query_after_removing_it() {
        $xuri = XUri::tryParse('http://test.mindtouch.dev/?mt-f1=true');
        $result = $xuri->withoutQuery()->withQueryParam('mt-f1', 'true');
        $this->assertEquals('http://test.mindtouch.dev/?mt-f1=true', $result->toString());
    }

    /**
     * @test
     */
    public function Can_return_extended_instance() {

        // act
        $result = TestXUri::tryParse('http://user:password@test.mindtouch.dev:80/somepath?a=b&c=d&e=f#foo')->withoutQuery();

        // assert
        $this->assertInstanceOf(TestXUri::class, $result);
    }
}
