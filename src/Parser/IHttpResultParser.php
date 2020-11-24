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
namespace modethirteen\Http\Parser;

use modethirteen\Http\Exception\HttpResultParserContentExceedsMaxContentLengthException;
use modethirteen\Http\HttpResult;

/**
 * Interface IHttpResultParser
 *
 * @package modethirteen\Http\Parser
 */
interface IHttpResultParser {

    /**
     * Return an instance with a max content length
     *
     * @param int $length
     * @return IHttpResultParser
     */
    function withMaxContentLength(int $length) : IHttpResultParser;

    /**
     * Return an instance with the content body parsed into an array
     *
     * @param HttpResult $result
     * @return HttpResult
     * @throws HttpResultParserContentExceedsMaxContentLengthException
     */
    function toParsedResult(HttpResult $result) : HttpResult;
}
