<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    trait EnvTrait
    {
        protected function parseValue(string $value)
        {
            switch ($value) {
                case 'true':
                case '(true)':
                case 'TRUE':
                case '(TRUE)':
                    return true;

                case 'false':
                case '(false)':
                case 'FALSE':
                case '(FALSE)':
                    return false;

                case 'null':
                case '(null)':
                case 'NULL':
                case '(NULL)':
                    return NULL;
            }

            if (is_numeric($value)) {
                return intval($value);
            }

            return $value;
        }
    }
