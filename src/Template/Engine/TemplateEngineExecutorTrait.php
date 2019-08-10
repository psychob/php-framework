<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    trait TemplateEngineExecutorTrait
    {
        /**
         * @param BlockInterface[] $blocks
         * @param mixed[]          $variables
         *
         * @return string
         */
        private function executeBlocks(array $blocks, array $variables = []): string
        {
            $state = new TemplateState($variables);

            $ret = '';

            foreach ($blocks as $block) {
                $ret .= $block->execute($state);
            }

            return $ret;
        }
    }
