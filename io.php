<?php
include_once 'job.php';

// Flag to hide errors in production code
error_reporting(-1);
ini_set('display_errors', 'true');

// Message constants (refer to IO::DecodeMsg for message content)
const FILE_NO_EXIST = 0;
const FILE_OPEN_FAIL  = -1;
const FILE_OPEN_SUCCESS = 1;
const FILE_CLOSE_FAIL = -2;
const FILE_CLOSE_SUCCESS = 2;
const FILE_NO_OPEN_CLOSE = -3;
const FILE_WRITE_FAIL = -7;
const FILE_WRITE_SUCCESS = 7;
const FILE_READ_FAIL = -15;
const FILE_READ_SUCCESS = 15;
const VALIDATION_SUCCESS = 10;
const VALIDATION_FAIL = -10;
const JOB_ADD_SUCCESS = 5;
const JOB_ADD_FAIL = -5;
const JOB_EXIST_FAIL = -12;
const REQUIRED_INPUT_VALUE_NOT_SET = -25;
const SEARCH_RETURN_NOTHING = -65;

/*
    This class holds helper functions that are used throught the web application
    The class IO contains static functions relating to
    - Validation of input data
    - Data Input santization
    - Output Message decoding (message table)
    - Array sorting by date (specific only to Job Object)
*/
class IO
{
    static function Validation($aJob, $rule)
    {
        if ($rule ===  "JOB_VALIDATION_CHECK")
        {
            return self::JobValidation($aJob,$rule);
        }
        if ($rule ===  "JOB_VALIDATION_SEARCH_CHECK")
        {
            return self::JobValidation($aJob,$rule);
        }
        return 0;
    }

    static private function JobValidation($aJob, $rule)
    {
        $lStatus = 1;
        if ($rule ===  "JOB_VALIDATION_SEARCH_CHECK")
        {
            $lStatus *= preg_match("/^[a-zA-Z0-9 .,!]{1,20}+$/", $aJob->GetTitle()); 
            $lStatus *= preg_match("/(FullTime|PartTime|IGNORE)/", $aJob->GetPositionType()); 
            $lStatus *= preg_match("/(Post|Mail|Post Mail|IGNORE)/", $aJob->GetCommunication()); 
            $lStatus *= preg_match("/(Ongoing|Fixed|IGNORE)/", $aJob->GetContract()); 
            $lStatus *= preg_match("/^VIC$|^NSW$|^QLD$|^NT$|^WA$|^SA$|^TAS$|^ACT$|^IGNORE$/", $aJob->GetLocation());
        }
        else if ($rule ===  "JOB_VALIDATION_CHECK")
        {
            $lStatus *= preg_match("/^P{1}\d{4}$/", $aJob->GetId());
            $lStatus *= preg_match("/^[a-zA-Z0-9 .,!]{1,20}+$/", $aJob->GetTitle()); 
            $lStatus *= (strlen($aJob->GetDesc()) <= 260) ? 1 : 0; 
            // Note : Assignment brief only stated that the date conform to a given format, not whether the inputted date was valid.
            $lStatus *= preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $aJob->GetCloseDate());   
            $lStatus *= preg_match("/(FullTime|PartTime)/", $aJob->GetPositionType()); 
            $lStatus *= preg_match("/(Post|Mail|Post Mail)/", $aJob->GetCommunication()); 
            $lStatus *= preg_match("/(Ongoing|Fixed)/", $aJob->GetContract()); 
            $lStatus *= preg_match("/^VIC$|^NSW$|^QLD$|^NT$|^WA$|^SA$|^TAS$|^ACT$/", $aJob->GetLocation());
        }
        else
        {
            $lStatus = 0; 
        }
        return ($lStatus === 1) ? VALIDATION_SUCCESS : VALIDATION_FAIL;
    }

    static function Sanitize($data)
    {
        // Checks if $data is of array type. if it is an array, sanitize it.
        if (is_array($data))
        {
            $item = array();
            foreach($data as $val)
            {
                $item[] = self::Strip($val);
            }
            return $item;
        }
        
        return self::Strip($data);
    }

    static private function Strip($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    static function DateSortRecent($a, $b) {
        $a[3] = str_replace('/', '-', $a[3]);
        $b[3] = str_replace('/', '-', $b[3]);
        return strtotime($b[3]) - strtotime($a[3]);
    }

    static function DecodeMsg($value)
    {
        switch($value)
        {
            case FILE_NO_EXIST : echo "<p>The file does not exist!</p>"; break;
            case FILE_OPEN_FAIL : echo "<p>The file failed to be opened!</p>"; break;
            case FILE_OPEN_SUCCESS : echo "<p>The file opened successfully</p>"; break;
            case REQUIRED_INPUT_VALUE_NOT_SET : echo "<p>Please fill in the required details. Don't play with the HTML5 validation!</p>"; break;
            case FILE_CLOSE_FAIL : echo "<p>The file failed to close!</p>";break;
            case FILE_CLOSE_SUCCESS : echo "<p>The file closed successfully!</p>";break;
            case FILE_NO_OPEN_CLOSE : echo "<p>There was no file opened that had to be closed! Please open a file first before calling its close!</p>";break;
            case FILE_WRITE_FAIL : echo "<p>The file couldn't be written to!</p>";break;
            case FILE_WRITE_SUCCESS : echo "<p>The file was successfully written to!</p>";break;
            case FILE_READ_FAIL : echo "<p>The file was unable to be read!</p>";break;
            case FILE_READ_SUCCESS : echo "<p>The file was read successfully!</p>";break;
            case VALIDATION_SUCCESS : echo "<p>The validation was successful!</p>";break;
            case VALIDATION_FAIL : echo "<p>The input validation has failed. Please fill in the required details correctly.</p>";break;
            case JOB_ADD_SUCCESS : echo "<p>The job has been added successfully!</p>";break;
            case JOB_ADD_FAIL  : echo "<p>The job could not be added to the file!</p>";break;
            case JOB_EXIST_FAIL : echo "<p>This particular job already exists. Please enter in a unique job ID!</p>";break;
            case SEARCH_RETURN_NOTHING : echo "<p>The particular search result presented no job :-(</p>";break;    
            default : echo "<p>Unknown msg ($value). Please contact devs at 101119509@student.swin.edu.au!</p>";
        }
    }
}
?>