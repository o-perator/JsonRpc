<?php

declare(strict_types=1);

namespace UMA\JsonRpc\Tests\Fixture;

use UMA\JsonRpc;

class Subtractor implements JsonRpc\Procedure
{
    public function execute(JsonRpc\Request $request): JsonRpc\Response
    {
        $params = $request->params();

        if ($params instanceof \stdClass) {
            $minuend = $params->minuend;
            $subtrahend = $params->subtrahend;
        } else {
            [$minuend, $subtrahend] = $params;
        }

        return new JsonRpc\Success($request->id(), $minuend - $subtrahend);
    }

    public function getSpec(): ?\stdClass
    {
        return \json_decode(<<<'JSON'
{
  "$schema": "https://json-schema.org/draft-07/schema#",

  "type": ["array", "object"],
  "minItems": 2,
  "maxItems": 2,
  "items": { "type": "integer" },
  "required": ["minuend", "subtrahend"],
  "additionalProperties": false,
  "properties": {
    "minuend": { "type": "integer" },
    "subtrahend": { "type": "integer" }
  }
}
JSON
);
    }
}