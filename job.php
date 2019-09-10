<?php
require_once  'io.php';
/*
    This class is a Job DHC (Data Holder Class).
    Job contains the following (public) functions required for a given Job attribute.
    - Job Id
    - Job Title
    - Job Desc
    - Job Close Date
    - Job Postion Type
    - Job Contract Type
    - Job Application Method (Post/Mail)
    - Job Location (State)
    - Display the job details 
*/
final class Job
{
    private $lId;
    private $lTitle;
    private $lDescription;
    private $lCloseDate;
    private $lPositionType;
    private $lContract;
    private $lCommunication;
    private $lLocation;

    public function __construct($aId,$aTitle, $aDesc, $aCloseDate, $aPositionType, $aContract, $aCommunication,$aLocation)
    {
        $this->lId = IO::Sanitize($aId);
        $this->lTitle = IO::Sanitize($aTitle);
        $this->lDescription = IO::Sanitize($aDesc);
        $this->lCloseDate = IO::Sanitize($aCloseDate);
        $this->lPositionType = IO::Sanitize($aPositionType);
        $this->lContract = IO::Sanitize($aContract);
        $this->lCommunication = IO::Sanitize($aCommunication);
        $this->lLocation = IO::Sanitize($aLocation);
    }

    public function GetId()
    {
        return $this->lId;
    }

    public function GetTitle()
    {
        return $this->lTitle;
    }

    public function GetDesc()
    {
        return $this->lDescription;
    }

    public function GetCloseDate()
    {
        return $this->lCloseDate;
    }

    public function GetPositionType()
    {
        return $this->lPositionType;
    }

    public function GetContract()
    {
        return $this->lContract;
    }

    public function GetCommunication()
    {
        if (is_array($this->lCommunication))
        {
            return implode(" ",$this->lCommunication);
        }

        return $this->lCommunication;
    }

    public function GetLocation()
    {
        return $this->lLocation;
    }

    public function Display()
    {
        // Store Application By details in two columns
        $lCommA =   $this->lCommunication[0];
        $lCommB = "";
        if (is_array($this->lCommunication))
        {
            $lCommB = (count($this->lCommunication) === 2) ? $this->lCommunication[1] : "";
        }
        else
        {
            $lCommA =   $this->lCommunication;
        }

        return ( $this->lId."\t".
                $this->lTitle."\t".
                $this->lDescription."\t".
                $this->lCloseDate."\t".
                $this->lPositionType."\t".
                $this->lContract."\t".
                $lCommA."\t". $lCommB."\t".
                $this->lLocation."\n"
                );
    }
}
?>
