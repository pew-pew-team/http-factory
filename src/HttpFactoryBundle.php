<?php

declare(strict_types=1);

namespace PewPew\HttpFactory;

use MessagePack\MessagePack;
use PewPew\HttpFactory\Driver\JsonDriver;
use PewPew\HttpFactory\Driver\MessagePackDriver;
use PewPew\HttpFactory\Driver\YamlDriver;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Yaml\Yaml;

final class HttpFactoryBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->registerBuiltinDrivers($container);
        $this->registerFactories($container);
    }

    private function registerBuiltinDrivers(ContainerBuilder $container): void
    {
        if (\class_exists(MessagePack::class)) {
            $container->register(MessagePackDriver::class)
                ->addTag('pew-pew.request.decoder')
                ->addTag('pew-pew.request.encoder');
        }

        if (\class_exists(Yaml::class)) {
            $container->register(YamlDriver::class)
                ->addTag('pew-pew.request.decoder')
                ->addTag('pew-pew.request.encoder');
        }

        $container->register(JsonDriver::class)
            ->setArgument('$debug', '%kernel.debug%')
            ->addTag('pew-pew.request.decoder')
            ->addTag('pew-pew.request.encoder');
    }

    private function registerFactories(ContainerBuilder $container): void
    {
        $container->register(RequestDecoderFactoryInterface::class, RequestDecoderFactory::class)
            ->setArgument('$decoders', new TaggedIterator('pew-pew.request.decoder'));

        $container->register(ResponseEncoderFactoryInterface::class, ResponseEncoderFactory::class)
            ->setArgument('$encoders', new TaggedIterator('pew-pew.request.encoder'));
    }
}
