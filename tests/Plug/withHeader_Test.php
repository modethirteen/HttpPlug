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
namespace modethirteen\Http\Tests\Plug;

use modethirteen\Http\Plug;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class withHeader_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_set_header_value() : void {

        // arrange
        $plug = new Plug(XUri::tryParse('http://foo.com'));

        // act
        $plug = $plug->withHeader('X-Foo-Bar', 'baz');

        // assert
        $this->assertEquals('baz', $plug->getHeaders()->getHeaderLine('X-Foo-Bar'));
    }

    /**
     * @test
     */
    public function Can_replace_header_value() : void {

        // arrange
        $plug = new Plug(XUri::tryParse('http://foo.com'));

        // act
        $plug = $plug->withHeader('X-Foo-Bar', 'baz')->withHeader('X-Foo-Bar', 'fred');

        // assert
        $this->assertEquals('fred', $plug->getHeaders()->getHeaderLine('X-Foo-Bar'));
    }
    
    /**
     * @test
     */
    public function Can_set_non_string_type_header() : void {

        // arrange
        $plug = new Plug(XUri::tryParse('http://foo.com'));

        // act
        $plug = $plug->withHeader('bar', true)
            ->withHeader('fred', false)
            ->withHeader('baz', 0)
            ->withHeader('qux', -10)
            ->withHeader('bazz', new class {
                public function __toString() : string {
                    return 'zzz';
                }
            })
            ->withHeader('fredd', ['qux', true, -10, 5])
            ->withHeader('barr', function() : string { return 'bazzzzz'; });

        // assert
        $this->assertEquals('true', $plug->getHeaders()->getHeaderLine('Bar'));
        $this->assertEquals('false', $plug->getHeaders()->getHeaderLine('Fred'));
        $this->assertEquals('0', $plug->getHeaders()->getHeaderLine('Baz'));
        $this->assertEquals('-10', $plug->getHeaders()->getHeaderLine('Qux'));
        $this->assertEquals('zzz', $plug->getHeaders()->getHeaderLine('Bazz'));
        $this->assertEquals('qux, true, -10, 5', $plug->getHeaders()->getHeaderLine('Fredd'));
        $this->assertEquals('bazzzzz', $plug->getHeaders()->getHeaderLine('Barr'));
    }
}
