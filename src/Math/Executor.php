<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math;

    class Executor
    {
        public static function toString(Ast\Expr $parse): string
        {
            if ($parse instanceof Ast\TypeExpr) {
                return sprintf('%s(%s)', $parse->getTypeName(), $parse->getValue());
            }

            if ($parse instanceof Ast\GroupExpr) {
                return sprintf('%s(%s, %s)',
                    $parse->getSymbol(),
                    self::toString($parse->getLeft()),
                    self::toString($parse->getRight())
                );
            }

            return var_export($parse, true);
        }
    }
