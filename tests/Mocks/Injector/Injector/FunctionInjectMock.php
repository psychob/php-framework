<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mocks\Injector\Injector;

    class FunctionInjectMock
    {
        public static function staticFunctionWithoutArguments()
        {
            return 'staticFunctionWithoutArguments';
        }

        public function functionWithoutArguments()
        {
            $this->verifyContext();

            return 'functionWithoutArguments';
        }

        private function verifyContext()
        {
        }

        public function autoWiredMethod(AdvancedConstructorMock $adv, EmptyConstructorMock $empty)
        {
            $this->verifyContext();

            return 'autoWiredMethod';
        }

        public function partialAutoWire(AdvancedConstructorMock $adv,
                                        EmptyConstructorMock $empty,
                                        int $answer,
                                        EmptyConstructorMock $e2,
                                        string $greatest)
        {
            $this->verifyContext();

            return 'partialAutoWire';
        }

        public function withDefaultValues(AdvancedConstructorMock $adv,
                                          EmptyConstructorMock $empty,
                                          EmptyConstructorMock $e2,
                                          int $answer = 42,
                                          string $greatest = 'string')
        {
            $this->verifyContext();

            return 'withDefaultValues';
        }
    }
