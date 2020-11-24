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
namespace modethirteen\Http\Tests\Mock\MockPlug;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Content\TextContent;
use modethirteen\Http\Headers;
use modethirteen\Http\HttpPlug;
use modethirteen\Http\HttpResult;
use modethirteen\Http\Mock\MockPlug;
use modethirteen\Http\Tests\HttpPlugTestCase;
use modethirteen\Http\XUri;

class getCallCount_Test extends HttpPlugTestCase  {

    /**
     * @test
     */
    public function Can_get_call_count() {

        // arrange
        $uri1 = XUri::tryParse('test://example.com/@api/deki/pages/=foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(HttpPlug::METHOD_GET, $uri1)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    ['X-Foo', 'bar'],
                    ['X-Baz', 'qux']
                ])),
            (new HttpResult())->withStatus(200)
        );
        (new HttpPlug($uri1))->get();
        $uri2 = XUri::tryParse('test://example.com/@api/deki/pages/=bar/contents');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(HttpPlug::METHOD_POST, $uri2)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    ['X-Qux', 'foo'],
                    [Headers::HEADER_CONTENT_TYPE, ContentType::TEXT]
                ]))
                ->withBody('string'),
            (new HttpResult())->withStatus(200)
        );
        (new HttpPlug($uri2))->withHeader('X-Qux', 'foo')->post(new TextContent('string'));

        // act
        $count = MockPlug::getCallCount();

        // assert
        $this->assertEquals(2, $count);
    }
}
