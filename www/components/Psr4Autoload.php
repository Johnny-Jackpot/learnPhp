<?php

namespace Components;

class Psr4Autoload
{
    protected $prefixes = array();

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    protected function initPrefixArr($prefix)
    {
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }
    }

    protected function addBaseDir($prefix, $base_dir, $prepend)
    {
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $base_dir);
        } else {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $this->initPrefixArr($prefix);
        $this->addBaseDir($prefix, $base_dir, $prepend);
    }

    public function loadClass($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);

            if ($this->loadMappedFile($prefix, $relative_class)) {
                return true;
            }

            $prefix = rtrim($prefix, '\\');
        }

        return false;
    }

    protected function loadMappedFile($prefix, $relative_class)
    {
        if (!isset($this->prefixes[$prefix])) {
            return false;
        }

        foreach ($this->prefixes[$prefix] as $base_dir) {
            $file = $base_dir . DIRECTORY_SEPARATOR
                . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class)
                . '.php';

            if ($this->requireFile($file)) {
                return true;
            }
        }

        return false;
    }

    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}