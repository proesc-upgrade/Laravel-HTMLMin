<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\Tests\HTMLMin\Functional\Provider\TestDirectivesProvider;
use HTMLMin\Tests\HTMLMin\Mock\MinifyCompilerMock;

class DirectivesTest extends AbstractFunctionalTestCase
{
    /**
     * Get the required service providers.
     *
     * @return string[]
     */
    protected static function getRequiredServiceProviders(): array
    {
        return [TestDirectivesProvider::class];
    }

    public function testUseDirectives()
    {
        /** @var MinifyCompiler $minifyCompiler */
        $minifyCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $compilerMock = MinifyCompilerMock::newInstance();
        $this->assertArrayHasKey('test_directive', $compilerMock->getCompilerCustomDirectives($minifyCompiler));
    }
}
