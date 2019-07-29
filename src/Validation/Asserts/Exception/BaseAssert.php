<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use Throwable;

    class BaseAssert extends BaseException
    {
        protected $assertName;

        public function __construct(string $assertName, $message, Throwable $previous = NULL)
        {
            $this->assertName = $assertName;

            parent::__construct($message, 0, $previous);
        }

        /**
         * @return string
         */
        public function getAssertName(): string
        {
            return $this->assertName;
        }
    }
