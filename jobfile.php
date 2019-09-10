<?php
require_once 'file.php';
require_once 'io.php';

/*
    This class contains specific functions that are related to the operation needed
    to interact with a job file.
    The class JobFile contains the following (public) functions relating to
    - Adding Jobs to the job file
    - Searching the job file
*/
final class JobFile extends File
{
    public function __construct($aFileName)
    {
        parent::__construct($aFileName);
    } 

    public function AddJob(Job $aJob)
    {
        $lStatus = IO::Validation($aJob, "JOB_VALIDATION_CHECK");
        if ($lStatus != VALIDATION_SUCCESS) return $lStatus;
        
        $lData = "";
        $lStatus = parent::Read($lData);  
        if ($lStatus === FILE_READ_SUCCESS)
        {
            $lData = explode("\n", $lData);
            foreach ($lData as $job)
            {
                // Split job line into their respective categories
                $jobId = explode("\t", $job);

                //Check if aJob-GetId is unique 
                if ($jobId[0] === $aJob->GetId()) return JOB_EXIST_FAIL;
            }
        }

        $lStatus = parent::Write($aJob->Display());
        return ($lStatus === FILE_WRITE_SUCCESS) ? JOB_ADD_SUCCESS : $lStatus; 
    }

    public function SearchJob(Job $aJob)
    {
        $lStatus = IO::Validation($aJob, "JOB_VALIDATION_SEARCH_CHECK");
        if ($lStatus != VALIDATION_SUCCESS) return $lStatus;

        // Check if file 'jobs.txt exists'
        $lData = "";
        $lStatus = parent::Read($lData); 
        if ($lStatus === FILE_READ_SUCCESS)
        {
            $lSearchResult = array();
            $lData = explode("\n", $lData);

            // Bug fix : Last item in the array is just a '/n' that will cause a undefined index warning.
            array_pop($lData);

            foreach ($lData as $job)
            {
                // Split job line into their respective categories
                $jobListing = explode("\t", $job);
                
                //Check if file matches search term (case-insensitive)
                // [1] Title | [3] Date | [4] PositionType(Full/Part) | [5] ContractType | [6] Post/Mail | [7] Location
                if (stripos($jobListing[1], $aJob->GetTitle()) !== false && !$this->OutdatedJob($jobListing[3],$aJob->GetCloseDate()))  
                {
                    if ($this->SearchCriteria($aJob,$jobListing)) $lSearchResult[] = $jobListing;
                }
                
            }

            // Return the search results only if it has found something 
            return !empty($lSearchResult) ? $lSearchResult : SEARCH_RETURN_NOTHING;
        }
        return $lStatus;
    }

    private function OutdatedJob($aDateA,$aDateB)
    {
        // use if ($aArray[3] - date(now)) < 0 then remove from array 
        $aDateA = str_replace('/', '-', $aDateA);
        $aDateB = str_replace('/', '-', $aDateB);
        return ((strtotime($aDateA) - strtotime($aDateB)) < 0) ? true : false;
    }

    private function SearchCriteria($aJob, $jobListing)
    {
        $lClearsCriteria = 1;
        if ($aJob->GetPositionType() != "IGNORE")  
        {
            $lClearsCriteria *= ($jobListing[4] === $aJob->GetPositionType()) ? 1 : 0;
        }
        else if ($aJob->GetContract() != "IGNORE")  
        {
            $lClearsCriteria *= ($jobListing[5] === $aJob->GetContract()) ? 1 : 0;
        }
        else if ($aJob->GetCommunication() != "IGNORE") 
        {
            $lCommJoin = (!empty($jobListing[7])) ? $jobListing[6]." ".$jobListing[7] : $jobListing[6];
            // NOTE: The assignment brief is not really clear on whether it should count (Post Mail), (Mail)
            // as two hits when searching for (Mail). I assumed that when searching for (Mail) we only
            // accept exact matches.
            //$lClearsCriteria *= (stripos($lCommJoin,$aJob->GetCommunication()) !== false) ? 1 : 0;
            $lClearsCriteria *= ($lCommJoin === $aJob->GetCommunication()) ? 1 : 0;
            
        } 
        else if ($aJob->GetLocation() != "IGNORE") 
        {
            $lClearsCriteria *= ($jobListing[7] === $aJob->GetLocation()) ? 1 : 0;
        }

        return $lClearsCriteria;
    }
}

?>