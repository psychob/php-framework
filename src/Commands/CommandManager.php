<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Commands;

    use PsychoB\Framework\Application\AppInterface;

    class CommandManager
    {
        /** @var AppInterface */
        protected $application;

        /**
         * CommandManager constructor.
         *
         * @param AppInterface $application
         */
        public function __construct(AppInterface $application)
        {
            $this->application = $application;
        }

        public function run(?array $args = null)
        {
            $this->loadCache();

            if ($args === null) {
                $args = $_SERVER['argv'];
            }

            return $this->runCommand($args);
        }

        private function loadCache()
        {
        }

        private function runCommand(array $args)
        {
        }

        protected function getCommandLine(): string
        {
            $ret = '';

            foreach ($_SERVER['argv'] as $item) {
                $ret .= sprintf('"%s" ', $item);
            }

            return $ret;
        }
    }
