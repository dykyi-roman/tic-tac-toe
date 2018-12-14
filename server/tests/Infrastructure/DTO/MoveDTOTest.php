<?php

namespace Dykyi\Test\Application;

use Dykyi\Domain\ValueObject\Move;
use Dykyi\Infrastructure\DTO\MoveDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class MoveDTOTest
 *
 * @coversDefaultClass \Dykyi\Infrastructure\DTO\MoveDTO
 *
 */
class MoveDTOTest extends TestCase
{
    /**
     * @covers ::jsonSerialize
     */
    public function testBuildResponseSuccess(): void
    {
        $dto = new MoveDTO(new Move(0, 0), 'X');

        $this->assertInstanceOf(\JsonSerializable::class, $dto);
        $this->assertCount(2, $dto->jsonSerialize());
        $this->assertArrayHasKey('result', $dto->jsonSerialize());
        $this->assertArraySubset([0, 0, 'X'], $dto->jsonSerialize()['result']);
        $this->assertArrayHasKey('error', $dto->jsonSerialize());
    }
}
