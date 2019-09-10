<?php
require_once 'io.php';

/*
    This class contains specific functions that are related to the operation needed
    to interact with a any generic file.
    The class contains the following (public) functions relating to
    - Read file 
    - Write file
    Note : The private function Open() also creates a file & accompaining folders (recursivley) if
           none exist. 
*/
abstract class File
{
    private $lFileName;
    private $lFileHandle;

    public function __construct($aFileName)
    {
        $this->lFileName = $aFileName;
    }

    private function Open($aCreateFile,$aReadMode)
    {
        if (!file_exists($this->lFileName))
        {
            if ($aCreateFile)
            {
                // Check if folder need to be created
                $lDir = str_replace(basename($this->lFileName), '', $this->lFileName); 
                if (!is_dir($lDir))
                {
                    echo $lDir;
                    mkdir($lDir, 0755, true);
                }
            }
            else
            {
                return FILE_NO_EXIST;
            } 
        }

        // Open a file in either reading or writing mode; 
        // For write mode, if the file does not exist, create it.
        $this->lFileHandle = fopen($this->lFileName,$aReadMode);
        if ($this->lFileHandle != FALSE)
        {
            return FILE_OPEN_SUCCESS;
        }

        return FILE_OPEN_FAIL;
    }

    private function Close()
    {
        if ($this->lFileHandle === FALSE or !isset($this->lFileHandle))
        {
            return FILE_NO_OPEN_CLOSE;
        }

        if (fclose($this->lFileHandle))
        {
            return FILE_CLOSE_SUCCESS;
        }

        return FILE_CLOSE_FAIL;
    }

    public function Write($data)
    {
        $lStatus = $this->Open(true,"a");
        if ($lStatus === FILE_OPEN_SUCCESS)
        {
            $lStatus = fwrite($this->lFileHandle, $data);
            $this->Close();
            return $lStatus ? FILE_WRITE_SUCCESS : FILE_WRITE_FAIL;
        }
        return $lStatus;
    }

    public function Read(&$aData)
    {
        $lStatus = $this->Open(false,"r");
        if ($lStatus === FILE_OPEN_SUCCESS)
        {
            $len = filesize($this->lFileName);
            if ($len <= 0) return FILE_READ_FAIL;
            $aData = fread($this->lFileHandle, $len);   
            $this->Close();
            return $aData ? FILE_READ_SUCCESS : FILE_READ_FAIL;
        }
        return $lStatus;
    }
}
?>