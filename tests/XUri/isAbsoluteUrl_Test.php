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

class isAbsoluteUrl_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Is_absolute_url() : void {

        // act
        $result = XUri::isAbsoluteUrl('https://foo.example.com/baz');

        // assert
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function Is_not_absolute_url() : void {

        // act
        $result = XUri::isValidUrl('/baz');

        // assert
        $this->assertFalse($result);
    }
}
