<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokens;

    class DebugInfo
    {
        /** @var int */
        protected $start;

        /** @var int */
        protected $end;

        /** @var int */
        protected $line;

        /**
         * DebugInfo constructor.
         *
         * @param int $start
         * @param int $end
         * @param int $line
         */
        public function __construct(int $start, int $end, int $line)
        {
            $this->start = $start;
            $this->end = $end;
            $this->line = $line;
        }

    }
