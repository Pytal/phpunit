<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Event\Test;

use const PHP_EOL;
use PHPUnit\Event\AbstractEventTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PhpDeprecationTriggered::class)]
final class PhpDeprecationTriggeredTest extends AbstractEventTestCase
{
    public function testConstructorSetsValues(): void
    {
        $telemetryInfo = $this->telemetryInfo();
        $test          = $this->testValueObject();
        $message       = 'message';
        $file          = 'file';
        $line          = 1;

        $event = new PhpDeprecationTriggered(
            $telemetryInfo,
            $test,
            $message,
            $file,
            $line
        );

        $this->assertSame($telemetryInfo, $event->telemetryInfo());
        $this->assertSame($test, $event->test());
        $this->assertSame($message, $event->message());
        $this->assertSame($file, $event->file());
        $this->assertSame($line, $event->line());
        $this->assertSame('Test Triggered PHP Deprecation (PHPUnit\Event\AbstractEventTestCase::foo)' . PHP_EOL . 'message', $event->asString());
    }
}
