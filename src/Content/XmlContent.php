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
namespace modethirteen\Http\Content;

use modethirteen\XArray\Serialization\XmlSerializer;
use modethirteen\XArray\XArray;

/**
 * Class XmlContent
 *
 * @package modethirteen\Http\Content
 */
class XmlContent implements IContent {

    /**
     * Return an instance from an XML encoded array
     *
     * @param array $xml
     * @return static
     */
    public static function newFromArray(array $xml) : object {
        return new static((new XArray($xml))->withSerializer(new XmlSerializer())->toString());
    }

    /**
     * @var ContentType|null
     */
    private ?ContentType $contentType;

    /**
     * @var string
     */
    private string $xml;

    /**
     * @param string $xml
     */
    final public function __construct(string $xml) {
        $this->contentType = ContentType::newFromString(ContentType::XML);
        $this->xml = $xml;
    }

    public function __clone() {

        // deep copy internal data objects and arrays
        $this->contentType = unserialize(serialize($this->contentType));
    }

    public function getContentType() : ?ContentType {
        return $this->contentType;
    }

    public function toRaw() : string {
        return $this->xml;
    }

    public function toString() : string {
        return $this->xml;
    }

    public function __toString() : string {
        return $this->toString();
    }
}
