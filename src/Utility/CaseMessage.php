<?php
namespace App\Utility;
use Faker\Factory as Faker;
use phpDocumentor\Reflection\Types\Object_;
class CaseMessage
{
    protected $plaintiff = '';
    protected $defandants = '';
    protected $plaintiff_count = 0;
    protected $defandant_count = 0;
    protected $DNCR_violation = true ;
    protected $IDNCR_violation = true;
    protected $TIAA_violation = true;
    protected $placeholder = [];// it will hold all placeholders in the text
    /**
     * @todo I will later move this message to Database so the can be changed by Admin,
     * However, given these are legal message unlike they are going to change much or more
     * frequently
     **/
    protected $message = "{plaintiff_names} ({“Plaintiff”})  {bring} this action seeking to enforce {Plaintiff’s_0} right
    to privacy under the consumer-privacy provisions of the Telephone Consumer Protection Act (“TCPA”), 47 U.S.C. § 227. <br> <br>
    {defandant_names} ({“Defendant”}) violated the TCPA by using an automated dialing system, or “ATDS”,
    to send telemarketing text messages to {Plaintiff’s}
    cellular telephone {number} for the purposes of advertising {its} goods and services.";
    /*
     * A full stop if No IDNCR
     */
    protected $middle_dncr_idncr = ' Further violating the TCPA, {Defendant} sent multiple text messages to {Plaintiff}';
    protected $DNCR_message = ' despite {Plaintiff’s_0} presence on the National Do Not Call Registry';
    protected $IDNCR_message = 'without maintaining internal do not call procedures as required by law.';
    protected $TIAA_message = ' {Lastly|Also}, the text messages violated the Utah Truth In Advertising Act.';
    public function __construct($data)
    {
        /*
         * Initiatization
         */
        $this->plaintiff_count = $data->pc;
        $this->defandant_count = $data->dc;
        $this->DNCR_violation = $data->dncr;
        $this->IDNCR_violation = $data->idncr;
        $this->TIAA_violation = $data->tiaa;
        $this->defandants = $this->getDefandants($data->dc);
        $this->plaintiff = $this->getPlaintiffs($data->pc);
        $this->setPlaceHolder();
    }
    /*
     * helper methods
     */
    public function singularize(){}
    public function setPlaceHolder(){
        $this->placeholder = [
            '{plaintiff_names}' => $this->plaintiff,
            "{“Plaintiff”}" => $this->plaintiff_count > 1 ? '“Plaintiffs”' : '“Plaintiff”',
            "{Plaintiff}" => $this->plaintiff_count > 1 ? 'Plaintiffs' : 'Plaintiff',
            '{bring}' => $this->plaintiff_count > 1 ? 'bring' : 'brings',
            '{Plaintiff’s_0}' => $this->plaintiff_count > 1 ? 'their' : 'Plaintiff’s',
            '{Plaintiff’s}' => $this->plaintiff_count > 1 ? 'Plaintiffs’' : 'Plaintiff’s',
            '{their}' => $this->plaintiff_count > 1 ? 'their' : 'Plaintiff’s',
            //'Plaintiff’s|Plaintiffs’' => count($this->plaintiff) > 1 ? 'Plaintiff’s' : Plaintiffs’,
            '{Plaintiff|Plaintiffs}' => $this->plaintiff,
            '{defandant_names}'=> $this->defandants,
            "{“Defendant”}" =>  $this->defandant_count > 1 ? '“Defendants”' : '“Defendant”',
            "{Defendant}" =>  $this->defandant_count > 1 ? 'Defendants' : 'Defendant',
            "{number}" =>  $this->plaintiff_count > 1 ? 'numbers' : 'number',
            "{its}"     => $this->defandant_count > 1 ?   'their' : 'its',
            "{Lastly|Also}" => $this->DNCR_violation || $this->IDNCR_violation ?  'Lastly' : 'Also',
        ];
    }
    public function getNames($count){
        $names = '';
        $faker = Faker::create();
        for ($i = 0; $i < $count; $i++)
        {
            if( $count > 1 && $count <= 5 && $i == $count -1 )
            {
                $names .= ' and ' .$faker->firstName;
            }
            else {
                $names .= ' ' .$faker->firstName;
            }
        }
        return $names;
    }
    public function getDefandants($count){
        /**
         * Any custom logic for Defandents comes here
         */
        return $count > 5 ? 'Defandants' :  $this->getNames($count);
    }
    public function getPlaintiffs($count){
        /**
         * Any business logic for Plaintiff comes here
         */
        return $count > 5 ? 'Plaintiffs' :  $this->getNames($count);
    }
    public function  toObject()
    {
        return [
            'defandants' => $this->defandants,
            'defandant_count' => count($this->defandants),
            'plaintiff' => $this->plaintiff,
            'plaintiff_count' => count( $this->plaintiff),
        ];
    }
    public function getMessage(){
        $message = $this->message;
        if($this->DNCR_violation &&  $this->IDNCR_violation){
            $message .=  $this->middle_dncr_idncr. $this->DNCR_message . ', and ' . $this->IDNCR_message;
        }
        else if ($this->DNCR_violation &&  !$this->IDNCR_violation){

            $message .=  $this->middle_dncr_idncr . $this->DNCR_message . '.' ;

        }
        else if (!$this->DNCR_violation &&  $this->IDNCR_violation){
            $message .=  $this->middle_dncr_idncr . $this->IDNCR_message;
        }
        $message .= $this->TIAA_violation ? $this->TIAA_message : '';
        array_walk( $this->placeholder ,function($value,$key) use (&$message) {
            $message = str_replace($key,$value,$message);
        });
        return $message;
    }
}
