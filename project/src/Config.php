<?php

namespace KCS;

class Config
{
    private array $configList = [];

    public function __construct()
    {
        (new DotEnv(__DIR__.'/../.env'))->load();
        
        $this->loadConfigFiles();
    }
    
    private function loadConfigFiles(): void
    {
        //if mandatory file is missing throw exception
        $configDirPath = __DIR__.'/../config';
        $filenames = scandir($configDirPath);
        
        foreach ($filenames as $filename) {
            if ($filename === '..' || $filename === '.') {
                continue;
            }
            $filePath = $configDirPath . "/" . $filename;
            
            $this->configList[explode(".", $filename)[0]] = include $filePath;
        }
        
    }
    
    public function get(string $configName)
    {
        
        return $this->configList[$configName];
    }
    
}