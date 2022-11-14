<?php

namespace Rc\SmGenerator\Validation;


use Rc\SmGenerator\Validation\Attributes\Date;
use Rc\SmGenerator\Validation\Attributes\InRange;
use Rc\SmGenerator\Validation\Attributes\Url;

/**
 * DTO in fact. It serves as a transfer object, an instance of which is needed to validate the input array.
 * You may easily create your very own data object with yours validation attributes.
 */
class PageData
{

    public function __construct(
        #[Url]
        public string $loc,

        #[Date]
        public string $lastmod,

        #[InRange([
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never',
        ])]
        public string $changefreq,

        #[InRange([
            0.0,
            0.1,
            0.2,
            0.3,
            0.4,
            0.5,
            0.6,
            0.7,
            0.8,
            0.9,
            1.0,
        ])]
        public string $priority
    )
    {}
}


