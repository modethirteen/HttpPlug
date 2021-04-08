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
namespace modethirteen\Http\Tests\Plug\CurlInvoke;

use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;

class withPostInvokeCallback_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_execute_callback_and_mutate_result_after_invocation() : void {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug
            ->withPostInvokeCallback(function(Result $result) {
                $result->setVal('headers/X-Callback-Header', ['foo']);
            })
            ->get();

        // assert
        $this->assertAllMockPlugMocksCalled();
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals('foo', $result->getHeaders()->getHeaderLine('X-Callback-Header'));
    }

    /**
     * @test
     */
    public function Can_execute_callback_after_request_info_has_been_added_and_parsers_have_run() : void {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');
        $request = null;
        $body = null;

        // act
        $result = $plug
            ->withPostInvokeCallback(function(Result $result) use (&$request, &$body) {
                $request = $result->getVal('request');
                $body = $result->getVal('body');
            })
            ->get();

        // assert
        $this->assertAllMockPlugMocksCalled();
        $this->assertEquals(200, $result->getStatus());
        $this->assertTrue(is_array($request));
        $this->assertTrue(is_array($body));
    }
}
