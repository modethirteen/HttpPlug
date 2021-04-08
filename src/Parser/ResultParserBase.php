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
namespace modethirteen\Http\Parser;

use modethirteen\Http\Exception\ResultParserContentExceedsMaxContentLengthException;
use modethirteen\Http\Headers;
use modethirteen\Http\Result;

/**
 * Class ResultParserBase
 *
 * @package modethirteen\Http\Parser
 */
abstract class ResultParserBase {

    /**
     * @var int|null
     */
    protected $maxContentLength = null;

    /**
     * @param Result $result
     * @return void
     *@throws ResultParserContentExceedsMaxContentLengthException
     */
    protected function validateContentLength(Result $result) : void {
        if(!is_int($this->maxContentLength)) {
            return;
        }
        $resultContentLength = intval($result->getHeaders()->getHeaderLine(Headers::HEADER_CONTENT_LENGTH));
        if($resultContentLength > $this->maxContentLength) {
            throw new ResultParserContentExceedsMaxContentLengthException($result, $resultContentLength, $this->maxContentLength);
        }
    }
}
