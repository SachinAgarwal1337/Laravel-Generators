<?php namespace SKAgarwal\Generators\Traits;

use Illuminate\Console\AppNamespaceDetectorTrait;

trait RepositoryGeneratableTrait
{

    use AppNamespaceDetectorTrait;

    /**
     * Contract/Interface Name.
     *
     * @var string
     */
    protected $contractName;

    /**
     * Repository Class Name.
     *
     * @var string
     */
    protected $repositoryName;

    /**
     * Contract/Interface Namespace.
     *
     * @var string
     */
    protected $contractNamespace;

    /**
     * Repository Class Namespace.
     *
     * @var string
     */
    protected $repositoryNamespace;

    /**
     * Set the contract name.
     *
     * @param string $contractName
     *
     * @return $this
     */
    protected function setContractName($contractName)
    {
        $this->contractName = $contractName;

        return $this;
    }

    /**
     * Set the repository name.
     *
     * @param string $repositoryName
     *
     * @return this
     */
    protected function setRepositoryName($repositoryName)
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    /**
     * Set the contract namespace.
     *
     * @param $contractNamespace
     *
     * @return $this
     */
    protected function setContractNamespace($contractNamespace)
    {
        $this->contractNamespace
            = $this->getAppNamespace() . $contractNamespace;

        return $this;
    }

    /**
     * Set the repository namespace.
     *
     * @param string $repositoryNamespace
     *
     * @return $this
     */
    protected function setRepositoryNamespace($repositoryNamespace)
    {
        $this->repositoryNamespace
            = $this->getAppNamespace() . $repositoryNamespace;

        return $this;
    }

    /**
     * Set the properties for the Repository.
     *
     * @param $model
     */
    protected function config($model, $repoName)
    {
        $this->setContractName("{$repoName}Repository");

        $this->setRepositoryName("Eloquent{$repoName}Repository");

        $this->setContractNamespace("{$model}\\Contracts");

        $this->setRepositoryNamespace("{$model}\\Repositories");
    }

    /**
     * Generate the Model Specific Repository Contract/Interface.
     *
     * @param string $modelPath
     *
     * @return mixed
     */
    protected function makeRepositoryContract($modelPath)
    {
        $path = "{$modelPath}/Contracts/{$this->contractName}.php";

        if (!$this->exists($path)) {
            $content = $this->getRepositoryContractTemplate();

            return $this->file->put($path, $content);
        }
    }

    /**
     * Generate Model Specific Eloquent Repository.
     *
     * @param $modelPath
     *
     * @return mixed
     */
    protected function makeEloquentRepository($modelPath)
    {
        $path = "{$modelPath}/Repositories/{$this->repositoryName}.php";

        if (!$this->exists($path)) {
            $content = $this->getEloquentRepositoryTemplate();

            return $this->file->put($path, $content);
        }
    }

    /**
     * Get the content for Repository Contract/Interface
     *
     * @return strung|array
     */
    private function getRepositoryContractTemplate()
    {
        $template = $this->getTemplate('RepositoryContract');

        $find = ['{{Namespace}}', '{{Interface}}'];
        $replace = [$this->contractNamespace, $this->contractName];

        return str_replace($find, $replace, $template);
    }

    /**
     * Get the content for Eloquent Repository Class.
     *
     * @return string|array
     */
    private function getEloquentRepositoryTemplate()
    {
        $template = $this->getTemplate('EloquentRepository');

        $contractNamespace = $this->contractNamespace . "\\$this->contractName";

        $find = [
            '{{Namespace}}',
            '{{ContractNamespace}}',
            '{{Repository}}',
            '{{Contract}}'
        ];

        $replace = [
            $this->repositoryNamespace,
            $contractNamespace,
            $this->repositoryName,
            $this->contractName
        ];

        return str_replace($find, $replace, $template);
    }
}
