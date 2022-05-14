<?php

namespace app\commands;

use yii\base\InvalidArgumentException;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class FixController
 *
 * @package app\commands
 */
class FixController extends Controller
{

    const SET_WRITABLE = [
        'runtime',
        'web/assets',
        'web/uploads',
    ];

    const SET_EXECUTABLE = [
        'yii',
        'yii_test',
    ];

    private $root;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->root = realpath(dirname(__DIR__));
    }

    public function actionIndex()
    {
        $this->setWritable($this->root, self::SET_WRITABLE);
        $this->setExecutable($this->root, self::SET_EXECUTABLE);

        return ExitCode::OK;
    }

    public function actionPermission()
    {
        $this->setWritable($this->root, self::SET_WRITABLE);

        return ExitCode::OK;
    }

    public function actionExec()
    {
        $this->setExecutable($this->root, self::SET_EXECUTABLE);

        return ExitCode::OK;
    }

    /**
     * Set writable
     *
     * @param string $root
     * @param array $paths
     */
    private function setWritable(string $root, array $paths): void
    {
        foreach ($paths as $writable) {
            if (is_dir("$root/$writable")) {
                if (@chmod("$root/$writable", 0777)) {
                    echo "chmod 0777 $writable\n";
                } else {
                    throw new InvalidArgumentException("Operation chmod not permitted for directory $writable.");
                }
            } else {
                throw new InvalidArgumentException("Directory $writable does not exist.");
            }
        }
    }

    /**
     * Set executable
     *
     * @param string $root
     * @param array $paths
     */
    private function setExecutable(string $root, array $paths): void
    {
        foreach ($paths as $executable) {
            if (file_exists("$root/$executable")) {
                if (@chmod("$root/$executable", 0755)) {
                    echo "chmod 0755 $executable\n";
                } else {
                    throw new InvalidArgumentException("Operation chmod not permitted for $executable.");
                }
            } else {
                throw new InvalidArgumentException("$executable does not exist.");
            }
        }
    }
}
