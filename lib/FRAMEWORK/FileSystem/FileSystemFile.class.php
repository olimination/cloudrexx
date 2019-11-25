<?php

/**
 * Cloudrexx
 *
 * @link      http://www.cloudrexx.com
 * @copyright Cloudrexx AG 2007-2015
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Cloudrexx" is a registered trademark of Cloudrexx AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * File System File
 *
 * @copyright   CLOUDREXX CMS - CLOUDREXX AG
 * @author      CLOUDREXX Development Team <info@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  lib_filesystem
 */

namespace Cx\Lib\FileSystem;

/**
 * FileSystemFileException
 *
 * @copyright   CLOUDREXX CMS - CLOUDREXX AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @package     cloudrexx
 * @subpackage  lib_filesystem
 */
class FileSystemFileException extends FileException {};

/**
 * File System File
 *
 * This class provides an object based interface to a file that resides
 * on the local file system.
 *
 * @copyright   CLOUDREXX CMS - CLOUDREXX AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @version     3.0.0
 * @package     cloudrexx
 * @subpackage  lib_filesystem
 */
class FileSystemFile implements FileInterface
{
    private $filePath = null;

    /**
     * Create a new FileSystemFile object that acts as an interface to
     * a file located on the local file system.
     *
     * @param   string Path to file on local file system.
     */
    public function __construct($file)
    {
        if (empty($file)) {
            throw new FileSystemFileException('No file path specified!');
        }

        // $file is specified by absolute file system path of operating system
        if (   strpos($file, \Env::get('cx')->getWebsiteDocumentRootPath()) === 0
            || strpos($file, \Env::get('cx')->getCodeBaseDocumentRootPath()) === 0
        ) {
            $this->filePath = $file;
        // $file is specified by relative path of Website's offset path
        } elseif (\Env::get('cx')->getWebsiteOffsetPath() && strpos($file, \Env::get('cx')->getWebsiteOffsetPath()) === 0) {
            $this->filePath = \Env::get('cx')->getWebsitePath() . $file;
        // $file is specified by absolute path from Website's document root
        } elseif (strpos($file, '/') === 0) {
            $this->filePath = \Env::get('cx')->getWebsiteDocumentRootPath() . $file;
        // $file path is unkown -> assuming its relative from Website's document root
        } else {
            $this->filePath = \Env::get('cx')->getWebsiteDocumentRootPath() . '/'.$file;
        }
    }

    public function getFileOwner()
    {
        // get the user-ID of the user who owns the loaded file
        $fileOwnerId = file_exists($this->filePath) ? fileowner($this->filePath) : 0;
        if (!$fileOwnerId) {
            throw new FileSystemFileException('Unable to fetch file owner of '.$this->filePath);
        }

        return $fileOwnerId;
    }

    public function isWritable() {
        return is_writable($this->filePath);
    }

    public function write($data)
    {
        static::callUpdateEvent('Pre', $this->filePath);
        // first try
        $fp = @fopen($this->filePath, 'w');
        if (!$fp) {
            // try to set write access
            $this->makeWritable($this->filePath);
        }

        // second try
        $fp = @fopen($this->filePath, 'w');
        if (!$fp) {
            static::callUpdateEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to open file '.$this->filePath.' for writting!');
        }

        // acquire exclusive file lock
        flock($fp, LOCK_EX);

        // write data to file
        $writeStatus = fwrite($fp, $data);

        // release exclusive file lock
        flock($fp, LOCK_UN);
        if ($writeStatus === false) {
            static::callUpdateEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to write data to file '.$this->filePath.'!');
        }
        static::callUpdateEvent('PostSuccessful', $this->filePath);
    }

    public function append($data)
    {
        static::callUpdateEvent('Pre', $this->filePath);
        // first try
        $fp = @fopen($this->filePath, 'a');
        if (!$fp) {
            // try to set write access
            $this->makeWritable($this->filePath);
        }

        // second try
        $fp = @fopen($this->filePath, 'a');
        if (!$fp) {
            static::callUpdateEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to open file '.$this->filePath.' for writting!');
        }

        // acquire exclusive file lock
        flock($fp, LOCK_EX);

        // write data to file
        $writeStatus = fwrite($fp, $data);

        // release exclusive file lock
        flock($fp, LOCK_UN);
        if ($writeStatus === false) {
            static::callUpdateEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to append data to file '.$this->filePath.'!');
        }
        static::callUpdateEvent('PostSuccessful', $this->filePath);
    }

    public function touch()
    {
        static::callUpdateEvent('Pre', $this->filePath);
        \Cx\Lib\FileSystem\FileSystem::makeWritable($this->filePath);
        if (!touch($this->filePath)) {
            static::callUpdateEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to touch file in file system!');
        }
        static::callUpdateEvent('PostSuccessful', $this->filePath);
    }

    public function copy($dst)
    {
        // TODO: Indexer!
        if (!copy($this->filePath, $dst)) {
            throw new FileSystemFileException('Unable to copy ' . $this->filePath . ' to ' . $dst . '!');
        }
        \Cx\Lib\FileSystem\FileSystem::makeWritable($dst);
    }

    public function rename($dst)
    {
        $this->move($dst);
    }

    public function move($dst)
    {
        static::callUpdateEvent('Pre', $this->filePath, $dst);
        if (!rename($this->filePath, $dst)) {
            static::callUpdateEvent('PostFailed', $this->filePath, $dst);
            throw new FileSystemFileException('Unable to move ' . $this->filePath . ' to ' . $dst . '!');
        }
        \Cx\Lib\FileSystem\FileSystem::makeWritable($dst);
        static::callUpdateEvent('PostSuccessful', $this->filePath, $dst);
    }

    public function getFilePermissions()
    {
        // fetch current permissions on loaded file
        $filePerms = file_exists($this->filePath) && fileperms($this->filePath);
        if ($filePerms === false) {
            throw new FileSystemFileException('Unable to fetch file permissions of file '.$this->filePath.'!');
        }

        // Strip BITs that are not related to the file permissions.
        // Only the first 9 BITs are related (i.e: rwxrwxrwx) -> bindec(111111111) = 511
        $filePerms = $filePerms & 511;

        return $filePerms;
    }

    public function makeWritable()
    {
        // abort process in case the file is already writable
        if (is_writable($this->filePath)) {
            return true;
        }

        $parentDirectory = dirname($this->filePath);
        if (!is_writable($parentDirectory)) {
            if (strpos($parentDirectory, \Env::get('cx')->getWebsiteDocumentRootPath()) === 0) {
                // parent directory lies within the Cloudrexx installation directory,
                // therefore, we shall try to make it writable
                \Cx\Lib\FileSystem\FileSystem::makeWritable($parentDirectory);
            } else {
                throw new FileSystemFileException('Parent directory '.$parentDirectory.' lies outside of Cloudrexx installation and can therefore not be made writable!');
            }
        }

        // fetch current permissions on loaded file
        $filePerms = $this->getFilePermissions();

        // set write access to file owner
        $filePerms |= \Cx\Lib\FileSystem\FileSystem::CHMOD_USER_WRITE;

        // log file permissions into the humand readable chmod() format
        \DBG::msg('CHMOD: '.substr(sprintf('%o', $filePerms), -4));

        if (!@chmod($this->filePath, $filePerms)) {
            throw new FileSystemFileException('Unable to set write access to file '.$this->filePath.'!');
        }
    }

    public function delete()
    {
        static::callDeleteEvent('Pre', $this->filePath);
        \Cx\Lib\FileSystem\FileSystem::makeWritable(dirname($this->filePath));
        if (!unlink($this->filePath)) {
            static::callDeleteEvent('PostFailed', $this->filePath);
            throw new FileSystemFileException('Unable to delete file '.$this->filePath.'!');
        }
        static::callDeleteEvent('PostSuccessful', $this->filePath);
    }

    /**
     * Get the absolute path of the file($this->file)
     *
     * @return string absolute path of the file
     */
    public function getAbsoluteFilePath()
    {
        return $this->filePath;
    }

    /**
     * Call Indexer event to delete
     *
     * @todo Move to filesystem abstraction based on MediaSource filesystem
     *  abstraction (see CLX-3069)
     * @throws \Cx\Core\Event\Controller\EventManagerException
     * @param $prefix string Event prefix
     * @param $path string path to file or directory
     * @param $name string name of file or directory
     * @deprecated See todo
     */
    public static function callDeleteEvent($prefix, $path, $name) {
        static::callEvent(
            $prefix,
            'Remove',
            array(
                'path' => $path,
                'name' => $name
            )
        );
    }

    /**
     * Call Indexer event to update
     *
     * @todo Move to filesystem abstraction based on MediaSource filesystem
     *  abstraction (see CLX-3069)
     * @throws \Cx\Core\Event\Controller\EventManagerException
     * @param $prefix string Event prefix
     * @param $path    string path to file or directory
     * @param $name    string name of file or directory
     * @param $oldname string old name of file or directory
     * @deprecated See todo
     */
    public static function callUpdateEvent($prefix, $from, $to = '')
    {
        static::callEvent(
            $prefix,
            'Update',
            array(
                'path' => $to,
                'oldPath' => $from,
            )
        );
    }

    /**
     * Call Indexer event to add
     *
     * @todo Move to filesystem abstraction based on MediaSource filesystem
     *  abstraction (see CLX-3069)
     * @throws \Cx\Core\Event\Controller\EventManagerException
     * @param $prefix string Event prefix
     * @param $path string path to file or directory
     * @param $name string name of file or directory
     * @deprecated See todo
     */
    public static function callAddEvent($prefix, $path, $name)
    {
        static::callEvent(
            $prefix,
            'Add',
            array(
                'path' => $path . $name
            )
        );
    }

    /**
     * Call an indexer event
     *
     * @todo Move to filesystem abstraction based on MediaSource filesystem
     *  abstraction (see CLX-3069)
     * @throws \Cx\Core\Event\Controller\EventManagerException
     * @param $prefix string Event prefix
     * @param $event string Event name without prefix
     * @param $params array List of params
     * @deprecated Use non-static method instead
     * @deprecated See todo
     */
    protected static function callEvent($prefix, $event, $params) {
        $cx = \Cx\Core\Core\Controller\Cx::instanciate();
        $cx->getEvents()->triggerEvent('MediaSource.File:' . $prefix . $event, $params);
    }
}
