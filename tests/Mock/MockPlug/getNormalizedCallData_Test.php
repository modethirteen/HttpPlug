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
namespace modethirteen\Http\Tests\Mock\MockPlug;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Content\TextContent;
use modethirteen\Http\Headers;
use modethirteen\Http\Mock\MockPlug;
use modethirteen\Http\Plug;
use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class getNormalizedCallData_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_normalized_call_data() : void {

        // arrange
        $uri1 = XUri::tryParse('test://example.com/@api/deki/pages/=foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri1)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    ['X-Foo', 'bar'],
                    ['X-Baz', 'qux']
                ])),
            (new Result())->withStatus(200)
        );
        (new Plug($uri1))->get();
        $uri2 = XUri::tryParse('test://example.com/@api/deki/pages/=bar/contents');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_POST, $uri2)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    ['X-Qux', 'foo'],
                    [Headers::HEADER_CONTENT_TYPE, ContentType::TEXT]
                ]))
                ->withBody('string'),
            (new Result())->withStatus(200)
        );
        (new Plug($uri2))->withHeader('X-Qux', 'foo')->post(new TextContent('string'));
        $uri3 = XUri::tryParse('test://example.com/@api/deki/users/123');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri3),
            (new Result())->withStatus(403)
        );

        // act
        $result = MockPlug::getNormalizedCallData();

        // assert
        $expected = [
            '68d66c310269ada69b3c784a71ecffbb' => [
                'method' => 'GET',
                'uri' => 'test://example.com/@api/deki/pages/=foo',
                'headers' => [],
                'body' => '',
                'matched' => false
            ],
            '2853114dd6587a27b7dfd314b1a30a73' => [
                'method' => 'POST',
                'uri' => 'test://example.com/@api/deki/pages/=bar/contents',
                'headers' => [
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'X-Qux' => 'foo'
                ],
                'body' => 'string',
                'matched' => true
            ]
        ];
        $this->assertEquals($expected, $result);
    }
}
