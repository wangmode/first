<?php
// +----------------------------------------------------------------------
// | (ajax 联动)
// +----------------------------------------------------------------------
// | ThinkOAO （Online And Offline）
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.thinkoao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaogg <xiaogg@sina.cn>
// +----------------------------------------------------------------------
namespace Home\Controller;
class AjaxController extends BaseController{
    public function index(){exit;}
 	//联动地区
	public function linkarea(){
    	$pid=intval(I('get.parent_id'));
    	$gettype=I('get.data_type');
    	$data_type = "json";if(empty($pid))return false;
    	if(!empty($gettype)){$data_type = $gettype;}
        $cachename="linkarea".$pid.$data_type;
		echo 111;exit;
        $cachecontent=S($cachename);
        if($cachecontent){echo $cachecontent;exit;}
		$liandong=getcache('Area');
    	if($data_type == "json"){
    		$json_str = "[";$json = array();
    		foreach($liandong as $row){
    			if($row['pid']!=$pid)continue;
    			$r = array('region_id' => $row['id'],'region_name' => $row['name']);
    			$json[] = json_encode($r);
    		}
    		$json_str .= implode(',',$json);
    		$json_str .= "]";
    		echo $json_str;	S($cachename,$json_str);
    	}else if($data_type == "xml"){
    		header("Content-type: text/xml;");
    		$xml = "<?xml version='1.0' encoding='UTF-8'?>";
    		$xml .= "<root>";
    		foreach($liandong as $row){
    			if($row['pid']!=$pid)continue;
    			$xml .= "<record>";
    				$xml .= "<region_id>".$row['id']."</region_id>";
    				$xml .= "<region_name>".$row['name']."</region_name>";
    			$xml .= "</record>";
    		}$xml .="</root>";
    		echo $xml;S($cachename,$xml);
    	}
	}
    //检查用户是否符合绑定托管平台的条件
    public function check_user_info(){
		$user_id = $this->member_info['id'];
        $backdata['status']=0;        
		$user_type =I('user_type','','intval');
        if(empty($this->JK_ESCROW)){            
            $backdata['info']='系统没有开启托管平台!';
		    $this->ajaxReturn($backdata);
        }
		if($user_id == 0){
            $backdata['info']='请先登录';
		    $this->ajaxReturn($backdata);
		}
        $data = array();
		if (empty($user_type)){
			$data =idtoname($user_id,'Member','id,idcode,real_name,mobile,email','id',false);
		}else{
			$data =idtoname($user_id,'Shops','id,idcode,platfromid,real_name,mobile,email','id',false);
            $user_escrow['platfromid']=$data['platfromid'];
		}	
		$err_msg = "";
		if (empty($data)){
            $backdata['info']='用户不存在';
		    $this->ajaxReturn($backdata);
		}else{
                $escrow_minfowhere['status']=1;
                $escrow_minfowhere['escrow_code']=$this->JK_ESCROW_TYPE;
                $escrow_minfowhere['username']=$this->member_info['username'];
                if(empty($user_escrow['platfromid']))$user_escrow=M('EscrowMember')->where($escrow_minfowhere)->field('platfromid')->find();
    			if (empty($user_escrow['platfromid'])){	
    			     $bc_url='<a href="'.U("Member/Member/index").'">去补充</a><br>';
    				if (empty($data['idcode'])){
    					$err_msg .='身份证号码不能为空&nbsp;'.$bc_url;
    				}else if (empty($data['real_name'])){
    					$err_msg .='真实姓名不能为空&nbsp;'.$bc_url;
    				}else if (empty($data['mobile'])){
    					$err_msg .='手机号码不能为空&nbsp;'.$bc_url;
    				}else if (empty($data['email'])){
    					$err_msg .='邮箱不能为空&nbsp;'.$bc_url;
    				}		
    			}else{
    				$err_msg .='该用户已经申请过资金托管帐户:'.$user_escrow['platfromid'];
    			}
		}
		if(!empty($err_msg)){
            $backdata['info']=$err_msg;
		    $this->ajaxReturn($backdata);
		}else{
            $backdata['status']=1;
		    $backdata['info']='验证成功';
		    $backdata['jump']=U("Home/Escrow/register");
		    $this->ajaxReturn($backdata);
		}
	}
    //发送验证短信
    public function sendsms(){
        $backdata['status']=0;
		$mobile=I('post.mobile');
        if(empty($mobile) || !is_numeric($mobile)){
            $backdata['msg']='手机号不能为空或不正确';
            $this->ajaxReturn($backdata);
        }
        if(C('SMS_REG_VERIFY') && empty($this->member_info)){     
		    $regverify=I('post.regverify');
            if(empty($regverify)){
                $backdata['msg']='验证码不能为空';
                $this->ajaxReturn($backdata);
            }
            if(!check_verify($regverify, 'Member')){//验证验证码
    			$backdata['msg']='验证码错误';
                $this->ajaxReturn($backdata);
    		}
        }
        $data['to']=$mobile;
        $data['verify_code']=$data['code']=randStr(4,'0123456789');
        $result=sendbytheme($data,'SMS_USER_VERIFY');
        if($result=='发送成功'){$backdata['status']=1;}else{$backdata['status']=0;}
        $backdata['msg']=$result;
        $this->ajaxReturn($backdata);
   }
   public function sendsms_email(){
        $backdata['status']=0;
		$email=I('post.email');
        if(empty($email)){
            $backdata['msg']='邮箱不能为空';
            $this->ajaxReturn($backdata);
        }
        $data['to']=$email;
        $data['verify_code']=$data['code']=randStr(4,'0123456789');
        $result=sendbytheme($data,'EMAIL_USER_EMAIL');
        if($result=='发送成功'){$backdata['status']=1;}else{$backdata['status']=0;}
        $backdata['msg']=$result;
        $this->ajaxReturn($backdata);
   }
   public function autorepay(){//自动还款
        if($this->JK_ESCROW_TYPE!='Ips')return false;
        $map['m.escrow_code']='Ips';
        $map['m.authopen']=array('neq','');
        $map['br.repay_time']=strtotime(date('Y-m-d'));
        $map['br.is_repay']=0;
        $map['br.autotime']=0;
        $autorepay=M('EscrowMember')->alias('m')->join('__BORROW_REPAY__ br on br.uid=m.uid')->field('br.*,m.authopen')->where($map)->find();
        //print_r($autorepay['borrow_id']);exit;
        if($autorepay['borrow_id']){
        //开始自动还款
        $info=D('Common/Borrow')->get_borrow_show($autorepay['borrow_id'],false);
        $tender_list = D('Common/BorrowTenderBack')->get_user_tender_list($info, 0 , $autorepay['sort'] , -1 , 0 , 1,1);
        //print_r($tender_list);exit;
        $data=idtoname($autorepay['uid'],'Member','*');
        M('BorrowRepay')->where('id='.$autorepay['id'])->save(array('autotime'=>NOW_TIME));
        $data['borrow_info']=$info;
        $data['tender_list']=$tender_list['item'];
        $data['borrow_repay_id']=$autorepay['id'];
        $data['authno']=$autorepay['authopen'];
        $escrow = new \Common\Vendor\Escrow;
        $escrow->dorepay($data);}
   }
   public function msg_sender(){//自动发送列表消息
        $map['is_send']=$map['is_success']=0;$mod=M('SmsLogs');
        $lists=$mod->where($map)->field('id,to,from,send_type,content,uid,title')->limit(5)->order('id')->select();
        foreach($lists as $v){
            $where=array();
            $where['id']=$v['id'];
            if($v['send_type']==1){
                $sendresult=dosendemail($v['to'],$v['from'],$v['title'], $v['content']);
                if($sendresult){
                    $data['is_success']='1';
                    $data['result']='发送成功';
                }else{
                    $data['is_success']='0';
                    $data['result']=$mail->ErrorInfo;
                }
            }else{
                $sendresult=dosendsms($v['to'],$v['title']);
                $data['is_success']=$sendresult['status'];
                $data['result']=$sendresult['msg'];
            }
            $data['is_send']=1;
            $data['sendtime']=NOW_TIME;
            $mod->where($where)->save($data);
        }
   }
}
?>