<?php declare(strict_types=1);
/**
 * HttpPlug
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
namespace modethirteen\Http\Tests\HttpResult;

use modethirteen\Http\HttpResult;
use modethirteen\Http\Tests\HttpPlugTestCase;

class isRedirect_Test extends HttpPlugTestCase  {

    /**
     * @return array
     */
    public static function status_dataProvider() : array {
        return [
            [301],
            [302],
            [307]
        ];
    }

    /**
     * @dataProvider status_dataProvider
     * @param int $status
     * @test
     */
    public function HTTP_300_range_is_redirect(int $status) {

        // arrange
        $data = ['status' => $status];
        $result = new HttpResult($data);

        // act
        $isSuccess = $result->isRedirect();

        // assert
        $this->assertTrue($isSuccess);
    }
}
