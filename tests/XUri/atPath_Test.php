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

class atPath_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_add_path() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('foo/bar');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_add_query() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('foo/bar?z=x&y=z');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d&z=x&y=z#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_add_query_if_no_existing_query() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('foo/bar?z=x&y=z');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?z=x&y=z#fragment', $result);
    }

    /**
     * @test
     */
    public function Can_replace_fragment() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('foo/bar?z=x&y=z#mouse');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d&z=x&y=z#mouse', $result);
    }

    /**
     * @test
     */
    public function Can_add_path_with_prepended_slash() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('/foo/bar?z=x&y=z#mouse');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d&z=x&y=z#mouse', $result);
    }

    /**
     * @test
     */
    public function Can_add_path_with_appended_slash() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('foo/bar/?z=x&y=z#mouse');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d&z=x&y=z#mouse', $result);
    }

    /**
     * @test
     */
    public function Can_add_path_with_colon() : void {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->atPath('Special:foo/bar');

        // assert
        $this->assertEquals('http://user:password@test.mindtouch.dev/Special:foo/bar?a=b&c=d#fragment', $result);
    }
}
