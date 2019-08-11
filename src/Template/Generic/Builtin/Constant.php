<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Builtin;

    class Constant
    {
        protected $txt;

        /**
         * Constant constructor.
         *
         * @param $txt
         */
        public function __construct($txt)
        {
            $this->txt = $txt;
        }

        public function getConstant()
        {
            return $this->txt;
        }
    }
