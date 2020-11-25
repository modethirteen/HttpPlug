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

class isRequestError_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function HTTP_500_range_is_not_server_error() {

        // arrange
        $data = ['status' => 500];
        $result = new Result($data);

        // act
        $isRequestError = $result->isRequestError();

        // assert
        $this->assertFalse($isRequestError);
    }

    /**
     * @return array
     */
    public static function status_dataProvider() : array {
        return [
            [400],
            [401],
            [403],
            [404]
        ];
    }

    /**
     * @dataProvider status_dataProvider
     * @param int $status
     * @test
     */
    public function HTTP_400_range_is_request_error(int $status) {

        // arrange
        $data = ['status' => $status];
        $result = new Result($data);

        // act
        $isRequestError = $result->isRequestError();

        // assert
        $this->assertTrue($isRequestError);
    }
}
