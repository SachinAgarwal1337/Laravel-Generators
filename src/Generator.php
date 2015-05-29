<?php namespace SKAgarwal\Generators;

use Illuminate\Filesystem\Filesystem;

class Generator
{

    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * Model Class path
     *
     * @var string
     */
    protected $modelPath;

    /**
     * Requested Model Name
     *
     * @var string
     */
    protected $model;

    /**
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }


    /**
     * set the properties
     *
     * @param $model
     */
    protected function config($model)
    {
        $this->setModel($model);

        $this->setModelPath("app/{$this->model}");
    }

    /**
     * @param string $model
     */
    protected function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param string $modelPath
     */
    protected function setModelPath($modelPath)
    {
        $this->modelPath = $modelPath;
    }

    /**
     * check if the directory/file exists
     *
     * @param $path
     *
     * @return bool
     */
    protected function exists($path)
    {
        return $this->file->exists($path);
    }

    /**
     * create directory
     *
     * @param      $path
     * @param bool $recursive
     */
    public function makeDirectory($path, $recursive = false)
    {
        if (!$this->exists($path)) {
            $this->file->makeDirectory($path, 0755, $recursive);
        }
    }

    /**
     * Create a directory for the Requesting Model
     */
    protected function makeModelDirectory()
    {
        $this->makeDirectory($this->modelPath);
    }

    /**
     * Create subdirectories under Model Directory
     *
     * @param $subDirectory
     */
    protected function makeSubDirectory($subDirectory)
    {
        $path = "{$this->modelPath}/{$subDirectory}";

        $this->makeDirectory($path, true);
    }

    /**
     * @param $from
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getTemplate($from)
    {
        $templatePath = __DIR__."/Templates/{$from}.txt";

        return $this->file->get($templatePath);
    }

}
