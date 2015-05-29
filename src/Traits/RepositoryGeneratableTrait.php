<?php namespace SKAgarwal\Generators\Traits;

use Illuminate\Console\AppNamespaceDetectorTrait;

trait RepositoryGeneratableTrait {

    use AppNamespaceDetectorTrait;

    /**
     * Contract/Interface Name
     *
     * @var string
     */
    protected $contractName;

    /**
     * Repository Class Name
     *
     * @var string
     */
    protected $repositoryName;

    /**
     * Contract/Interface Namespace
     *
     * @var string
     */
    protected $contractNamespace;

    /**
     * Repository Class Namespace
     *
     * @var string
     */
    protected $repositoryNameSpace;

    /**
     * @param string $contractName
     */
    protected function setContractName($contractName)
    {
        $this->contractName = $contractName;
    }

    /**
     * @param string $repositoryName
     */
    protected function setRepositoryName($repositoryName)
    {
        $this->repositoryName = $repositoryName;
    }

    /**
     * @param string $contractNamespace
     */
    protected function setContractNamespace($contractNamespace)
    {
        $this->contractNamespace = $this->getAppNamespace().$contractNamespace;
    }

    /**
     * @param string $repositoryNameSpace
     */
    protected function setRepositoryNameSpace($repositoryNameSpace)
    {
        $this->repositoryNameSpace
            = $this->getAppNamespace().$repositoryNameSpace;
    }

    /**
     * set the properties for Repository
     *
     * @param $model
     */
    protected function config($model)
    {
        $this->setContractName("{$model}Repository");

        $this->setRepositoryName("Eloquent{$model}Repository");

        $this->setContractNamespace("{$model}\\Contracts");

        $this->setRepositoryNameSpace("{$model}\\Repositories");
    }

    /**
     * Generate the Model Specific Repository Contract/Interface
     *
     * @param $modelPath
     *
     * @return array
     */
    private function makeRepositoryContract($modelPath)
    {
        $path = "{$modelPath}/Contracts/{$this->contractName}.php";

        if (!$this->exists($path)) {
            $content = $this->getRepositoryContractTemplate();

            $this->file->put($path, $content);
        }
    }

    /**
     * Generate Model Specific Eloquent Repository
     *
     * @param $modelPath
     */
    private function makeEloquentRepository($modelPath)
    {
        $path = "{$modelPath}/Repositories/{$this->repositoryName}.php";

        if (!$this->exists($path)) {
            $content = $this->getEloquentRepositoryTemplate();

            $this->file->put($path, $content);
        }
    }

    /**
     * Get the content for Repository Contract/Interface
     */
    private function getRepositoryContractTemplate()
    {
        $template = $this->getTemplate('RepositoryContract');

        $find = ['{{Namespace}}', '{{Interface}}'];
        $replace = [$this->contractNamespace, $this->contractName];

        return str_replace($find, $replace, $template);
    }

    /**
     * Get the content for Eloquet Repository Class
     */
    private function getEloquentRepositoryTemplate()
    {
        $template = $this->getTemplate('EloquentRepository');

        $contractNamespace = $this->contractNamespace."\\$this->contractName";

        $find = [
            '{{Namespace}}',
            '{{ContractNamespace}}',
            '{{Repository}}',
            '{{Contaract}}'
        ];

        $replace = [
            $this->repositoryNameSpace,
            $contractNamespace,
            $this->repositoryName,
            $this->contractName
        ];

        return str_replace($find, $replace, $template);
    }
}
