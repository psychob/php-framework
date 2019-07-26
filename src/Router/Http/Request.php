<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http;

    class Request
    {
        public const METHOD_GET     = 'GET';
        public const METHOD_POST    = 'POST';
        public const METHOD_PUT     = 'PUT';
        public const METHOD_DELETE  = 'DELETE';
        public const METHOD_OPTIONS = 'OPTIONS';

        /** @var string */
        protected $method;

        /** @var string */
        protected $url;

        /** @var ParameterContainer */
        protected $headers;

        /** @var ParameterContainer */
        protected $get;

        /** @var ParameterContainer */
        protected $post;

        /**
         * Request constructor.
         *
         * @param string             $method
         * @param string             $url
         * @param ParameterContainer $headers
         * @param ParameterContainer $get
         * @param ParameterContainer $post
         */
        public function __construct(string $method,
                                    string $url,
                                    ParameterContainer $headers,
                                    ParameterContainer $get,
                                    ParameterContainer $post)
        {
            $this->method = $method;
            $this->url = $url;
            $this->headers = $headers;
            $this->get = $get;
            $this->post = $post;
        }
    }
