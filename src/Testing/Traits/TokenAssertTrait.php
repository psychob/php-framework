<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing\Traits;

    use PHPUnit\Framework\Assert;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\TokenInterface;

    trait TokenAssertTrait
    {
        protected static function assertTokenType($expected, $current): void
        {
            Assert::assertInstanceOf(TokenInterface::class, $current, 'Token is not extension of TokenInterface');
            Assert::assertSame(get_class($expected), get_class($current), 'Token doesnt have proper class '.$current->getToken());
        }

        protected static function assertTokenTypeAndContent($expected, $current): void
        {
            static::assertTokenType($expected, $current);

            /**
             * @var TokenInterface $expected
             * @var TokenInterface $current
             */
            Assert::assertSame($expected->getToken(), $current->getToken(), 'Miss matching token content');
        }
    }
