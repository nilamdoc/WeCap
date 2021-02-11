<?php
namespace app\controllers;
use lithium\storage\Session;
use \lithium\template\View;
use \lithium\data\Model;
use app\models\Malls;
use app\models\Mobiles;
use app\models\Users;
use app\models\Lists;
use app\extensions\action\Functions;
use app\extensions\action\GoogleAuthenticator;

class WecapController extends \lithium\action\Controller {
 
 
 protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
//  $this->_render['layout'] = 'sale';
 }
 public function index(){
   return compact('a');
 }
 
 public function searchmca(){
 if($this->request->data){
  $user = Users::find('first',array(
   'conditions'=>array(
    'mcaNumber'=>$this->request->data['mcaNumber'],
//    'percent'=>array('$ne'=>null)
    )
  ));
  $findmobile = Mobiles::find('first',array(
   'conditions'=>array('mcaNumber'=>$this->request->data['mcaNumber'])
  ));
  if(count($findmobile)==0){
   $mobile = array('Mobile'=>"");
  }else{
   $mobile = array('Mobile'=>$findmobile['Mobile']);
  }
 $p1yyyymm = date("Y-m", strtotime("-1 month", strtotime(date("F") . "1")) );
 $p0yyyymm = date("Y-m", strtotime("0 month", strtotime(date("F") . "1")) );
  $tree=array();
  foreach($user['ancestors'] as $key=>$val){
    $upline = Users::find('first',array(
     'conditions'=>array('mcaNumber'=>$val,
     $p1yyyymm.'.Percent'=>array('$ne'=>null)
     )
    ));
    if($upline['mcaNumber']!=null){
     $findUserMobile = Mobiles::find('first',array(
      'conditions'=>array('mcaNumber'=>$upline['mcaNumber'])
     ));
   if(count($findUserMobile)==0){
    $UserMobile = array('Mobile'=>"");
   }else{
    $UserMobile = array('Mobile'=>$findUserMobile['Mobile']);
   }  
     array_push($tree,array(
      'mcaName'=>$upline['mcaName'],
      'mcaNumber'=>$upline['mcaNumber'],
      'Percent'=>$upline[$p1yyyymm]['Percent'],
      'ValidTitle'=>$upline[$p1yyyymm]['ValidTitle'],
      'PaidTitle'=>$upline[$p1yyyymm]['PaidTitle'],
      'PPV'=>$upline[$p1yyyymm]['PV'],
      'PV'=>$upline[$p0yyyymm]['PV'],
      'Mobile'=>$UserMobile,
     ));
    }

  }
  
   $dataLists = array();
   foreach($lists as $l){
    array_push($dataLists,array(
     (string)$l['mcaNumber']=>(string)$l['list'].":".(string)$l['member']
     ));
   }
   
   
  if(count($user)==1){
   return $this->render(array('json' => array("success"=>"Yes","user"=>$user,"mobile"=>$mobile)));    
  }else{
   return $this->render(array('json' => array("success"=>"No")));    
  }
 }
 return $this->render(array('json' => array("success"=>"No")));    
}

public function sendotp(){
 if($this->request->data){
  
  $mcaNumber = $this->request->data['mcaNumber'];
  $date = date_create($this->request->data['dateofjoin']);
  
  $user = Users::find('first',array(
   'conditions'=>array(
    'mcaNumber'=>(string)$mcaNumber,
    'DateJoin'=>date_format($date,"d M Y"),
    )
  ));
  if(count($user)==1){
   $mobile = "+91".$this->request->data['mobile'];
   $ga = new GoogleAuthenticator();
   $otp = $ga->getCode($ga->createSecret(64)); 
   $data = array(
    'otp' => $otp,
    'mobile'=>$mobile,
   );
   $conditions = array("mcaNumber"=>(string)$mcaNumber);

   Users::update($data,$conditions);
   $function = new Functions();
   $msg = "SFF-Mall OTP is ". $otp . ",  to register.";
   $returncall = $function->twilio($mobile,$msg,$otp);  // Testing if it works 
   $returnsms = $function->sendSms($mobile,$msg);  // Testing if it works 
   $user = Users::find('first',array(
   'conditions'=>array(
    'mcaNumber'=>(string)$mcaNumber,
    )
   ));
 
   return $this->render(array('json' => array("success"=>"Yes","otp"=>$otp,'user'=>$user)));  
  }else{
   return $this->render(array('json' => array("success"=>"No")));  
  }
  
 }
 return $this->render(array('json' => array("success"=>"No")));  
} 

 public function dashboard($mcaNumber = null){
  $user = Users::find('first',array(
   'conditions'=>array(
    'mcaNumber'=>(string)$mcaNumber,
    )
  ));  
  return compact('user');
 
 }

















}

