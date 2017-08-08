<?php
/**
 * Created by PhpStorm.
 * User: Diwork
 * Date: 08.08.2017
 * Time: 15:13
 */

namespace app\commands;

use yii\helpers\Console;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

class DbController extends Controller
{
    public $dumpPath = '@app/data';

    public function actionImport($path = null)
    {
        $path = $path ? : $this->dumpPath;
        $path = FileHelper::normalizePath(Yii::getAlias($path));
        if (file_exists($path)) {
            if (is_dir($path)) {
                $files = FileHelper::findFiles($path, ['only' => ['*.sql']]);
                if (!$files) {
                    echo 'Path does not contain any SQL files' . PHP_EOL;
                    exit;
                }
                $select = Console::select('Select SQL file', $files);
                if (Console::confirm('Confirm selected file [' . $files[$select] . ']')) {
                    $path = $files[$select];
                } else {
                    exit;
                }
            }
            $db = Yii::$app->getDb();
            if (!$db) {
                echo 'DB component not configured' . PHP_EOL;
                exit;
            }
            exec('mysql --host=' . $this->getDsnAttribute('host', $db->dsn) . ' --user=' . $db->username . ' --password=' . $db->password . ' ' . $this->getDsnAttribute('dbname', $db->dsn) . ' < ' . $path);
            echo 'Dump file [' . $path . '] was imported' . PHP_EOL;
        } else {
            echo 'Path does not exist' . PHP_EOL;
        }
    }

    public function actionExport($path = null)
    {
        $path = $path ? : $this->dumpPath;
        $path = FileHelper::normalizePath(Yii::getAlias($path));
        if (file_exists($path)) {
            if (is_dir($path)) {
                if (!is_writable($path)) {
                    echo 'Directory not writable' . PHP_EOL;
                    exit;
                }
                $fileName = 'dump-' . date('Y-m-d-H-i-s') . '.sql';
                $fileName = Console::prompt('Enter filename:', ['default' => $fileName]);
                $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

                $db = Yii::$app->getDb();
                if (!$db) {
                    echo 'DB component not configured' . PHP_EOL;
                    exit;
                }
                exec('mysqldump --host=' . $this->getDsnAttribute('host', $db->dsn) . ' --user=' . $db->username . ' --password=' . $db->password . ' ' . $this->getDsnAttribute('dbname', $db->dsn) . ' --skip-add-locks  > ' . $filePath);
            } else {
                echo 'Path must be a directory' . PHP_EOL;
            }
        } else {
            echo 'Path does not exist' . PHP_EOL;
        }
    }

    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}