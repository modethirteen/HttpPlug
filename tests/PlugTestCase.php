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
namespace modethirteen\Http\Tests;

use modethirteen\Http\Content\JsonContent;
use modethirteen\Http\Content\TextContent;
use modethirteen\Http\Content\XmlContent;
use modethirteen\Http\Headers;
use modethirteen\Http\Plug;
use modethirteen\Http\Mock\MockPlug;
use modethirteen\Http\Mock\MockRequestMatcher;
use modethirteen\Http\Parser\JsonParser;
use modethirteen\Http\StringUtil;
use modethirteen\Http\XUri;
use modethirteen\XArray\XArray;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PlugTestCase extends TestCase {

    #region Test data providers

    /**
     * @return array
     */
    public static function content_dataProvider() : array {
        return [
            'text' => [new TextContent('foo')],
            'json' => [JsonContent::newFromArray(['foo' => ['bar', 'baz']])],
            'xml' => [XmlContent::newFromArray(['foo' => ['bar' => ['@id' => 'qux']]])]
        ];
    }

    #endregion

    public function setUp() {
        parent::setUp();
        MockRequestMatcher::setIgnoredHeaderNames([
            Headers::HEADER_CONTENT_LENGTH
        ]);
    }

    public function tearDown() {
        parent::tearDown();
        MockRequestMatcher::setIgnoredHeaderNames([]);
        MockRequestMatcher::setIgnoredQueryParamNames([]);
        MockPlug::deregisterAll();
    }

    /**
     * @param string $class
     * @return MockObject
     */
    protected function newMock(string $class) : MockObject {
        return $this->getMockBuilder($class)
            ->setMethods(get_class_methods($class))
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @param string $method
     * @param XUri $uri
     * @return MockRequestMatcher
     */
    protected function newDefaultMockRequestMatcher(string $method, XUri $uri) : MockRequestMatcher {
        return new MockRequestMatcher($method, $uri);
    }

    /**
     * Return a new HyperPlug instance configured for httpbin.org
     *
     * @return Plug
     * @throws \modethirteen\Http\Exception\PlugUriHostRequiredException
     */
    protected function newHttpBinPlug() : Plug {
        $baseuri = getenv('HTTPBIN_BASEURI');
        if($baseuri === false || StringUtil::isNullOrEmpty($baseuri)) {
            $baseuri = 'https://httpbin.org';
        }
        $uri = XUri::tryParse($baseuri);
        return (new Plug($uri))->withResultParser(new JsonParser());
    }

    /**
     * Assert that all registered mock plug invocations were called
     */
    protected function assertAllMockPlugMocksCalled() {
        if(!MockPlug::verifyAll()) {
            $this->fail('Failed asserting that all MockPlug mocks were called');
        }
    }

    /**
     * Assert that an array contains a specified key with the specified value
     *
     * @param string $key
     * @param mixed $expected
     * @param array $array
     */
    protected function assertArrayHasKeyValue(string $key, $expected, array $array) {
        $X = new XArray($array);
        $isExpectingNumericArray = is_array($expected) && key_exists(0, $expected);
        $this->assertEquals($expected, $isExpectingNumericArray ? $X->getAll($key) : $X->getVal($key));
    }
}
