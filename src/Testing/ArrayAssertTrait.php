<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing;

    use Iterator;
    use PHPUnit\Framework\Assert;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;
    use function Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\NonStaticInjectMock;

    trait ArrayAssertTrait
    {
        protected static function assertArrayIsEmpty($container, ?string $message = NULL)
        {
            if (is_array($container)) {
                Assert::assertEmpty($container, $message ?? '');
            } else if ($container instanceof Iterator) {
                Assert::assertEquals(0, iterator_count($container), 'Iterator should have no elements' . $message);
            } else {
                Assert::fail(sprintf('Unknown type (%s) passed as $container%s',
                    Str::toType($container), $message ? PHP_EOL . $message : ''));
            }
        }

        protected static function assertArrayElementsAre($expected,
            $current,
            callable $verify,
            ?string $message = NULL,
            string $assertMethod = 'assertArrayElementsAre'): void
        {
            $eIt = Arr::toIterator($expected);
            $cIt = Arr::toIterator($current);
            $eKey = $eLast = $cKey = $cLast = NULL;

            for ($eIt->rewind(), $cIt->rewind(); ; $eIt->next(), $cIt->next()) {
                // verify if we have current element in both arrays
                if ($eIt->valid() && $cIt->valid()) {
                    $eKey = $eIt->key();
                    $cKey = $cIt->key();

                    $eLast = $eIt->current();
                    $cLast = $cIt->current();

                    call_user_func($verify, $eLast, $cLast, $eKey, $cKey);
                } else if (!$eIt->valid() && !$cIt->valid()) {
                    // all ok
                    return;
                } else {
                    $msg = $assertMethod . ': ';

                    if ($eIt->valid()) {
                        $msg .= sprintf('Expected more values, currently expected: %s => %s',
                            Str::toRepr($eIt->key()), Str::toRepr($eIt->current()));
                    } else {
                        $msg .= sprintf('Encountered more values, currently encountered: %s => %s',
                            Str::toRepr($cIt->key()), Str::toRepr($cIt->current()));
                    }

                    if ($message !== NULL) {
                        $msg .= sprintf('%s%s', PHP_EOL, $message);
                    }

                    Assert::fail($msg);

                    return;
                }
            }
        }

        protected static function assertArrayElementsContainsValues($expected,
            $current,
            bool $strict = true,
            string $message = ''): void
        {
            foreach ($current as $item) {
                Assert::assertContains($item, $expected);
            }
        }
    }
