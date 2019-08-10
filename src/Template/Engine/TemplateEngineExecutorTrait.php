<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateFilterRepository;
    use PsychoB\Framework\Template\TemplateState;

    trait TemplateEngineExecutorTrait
    {
        /**
         * @param BlockInterface[]         $blocks
         * @param mixed[]                  $variables
         * @param TemplateFilterRepository $repo
         *
         * @return string
         */
        private function executeBlocks(array $blocks, array $variables, TemplateFilterRepository $repo): string
        {
            $state = new TemplateState($variables, $repo);

            $ret = '';

            foreach ($blocks as $block) {
                $ret .= $block->execute($state);
            }

            return $ret;
        }
    }
