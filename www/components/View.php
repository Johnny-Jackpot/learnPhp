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
    protected $view = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * View constructor.
     * @param string $template Path to file
     * @param string $view Path to file
     */
    public function __construct(string $template, string $view = '')
    {
        $this->template = $template;
        $this->view = $view;
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
     * Embed view into template
     */
    public function renderView()
    {
        if (!empty($this->view)) {
            include $this->view;
        }
    }
    /**
     * Embed piece of html into view
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
    public function getVar(string $name)
    {
        if (isset($this->data[$name]) && !empty($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

}