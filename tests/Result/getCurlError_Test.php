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

class getCurlError_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_curl_error() {

        // arrange
        $data = [
            'status' => 404,
            'errno' => 47,
            'error' => 'foo'
        ];
        $result = new Result($data);

        // act
        $error = $result->getCurlError();

        // assert
        $this->assertEquals('foo', $error);
    }

    /**
     * @test
     */
    public function Will_get_null_if_no_curl_error() {

        // arrange
        $data = [
            'status' => 404,
            'errno' => 0
        ];
        $result = new Result($data);

        // act
        $error = $result->getCurlError();

        // assert
        $this->assertNull($error);
    }
}
