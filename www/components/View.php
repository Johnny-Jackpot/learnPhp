<?php

namespace Components;

class View
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $data;

    /**
     * View constructor.
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * Assemble entire html file
     * @param array $data
     * @return string
     */
    public function render(array $data = null): string
    {
        if (!empty($data)) {
            extract($data, EXTR_OVERWRITE);
            $this->data = $data;
        }

        ob_start();
        include($this->template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Embed piece of html into view
     * @param string $block
     */
    public function renderBlock(string $block) {
        if (!empty($this->data)) {
            extract($this->data, EXTR_OVERWRITE);
        }

        include $block;
    }
}