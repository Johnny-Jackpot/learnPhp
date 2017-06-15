<?php

namespace Components;

class View
{
    /**
     * @var string Path to file
     */
    protected $template = '';

    /**
     * @var string Path to file
     */
    protected $layout = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * View constructor.
     * @param string $template Path to file
     * @param string $layout Path to file
     */
    public function __construct(string $template, string $layout = '')
    {
        $this->template = $this->preparePathToFile($template);
        $this->layout = $this->preparePathToFile($layout);
    }

    /**
     * Assemble entire html file
     * @param array $data
     * @return string
     */
    public function render(array $data = []): string
    {
        if (!empty($data)) {
            $this->data = $data;
        }

        ob_start();
        include $this->template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Embed layout into template
     */
    public function renderView()
    {
        if (!empty($this->layout)) {
            include $this->layout;
        }
    }

    /**
     * Embed piece of html into layout
     * @param string $block Path to file
     */
    public function renderBlock(string $block = '')
    {
        if (!empty($block)) {
            include $block;
        }
    }

    /**
     * Return variable from data set passed to render method
     * @param string $name Variable name
     * @return mixed|null
     */
    public function getVar(string $name, $default = null)
    {
        if (isset($this->data[$name]) && !empty($this->data[$name])) {

            $data = $this->data[$name];

            if (null !== $data || (null === $data && !$default)) {
                return $data;
            }

            return $data;
        }

        return $default;
    }

    /**
     * Replace '/' with DIRECTORY_SEPARATOR
     * @param string $path  Path to file
     * @return string
     */
    protected function preparePathToFile(string $path): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
