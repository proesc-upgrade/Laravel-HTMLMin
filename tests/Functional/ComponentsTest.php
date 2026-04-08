<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\Tests\HTMLMin\Functional\Provider\TestComponentsProvider;

class ComponentsTest extends AbstractFunctionalTestCase
{
    /**
     * Get the required service providers.
     *
     * @return string[]
     */
    protected static function getRequiredServiceProviders(): array
    {
        return [TestComponentsProvider::class];
    }

    public function testUseComponents()
    {
        /** @var MinifyCompiler $minifyCompiler */
        $minifyCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $this->assertArrayHasKey('test-component', $minifyCompiler->getClassComponentAliases());
    }
}

