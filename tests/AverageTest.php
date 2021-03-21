<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class AverageTest extends TestCase
{
    protected $average;

    /**
     * This function is invoked before each test function.
     */
    protected function setUp(): void
    {
        $this->average = new Average();
    }

    /**
     * This function is invoked after each test function.
     */
    protected function tearDown(): void
    {
        unset($this->average);
    }

    /**
     * Test for an Exception if invalid argument type is passed.
     */
    public function testExceptionFromInvalidArgumentType(): void
    {
        $this->expectException(TypeError::class);

        $this->average->getAverage('string');
    }

    /**
     * Test for an Exception if invalid argument is passed.
     */
    public function testExceptionFromInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->average->getAverage([1, 'a', 3, 4, 5]);
    }

    /**
     * Test for an Error if an empty array is passed.
     */
    public function testErrorFromEmptyArrayArgument(): void
    {
        $this->expectError();

        $this->average->getAverage([]);
    }

    public function testGetAverage(): void
    {
        $this->assertEquals(3.0, $this->average->getAverage([1, 2, 3, 4, 5]));
    }

    /**
     * @dataProvider averageProvider
     */
    public function testGetAverageUsingDataProvider(int $a, int $b, float $expected): void
    {
        $this->assertEquals($expected, $this->average->getAverage([$a, $b]));
    }

    public function averageProvider(): array
    {
        return [
            [1, 2, 1.5],
            [3, 4, 3.5],
            [4, 2, 3.0],
            [4, 4, 4.0]
        ];
    }

    public function testEnsureIsValidArrayOfIntegers(): void
    {
        $this->assertEmpty($this->average->ensureIsValidArrayOfIntegers([1, 2, 3, 4, 5]));
    }

    public function testExceptionFromInvalidArrayOfIntegers(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->average->ensureIsValidArrayOfIntegers([1, 3.5, 3]);
    }

    public function testStub(): void
    {
        /**
         * createStub stubs all the methods in the stubbed class.
         * Here, ensureIsValidArrayOfIntegers and getAverage methods won't be invoked from the
         * Original Average class.
         */
        $stub = $this->createStub(Average::class);

        /**
         * Since we didn't specify the return values,
         * default values will be returned based on the functions return type.
         *
         * Return type of ensureIsValidArrayOfIntegers is void. So, nothing is returned.
         * Return type of getAverage is float. So, 0.0 is returned
         */
        $this->assertEmpty($stub->ensureIsValidArrayOfIntegers([1, 3.5, 3]));
        $this->assertEquals(0.0, round($stub->getAverage([1, 3.5, 3]), 2));
    }

    public function testStubUsingMockBuilder(): void
    {
        /**
         * Here we used getMockBuilder to stub just one method: ensureIsValidArrayOfIntegers.
         * This method won't be invoked.
         */
        $stub = $this->getMockBuilder(Average::class)
            ->setMethods(['ensureIsValidArrayOfIntegers'])
            ->getMock();

        $this->assertEmpty($stub->ensureIsValidArrayOfIntegers([1, 3.5, 3]));

        /**
         * Since, ensureIsValidArrayOfIntegers method is stubbed,
         * we are able to get an average even if we don't pass a valid array of Integers.
         *
         * getAverage method of the original Average class is invoked.
         */
        $this->assertEquals(2.5, round($stub->getAverage([1, 3.5, 3]), 2));
    }

    public function testMock(): void
    {
        /**
         * Here, we are mocking log method of Logger class,
         * just to ensure that it is called with the specified arguments.
         * The Average class does not need to verify what happens within the Logger log method.
         */
        $mockObject = $this->createMock(Logger::class);
        $mockObject->expects($this->once())
            ->method('log')
            ->with(2.0);

        $this->average->logAverage([1, 2, 3], $mockObject);
    }
}
