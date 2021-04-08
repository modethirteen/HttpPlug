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
namespace modethirteen\Http\Exception;

use Exception;

/**
 * Class MalformedPathQueryFragmentException
 *
 * @package modethirteen\Http\Exception
 */
class MalformedPathQueryFragmentException extends Exception {

    /**
     * @var string
     */
    private $string;

    /**
     * @param string $string - malformed URI path/query/fragment string
     */
    public function __construct(string $string) {
        $this->string = $string;
        parent::__construct('String is not a valid URI path/query/fragment: ' . $string);
    }

    /**
     * @return string
     */
    public function getMalformedPathQueryFragmentString() : string {
        return $this->string;
    }
}
