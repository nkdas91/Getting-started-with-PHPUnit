<?php declare(strict_types=1);

include $_SERVER['DOCUMENT_ROOT'] . '/autoload.php';

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    private static $db;
    protected $user;

    /**
     * This function is invoked before the first test function.
     */
    public static function setUpBeforeClass(): void
    {
        /** Create database connection */
        self::$db = new mysqli(myEnv('DB_HOST'), myEnv('DB_USERNAME'), myEnv('DB_PASSWORD'), myEnv('DB_NAME'));
    }

    /**
     * This function is invoked after the last test function.
     */
    public static function tearDownAfterClass(): void
    {
        self::$db->close();
    }

    /**
     * This function is invoked before each test function.
     */
    protected function setUp(): void
    {
        /** Skip test if there was an error connecting to the database */
        if (self::$db->connect_error) {
            $this->markTestSkipped('Database connection failed!');
        }

        $this->user = new User(self::$db);
    }

    /**
     * This function is invoked after each test function.
     */
    protected function tearDown(): void
    {
        unset($this->user);
    }

    /**
     * Test for an Exception if invalid argument type is passed.
     */
    public function testExceptionFromInvalidArgumentType(): void
    {
        $this->expectException(TypeError::class);

        $this->user->getUserData(123);
    }

    public function testEmptyArrayFromUnavailableEmail(): void
    {
        $this->assertEmpty($this->user->getUserData('neeraj@example.com'));
    }

    public function testGetUserData(): void
    {
        $this->assertEquals(
            ['id' => '1', 'firstname' => 'Kim', 'lastname' => 'Gero', 'age' => '21'],
            $this->user->getUserData('kim@example.com')
        );
    }

    public function testIsEligibleToVote(): void
    {
        $this->assertEquals('Eligible To Vote', $this->user->isEligibleToVote('kim@example.com'));
        $this->assertEquals('Not Eligible To Vote', $this->user->isEligibleToVote('curtis@example.com'));
        $this->assertEquals('User Not Found', $this->user->isEligibleToVote('neeraj@example.com'));
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testIsEligibleToVoteUsingDataProvider(string $email, string $expected): void
    {
        $this->assertSame($expected, $this->user->isEligibleToVote($email));
    }

    public function userDataProvider(): array
    {
        return [
            ['kim@example.com', 'Eligible To Vote'],
            ['curtis@example.com', 'Not Eligible To Vote'],
            ['neeraj@example.com', 'User Not Found']
        ];
    }

    public function testIsEligibleToVoteUsingMockBuilder(): void
    {
        /** Here we used getMockBuilder to stub method: getUserData. */
        $mockObject = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUserData'])
            ->getMock();

        $mockPerson = [
            'id' => '100',
            'firstname' => 'Neeraj',
            'lastname' => 'Das',
            'age' => '25'
        ];

        /** getUserData will return the defined array. */
        $mockObject->method('getUserData')->willReturn($mockPerson);

        $this->assertEquals('Eligible To Vote', $mockObject->isEligibleToVote('any string'));
    }
}
