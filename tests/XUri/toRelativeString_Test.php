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

class toRelativeString_Test extends PlugTestCase {

    /**
     * @test
     */
    public function To_relative_string_perserves_path_query_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/somepath?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->toRelativeString();

        // assert
        $this->assertEquals('/somepath?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function To_relative_string_without_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/somepath?a=b&c=d';

        // act
        $result = XUri::tryParse($uriStr)->toRelativeString();

        // assert
        $this->assertEquals('/somepath?a=b&c=d', $result);
    }

    /**
     * @test
     */
    public function To_relative_string_without_query() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/somepath';

        // act
        $result = XUri::tryParse($uriStr)->toRelativeString();

        // assert
        $this->assertEquals('/somepath', $result);
    }

    /**
     * @test
     */
    public function To_relative_string_without_path() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev';

        // act
        $result = XUri::tryParse($uriStr)->toRelativeString();

        // assert
        $this->assertEquals('/', $result);
    }
}
