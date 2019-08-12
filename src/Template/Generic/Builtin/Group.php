<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Builtin;

    class Group
    {
        protected $group;

        /**
         * Group constructor.
         *
         * @param $group
         */
        public function __construct($group)
        {
            $this->group = $group;
        }

        /**
         * @return mixed
         */
        public function getGroup()
        {
            return $this->group;
        }

    }
