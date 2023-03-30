<?php

namespace Modules\Livestream\Services;

    class DefaultApiCorsProfile
    {
        public function allowCredentialsToString(): string
        {
            if (config('cors.default_profile.allow_credentials')) {
                return 'true';
            } else {
                return 'false';
            }
        }

        public function addCorsHeaders($response)
        {
            $response->headers->set('Access-Control-Allow-Origin', $this->allowedOriginsToString());
            $response->headers->set('Access-Control-Allow-Credentials', $this->allowCredentialsToString());
            $response->headers->set('Access-Control-Expose-Headers', $this->toString($this->exposeHeaders()));

            return $response;
        }

        public function addPreflightHeaders($response)
        {
            $response->headers->set('Access-Control-Allow-Methods', $this->toString($this->allowMethods()));
            $response->headers->set('Access-Control-Allow-Headers', $this->toString($this->allowHeaders()));
            $response->headers->set('Access-Control-Allow-Origin', $this->allowedOriginsToString());
            $response->headers->set('Access-Control-Allow-Credentials', $this->allowCredentialsToString());
            $response->headers->set('Access-Control-Max-Age', $this->maxAge());

            return $response;
        }
    }
