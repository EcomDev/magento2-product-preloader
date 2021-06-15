<?php

namespace EcomDev\ProductDataPreLoader;

use Magento\Framework\ObjectManagerInterface;

/**
 * Simplistic implementation of Object Manager for testing
 */
class FakeObjectManager implements ObjectManagerInterface
{
    /**
     * Configuration of classes used for interfaces
     *
     * @var array
     */
    private $configuration = [];

    /* @inheritDoc */
    public function create($type, array $arguments = [])
    {
        $reflectionClass = new \ReflectionClass($type);
        $constructorArguments = [];

        foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
            if (isset($arguments[$parameter->getName()])) {
                $constructorArguments[] = $arguments[$parameter->getName()];
            } elseif (!$parameter->isOptional() && $parameter->getType() instanceof \ReflectionNamedType) {
                $constructorArguments[] = $this->get($parameter->getType()->getName());
            } elseif (!$parameter->isOptional()) {
                throw new \RuntimeException(
                    sprintf(
                        'Cannot resolve constructor argument %s property for instantiating %s',
                        $parameter->getName(),
                        $type
                    )
                );
            }
        }

        return $reflectionClass->newInstanceArgs($constructorArguments);
    }

    /* @inheritDoc */
    public function get($type)
    {
        $type = $this->configuration['preferences'][$type] ?? $type;
        return (new \ReflectionClass($type))->newInstanceWithoutConstructor();
    }

    /* @inheritDoc */
    public function configure(array $configuration)
    {
        $this->configuration = $configuration;
    }
}
