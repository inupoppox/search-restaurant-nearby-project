<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Psr\Container\ContainerInterface;

class FindCandidateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : FindCandidateHandler
    {
        return new FindCandidateHandler(
            $container->get('config')['key_api']
        );
    }
}
