<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    use PsychoB\Framework\Router\Http\Headers\GenericHeader;
    use PsychoB\Framework\Router\Http\Headers\HostHeader;
    use PsychoB\Framework\Router\Http\Headers\UserAgentHeader;

    return [
        'header-parsers' => [
            '*'          => GenericHeader::class,
            'Host'       => HostHeader::class,
            'User-Agent' => UserAgentHeader::class,
        ],
    ];
