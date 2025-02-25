<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework;

use function print_r;
use BadFunctionCallException;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\Small;

#[CoversClass(ExceptionWrapper::class)]
#[Small]
final class ExceptionWrapperTest extends TestCase
{
    #[RunInSeparateProcess]
    public function testGetOriginalException(): void
    {
        $e       = new BadFunctionCallException('custom class exception');
        $wrapper = new ExceptionWrapper($e);

        $this->assertInstanceOf(BadFunctionCallException::class, $wrapper->getOriginalException());
    }

    #[RunInSeparateProcess]
    public function testGetOriginalExceptionWithPrevious(): void
    {
        $e       = new BadFunctionCallException('custom class exception', 0, new Exception('previous'));
        $wrapper = new ExceptionWrapper($e);

        $this->assertInstanceOf(BadFunctionCallException::class, $wrapper->getOriginalException());
    }

    #[RunInSeparateProcess]
    public function testNoOriginalExceptionInStacktrace(): void
    {
        $e       = new BadFunctionCallException('custom class exception');
        $wrapper = new ExceptionWrapper($e);

        // Replace the only mention of "BadFunctionCallException" in wrapper
        $wrapper->setClassName('MyException');

        $data = print_r($wrapper, true);

        $this->assertStringNotContainsString(
            'BadFunctionCallException',
            $data,
            'Assert there is s no other BadFunctionCallException mention in stacktrace'
        );
    }
}
