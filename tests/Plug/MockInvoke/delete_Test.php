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
namespace modethirteen\Http\Tests\HyperPlug\MockInvoke;

use modethirteen\Http\Headers;
use modethirteen\Http\Mock\MockPlug;
use modethirteen\Http\Plug;
use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class delete_Test extends PlugTestCase  {

    /**
     * @note httpbin credentials endpoint does not support delete method
     * @test
     */
    public function Can_invoke_put_with_credentials() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_DELETE, $uri)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_AUTHORIZATION, 'Basic cXV4OmJheg==']
                ])),
            (new Result())->withStatus(200)
        );
        $plug = (new Plug($uri))->withCredentials('qux', 'baz');

        // act
        $result = $plug->delete();

        // assert
        $this->assertAllMockPlugMocksCalled();
        $this->assertEquals(200, $result->getStatus());
    }
}
