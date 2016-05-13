<?php 
// +----------------------------------------------------------------------
// | ThinkOAO （Online And Offline）
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.thinkoao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaogg <xiaogg@sina.cn>
// +----------------------------------------------------------------------
namespace Common\TagLib;
use Think\Template\TagLib;
/**
 * Oao标签库驱动
 */
class TagLibarea extends TagLib{
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'loadcssjs'=>array('attr'=>'css,js,type,id,datatype','close'=>0),
        'text'      => array('attr'=>'id,name,type,style,class,other,datatype,nullmsg,errormsg,tip,placeholder','close'=>1),
		'area'=>array('attr'=>'id,name,title,notitle,class,width,level','close'=>1),
        'linkage'=>array('attr'=>'id,name,title,infotitle,width,level,multiple','close'=>1),
        'editor'    => array('attr'=>'id,name,style,width,height,type,mini,manage,datatype','close'=>1),
        'select'    => array('attr'=>'name,options,class,values,output,multiple,id,size,first,change,default,selected,dblclick','close'=>0),
        'upimage'   => array('attr'=>'id,name,datatype,text,style,class,manage','close'=>1),//单图片上传
        'upfile'    => array('attr'=>'id,name,datatype,text,style,class,manage','close'=>1),//单文件上传	
        'pictures'  => array('attr'=>'id,name,text,style,class','close'=>1),//多图片上传
     	'calendar'  => array('attr'=>'id,name,ifformat,size','close'=>1),
        'checkbox'  => array('attr'=>'id,name,checkboxes,default,checked,separator,datatype,errormsg,arr','close'=>0),
        'radio'     => array('attr'=>'id,name,radios,checked,default,separator,datatype,errormsg','close'=>0),
        'checkboxphp'  => array('attr'=>'id,name,checkboxes,default,checked,separator,datatype,errormsg,arr','close'=>0),
        'radiophp'     => array('attr'=>'id,name,radios,checked,default,separator,datatype,errormsg','close'=>0),
        'datalist'  =>  array('attr'=>'name,field,limit,order,where,table,join,having,group,id,key,mod,gc,page,pagesize,sql','level'=>3)
     );
     public function _loadcssjs($tag)
	 {
        $typearr=array();
        if(!empty($tag['css']))$css[]=	$tag['css'];
        if(!empty($tag['js']))$js[]	=	$tag['js'];
        $type=!empty($tag['type'])?$tag['type']:'all';
        $id= !empty($tag['id'])?$tag['id']:'myform';
        $datatype= !empty($tag['datatype'])?"<?php echo ".$tag['datatype']."?>":'';
        $typearr=explode(",",$type);$cssjs='';
        if(in_array('editor',$typearr) || $type=='all')$css[]=__ROOT__."/Public/script/kindeditor/themes/default/default.css";
        if(in_array('calendar',$typearr) || $type=='all')$cssjs.='<script type="text/javascript" src="'.__ROOT__.'/Public/script/MyDate/WdatePicker.js"></script>';//$js[]=__ROOT__."/Public/script/MyDate/WdatePicker.js";
        if(in_array('editor',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/kindeditor/lang/zh_CN.js";
        if(in_array('upimage',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/ToolTip.js";
        if(in_array('Validform',$typearr) || in_array('Validform_no',$typearr) || $type=='all')$css[]=__ROOT__."/Public/css/validform.css";
        if(in_array('Validform',$typearr) || in_array('Validform_no',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/jquery/Validform_v5.3.2_min.js"; 
        if(in_array('linkage',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/jquery/jquery.ld.js";
        if(in_array('placeholder',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/placeholder.js";
        if(in_array('jq_placeholder',$typearr) || $type=='all')$js[]=__ROOT__."/Public/script/jquery/jquery.JPlaceholder.js";
        
        if(!empty($css))$cssjs.='<link rel="stylesheet" type="text/css" href="'.min_css($css).'" />';
        if(in_array('editor',$typearr) || $type=='all')$cssjs.='<script type="text/javascript" src="__PUBLIC__/script/kindeditor/kindeditor.js"></script>';
        if(!empty($js))$cssjs.='<script type="text/javascript" src="'.min_js($js).'"></script>';
        if(in_array('Validform',$typearr) || $type=='all')$cssjs.='<script type="text/javascript">$(function(){$("#'.$id.'").Validform({tiptype:2'.$datatype.'});})</script>';
        return $cssjs;
	}

    /**
     * area 地区标签
     * 格式： <oao:area name="area">{$content}</oao:area>
     */
	public function _area($tag,$content)
	{	
        $name   	=!empty($tag['name'])?$tag['name']:'area';
		$id			=!empty($tag['id'])?$tag['id']:'area';
        $level   	=!empty($tag['level'])?$tag['level']:'';
		$width		=!empty($tag['width'])?$tag['width']:'75';
		$title      =!empty($tag['title'])?$tag['title']:'请选择';
        $class      =!empty($tag['class'])?$tag['class']:'form-control selinkagea';
		$notitle    =!empty($tag['notitle'])?$tag['notitle']:'';		
		$ldclass=$id.'_area';$str='';
		if(!$notitle){$infotitle=array("省","市","县");
			foreach($infotitle as $k =>$tv){$t[($k+1)]=$title.$tv;}
		}
        if(str_exists($name,'|')){
            $idarr=$namearr=explode('|','|'.$name);
        }else{
		$nameid=array('sheng','shi','xian');
		foreach($nameid as $k => $v)
		{
			$namearr[($k+1)]=$name."_".$v;
			$idarr[($k+1)]=$id."_".$v;
		}}
		$str .="<script type=\"text/javascript\">";
		$str .="$(function(){"."$(\".".$ldclass."\").ld({ajaxOptions: {\"url\":\"".U('Home/Ajax/linkarea')."\"},\"defaultParentId\" : 1,";
		if($content){$str .="texts : [".$content."],";}
		$str .="style:{\"width\" : ".$width."}});})";
	    $str .="</script>";
		 for($i=1; $i<=3;$i++){
			 if($i<=$level || !$level){
				$str .="<select class=\"".$ldclass." ".$class."\" name=\"".$namearr[$i]."\" id=\"".$idarr[$i]."\">";
				$str .="<option value=\"\">".$t[$i]."</option>";
				$str .="</select>";
			}
		}
		return $str;		
	}
    /**
     * editor标签解析 插入可视化编辑器
     * 格式： <oao:editor id="editor" name="remark" type="KINDEDITOR" style="" >{$vo.remark}</oao:editor>
     */
    public function _editor($tag,$content) {
        $id			=	!empty($tag['id'])?$tag['id']: strtr($tag['name'],array('['=>'',']'=>'')).'_editor';
        $name   	=	!empty($tag['name'])?$tag['name']:'';
        $mini   	=	!empty($tag['mini'])?$tag['mini']:'';
        $manage   	=	!empty($tag['manage'])?$tag['manage']:'';
        $style      =	!empty($tag['style'])?$tag['style']:'';
        $datatype   =	!empty($tag['datatype'])?' datatype="'.$tag['datatype'].'"':'';
        $width		=	!empty($tag['width'])?$tag['width']: '100%';
        $height     =	!empty($tag['height'])?$tag['height'] :'320px';
        $type       =   !empty($tag['type'])?$tag['type']:'KINDEDITOR' ;
        if(($manage || C('UPLOAD_FILEMANAGE')) && $manage!='false')$filemanage="allowFileManager : true,";else $filemanage='';
        switch(strtoupper($type)) {
            case 'KINDEDITOR':
                $parseStr='<script> var editor; KindEditor.ready(function(K) { editor = K.create(\'#'.$id.'\', {'.$filemanage;
				if($mini)$parseStr.="items : ['source','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'link']";
				$parseStr.='});});</script><textarea id="'.$id.'" style="'.$style.'" name="'.$name.'" >'.$content.'</textarea>';
                 break;
            default :
                $parseStr  =  '<textarea id="'.$id.'" class="form-control" style="'.$style.'" name="'.$name.'" '.$datatype.'>'.$content.'</textarea>';
        }

        return $parseStr;
    }
/**  +----------------------------------------------------------
     * calendar标签解析 插入可视化日期调用
     * 格式： 同一个页面第一次调用<oao:calendar name="star_time">{$value}</oao:calendar>
*/
     public function _calendar($tag,$content){
        $name   	=	!empty($tag['name'])?$tag['name']:'';
		$id			=	!empty($tag['id'])?$tag['id']: $tag['name'];
		$class		=	!empty($tag['class'])?$tag['class']:'Wdate form-control';
		$size		=	!empty($tag['size'])?$tag['size']:'20';        
        $style   	=	!empty($tag['style'])?" style='".$tag['style']."'":'';
		$ifformat	=	!empty($tag['ifformat'])?$tag['ifformat']:'yyyy-MM-dd';		
		$parseStr='<input class="'.$class.'" name="'.$name.'" type="text" id="'.$id.'" size="'.$size.'" onFocus="WdatePicker({dateFmt:\''.$ifformat.'\'})" value="'.$content.'" '.$style.'/>';
        return $parseStr;
        }
 
    /** 多图片上传 利用KindEditor实现图片上传
    */
    public function _pictures($tag,$content)
    {
        $name=	!empty($tag['name'])?$tag['name']:'';
        $id			=	!empty($tag['id'])?$tag['id']: strtr($name,array('['=>'',']'=>''));
        $text   	=	!empty($tag['text'])?$tag['text']:'批量上传';
        $style   	=	!empty($tag['style'])?'style="'.$tag['style'].'"':'';
        $class      = !empty($tag['class'])?$tag['class']:'form-control f_l';
        $button     =strtr($tag['name'],array('['=>'',']'=>''));
       $parseStr='<script>var nowval=newval="";
			KindEditor.ready(function(K) { var editor = K.editor();
            K("#'.$button.'_button").click(function() { editor.loadPlugin("multiimage", function() { editor.plugin.multiImageDialog({ clickFn : function(urlList) { var div = K("#'.$button.'_View");								
			K.each(urlList, function(i, data) { nowval=$("#'.$id.'").val();
             if(!nowval || nowval=="undefined"){ newval=data.url;}else{ newval=nowval+","+data.url;}$("#'.$id.'").val(newval);
             div.append("<img src=\'" + data.url + "\' style=\"max-height:90px;max-width:90px;margin-right:3px\"  align=\"left\">");});editor.hideDialog();}
			});});});});
		</script><input type="text" id="'.$id.'" name="'.$name.'" '.$style.' class="'.$class.'" value="'.$content.'"/> 
		<input type="button" id="'.$button.'_button" class="btn btn-default" value="'.$text.'" />
		<div id="'.$button.'_View">'.str_replace("}","|strimages}",$content).'</div>';
        return $parseStr;
    }
    /** 图片上传 利用KindEditor实现图片上传
    */
    public function _upimage($tag,$content)
    {//echo $content;
        $name   	=	!empty($tag['name'])?$tag['name']:'';
        $id			=	!empty($tag['id'])?$tag['id']: strtr($name,array('['=>'',']'=>'')).'_id';
        $manage   	=	!empty($tag['manage'])?$tag['manage']:'';
        $text   	=	!empty($tag['text'])?$tag['text']:'选择图片';
        $button   	=	strtr($name,array('['=>'',']'=>''))."_button";
        $style   	=	!empty($tag['style'])?$tag['style']:'';
        $datatype   =	!empty($tag['datatype'])?' datatype="'.$tag['datatype'].'"':'';
        $class      = !empty($tag['class'])?$tag['class']:'form-control f_l';
        if(($manage || C('UPLOAD_FILEMANAGE')) && $manage!='false')$filemanage="allowFileManager : true";else $filemanage='';
       $parseStr='<script>KindEditor.ready(function(K) {var editor = K.editor({'.$filemanage.'});K("#'.$button.'").click(function() {editor.loadPlugin("image", function() {editor.plugin.imageDialog({imageUrl : K("#'.$id.'").val(),clickFn : function(url, title, width, height, border, align) {K("#'.$id.'").val(url);editor.hideDialog();}});});});});</script><input type="text" id="'.$id.'" name="'.$name.'" style="'.$style.'"'.$datatype.' class="'.$class.'" value="'.$content.'" onMouseOver="toolTip(\'<img src=\'+this.value+\'>\',this.value)" onMouseOut="toolTip(\'\',1)"/> <input class="btn btn-default ml10" type="button" id="'.$button.'" value="'.$text.'" />';
       $imgname=$this->getvarname($content);if($imgname){
       $parseStr.='<?php if('.$imgname.'){?>';
       $parseStr.=' <a href="<?php echo '.$imgname.';?>" target="_bank"><img src="<?php echo '.$imgname.';?>" height="34px"></a>';       
       $parseStr.='<?php }?>';}
        return $parseStr;
    }
    /** 文件上传 利用KindEditor实现文件上传
    */
	public function _upfile($tag,$content)
    {
        $name   	=	!empty($tag['name'])?$tag['name']:'';
        $id			=	!empty($tag['id'])?$tag['id']: strtr($name,array('['=>'',']'=>'')).'_fileid';
        $manage   	=	!empty($tag['manage'])?$tag['manage']:'';
        $text   	=	!empty($tag['text'])?$tag['text']:'选择文件';
        $button   	=	strtr($name,array('['=>'',']'=>''))."_filebutton";
        $style   	=	!empty($tag['style'])?$tag['style']:'';
        $datatype   =	!empty($tag['datatype'])?' datatype="'.$tag['datatype'].'"':'';
        $class      = !empty($tag['class'])?$tag['class']:'form-control f_l';
        if(($manage || C('UPLOAD_FILEMANAGE')) && $manage!='false')$filemanage="allowFileManager : true";else $filemanage='';
       $parseStr='<script>KindEditor.ready(function(K){var editor = K.editor({'.$filemanage.'});K("#'.$button.'").click(function() {editor.loadPlugin("insertfile", function() {editor.plugin.fileDialog({fileUrl : K("#'.$id.'").val(),clickFn : function(url, title) {K("#'.$id.'").val(url);editor.hideDialog();}});});});});</script>
       <input type="text" id="'.$id.'" name="'.$name.'" style="'.$style.'"'.$datatype.' class="'.$class.'" value="'.$content.'" /> <input type="button" class="btn btn-default ml10" id="'.$button.'" value="'.$text.'" />';
        
       $filename=$this->getvarname($content);if($filename){
       $parseStr.='<?php if('.$filename.'){?>';
       $parseStr.=' <a href="<?php echo '.$filename.';?>" target="_bank">下载</a>';
       $parseStr.='<?php }?>';}
        return $parseStr;
    }
    private function getvarname($name){
         $filename=strtr($name,array('{'=>'','}'=>''));
         if(str_exists($filename,'.')){
            $vars=explode('.',$filename);
            $filename = '';
            foreach ($vars as $key=>$val)$filename .=$key==0?$val: '["'.$val.'"]';
        }
        return $filename;
    }
    /**
     * select标签解析
     * 格式： <oao:select options="name" selected="value" />
     */
    public function _select($tag) {
        $name       = $tag['name'];
        $class      = !empty($tag['class'])?$tag['class']:'form-control';
        $options    = !empty($tag['options'])?$tag['options']:'';
        $values     = !empty($tag['values'])?$tag['values']:'';
        $output     = !empty($tag['output'])?$tag['output']:'';
        $multiple   = !empty($tag['multiple'])?$tag['multiple']:'';
        $id         = !empty($tag['id'])?$tag['id']:$name;
        $size       = !empty($tag['size'])?$tag['size']:'';
        $first      = !empty($tag['first'])?$tag['first']:'';
        $selected   = !empty($tag['selected'])?$tag['selected']:'';
        $style      = !empty($tag['style'])?$tag['style']:'';
        $ondblclick = !empty($tag['dblclick'])?$tag['dblclick']:'';
		$onchange	= !empty($tag['change'])?$tag['change']:'';
        $parseStr = '<select id="'.$id.'" class="'.$class.'" name="'.$name.'" ';
        if(!empty($multiple)) $parseStr .=' multiple="multiple"';
        if(!empty($ondblclick)) $parseStr .=' ondblclick="'.$ondblclick.'"';
        if(!empty($onchange)) $parseStr .=' onchange="'.$onchange.'"';
        if(!empty($size)) $parseStr .=' size="'.$size.'"';
        if(!empty($style)) $parseStr .=' style="'.$style.'"';
        $parseStr .='>';
        if(!empty($first)) {$parseStr .= '<option value="" >'.$first.'</option>';}
        if(str_exists($options,'typeid_')) {
            $options=strtoarray($tag['options']);
            $selected=$this->tpl->get($selected);
            if(!$selected && !empty($tag['default']))$selected=$tag['default'];else $tag['default']='NULL-';
            foreach($options as $k =>$v){
                $parseStr.= '<option value="'.$k.'" ';
                if(!empty($tag['selected']))$parseStr.= '<?php if('.$k.'==$'.$tag['selected'].' || \''.$k.'\'==\''.$tag['default'].'\'){echo \'selected="selected"\';}?>';
                $parseStr.= '>'.$v.'</option>';
            }
        }else if(!empty($options)){
            $parseStr   .= '<?php if(!empty($'.$options.')){foreach($'.$options.' as $key=>$val) { ?>';
            if(!empty($selected)) {
                $parseStr   .= '<?php $'.$selected.'arr=remove_empty_array($'.$selected.');if(in_array($key,$'.$selected.'arr)) { ?>';
                $parseStr   .= '<option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option>';
                if(empty($tag['default'])){
                    $parseStr   .='<?php }elseif($key=="'.$tag['default'].'") { ?><option value="<?php echo $key ?>"><?php echo $val ?></option>';
                }
                $parseStr   .= '<?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option>';
                $parseStr   .= '<?php } ?>';
            }else {$parseStr.=   !empty($tag['default'])?'<option value="<?php echo $key ?>" <?php if($key==\''.$tag['default'].'\'){echo " selected=\"selected\"";}?>><?php echo $val ?></option>': '<option value="<?php echo $key ?>"><?php echo $val ?></option>';}
            $parseStr   .= '<?php }} ?>';
        }else if(!empty($values)) {
            $parseStr   .= '<?php  for($i=0;$i<count($'.$values.');$i++) { ?>';
            if(!empty($selected)) {
                $parseStr   .= '<?php $'.$selected.'arr=remove_empty_array($'.$selected.');if(in_array($'.$values.'[$i],$'.$selected.'arr)){ ?>';
                $parseStr   .= '<option selected="selected" value="<?php echo $'.$values.'[$i] ?>"><?php echo $'.$output.'[$i] ?></option>';
                if(empty($tag['default'])){
                    $parseStr   .='<?php }elseif($'.$values.'[$i]=="'.$tag['default'].'") { ?><option selected="selected" value="<?php echo $'.$values.'[$i] ?>"><?php echo $'.$output.'[$i] ?></option>';
                }
                $parseStr   .= '<?php }else { ?><option value="<?php echo $'.$values.'[$i] ?>"><?php echo $'.$output.'[$i] ?></option>';
                $parseStr   .= '<?php } ?>';
            }else {$parseStr   .=!empty($tag['default'])?'<option value="<?php echo $'.$values.'[$i] ?>" <?php if($'.$values.'[$i]==\''.$tag['default'].'\'){echo " selected=\"selected\"";}?>><?php echo $'.$output.'[$i] ?></option>': '<option value="<?php echo $'.$values.'[$i] ?>"><?php echo $'.$output.'[$i] ?></option>';}
            $parseStr   .= '<?php } ?>';
        }$parseStr   .= '</select>';
        return $parseStr;
    }

    /**
     * checkbox标签解析
     * 格式： <oao:checkbox checkboxes="" checked="" />
     */
    public function _checkbox($tag) {
        $id       = !empty($tag['id'])?$tag['id']:'';
        $arr      = !empty($tag['arr'])?$tag['arr']:'';
        $name       = !empty($tag['arr'])?$tag['name']:$tag['name'].'[]';
        $checkboxes = !empty($tag['checkboxes'])?$tag['checkboxes']:'';
        $checked    = !empty($tag['checked'])?$tag['checked']:'';
        $separator  = !empty($tag['separator'])?$tag['separator']:' ';        
        $datatype    = !empty($tag['datatype'])?$tag['datatype']:'';
        $errormsg    = !empty($tag['errormsg'])?$tag['errormsg']:'';
        $default    = !empty($tag['default'])?$tag['default']:'';
	
        $checkboxes = $this->tpl->get($checkboxes);
        if(empty($checkboxes) && $tag['checkboxes'])$checkboxes=strtoarray($tag['checkboxes']);
        $parseStr   = '';
        if(is_numeric($checked)){$checked='checkbox_checked_'.$name;$parseStr.="<?php $".$checked."='".$tag['checked']."';?>";}
        if(is_numeric($default)){$default='checkbox_default_'.$name;$parseStr.="<?php $".$default."='".$tag['default']."';?>";}
        $i=0;if($checkboxes){
        foreach($checkboxes as $key=>$val) {
            $parseStr .= '<input type="checkbox" class="form-control-no" value="'.$key.'" name="'.$name.'"';
            if($id)$parseStr .=' id="'.$id.'"';
            if($datatype && $i==0)$parseStr .=' datatype="'.$datatype.'"';
            if($errormsg && $i==0)$parseStr .=' errormsg="'.$errormsg.'"';
            if($checked)$parseStr .= '<?php $'.$checked.'arr=remove_empty_array($'.$checked.');if(in_array(\''.$key.'\',$'.$checked.'arr)){echo " checked=\'checked\'";}?>';
            else if($default!='')$parseStr .= '<?php $'.$checked.'arr=remove_empty_array($'.$default.');if(in_array(\''.$key.'\',$'.$default.'arr)){echo " checked=\'checked\'";}?>';
            $parseStr .=">".$val.$separator;
            $i++;    
        }}
        return $parseStr;
    }
/**
     * checkbox标签解析
     * 格式： <oao:checkboxphp checkboxes="" checked="" />
     */
    public function _checkboxphp($tag) {
        $id       = !empty($tag['id'])?$tag['id']:'';
        $arr      = !empty($tag['arr'])?$tag['arr']:'';
        $name       = !empty($tag['arr'])?$tag['name']:$tag['name'].'[]';
        $checkboxes = !empty($tag['checkboxes'])?$tag['checkboxes']:'';
        $checked    = !empty($tag['checked'])?$tag['checked']:'';
        $separator  = !empty($tag['separator'])?$tag['separator']:' ';        
        $datatype    = !empty($tag['datatype'])?$tag['datatype']:'';
        $errormsg    = !empty($tag['errormsg'])?$tag['errormsg']:'';
        $default    = !empty($tag['default'])?$tag['default']:'';
        $parseStr  = '';
        $parseStr .= '<?php  $i=0;foreach($'.$checkboxes.' as $key=>$val) { ?>';            
        $parseStr .= '<input type="checkbox" name="'.$name.'" value="<?php echo $key;?>"';
        if($id)$parseStr .=' id="'.$id.'"';
        if($checked)$parseStr .= '<?php $'.$checked.'arr=remove_empty_array($'.$checked.');if(in_array($key,$'.$checked.'arr)){echo " checked=\'checked\'";}?>';
        else if($default!='')$parseStr .= '<?php $'.$checked.'arr=remove_empty_array($'.$default.');if(in_array($key,$'.$default.'arr)){echo " checked=\'checked\'";}?>';
        if($datatype)$parseStr .= '<?php if($i==0){echo " datatype=\''.$datatype.'\'";}?>';
        if($errormsg)$parseStr .= '<?php if($i==0){echo " errormsg=\''.$errormsg.'\'";}?>';
        $parseStr .="><?php echo $"."val.$"."separator;?>";
        $parseStr .= '<?php ++$i;} ?>';
        return $parseStr;
    }
    /**
     * radio标签解析
     * 格式： <oao:radio radios="name" checked="value" />
     */
    public function _radio($tag) {
        $id       = !empty($tag['id'])?$tag['id']:'';
        $name       = !empty($tag['name'])?$tag['name']:'';
        $radios     = !empty($tag['radios'])?$tag['radios']:'';
        $checked    = !empty($tag['checked'])?$tag['checked']:'';
        $separator  = !empty($tag['separator'])?$tag['separator']:' ';     
        $datatype    = !empty($tag['datatype'])?$tag['datatype']:'';
        $errormsg    = !empty($tag['errormsg'])?$tag['errormsg']:'';
        $default    = !empty($tag['default'])?$tag['default']:'';
        $radios = $this->tpl->get($radios);
        if(empty($radios) && $tag['radios'])$radios=strtoarray($tag['radios']);
        $parseStr   = '';$i=0;
        foreach($radios as $key=>$val) {
            $parseStr .= '<input type="radio" name="'.$name.'" value="'.$key.'"';
            if($id)$parseStr .=' id="'.$id.'"';
            if($checked)$parseStr .= '<?php if(!isset($'.$checked.') && !is_numeric($'.$checked.'))$'.$checked.'=\''.$default.'\';if((!empty($'.$checked.') || is_numeric($'.$checked.')) && $'.$checked.'==\''.$key.'\'){echo " checked=\'checked\'";}?>';
            else if($default!='')$parseStr .= '<?php if("'.$default.'"== \''.$key.'\'){echo " checked=\'checked\'";}?>';
            if($datatype && $i==0)$parseStr .=' datatype="'.$datatype.'"';
            if($errormsg && $i==0)$parseStr .=' errormsg="'.$errormsg.'"';
            $parseStr .=">".$val.$separator;
            $i++;
        }
        return $parseStr;
    }
/**
     * radiophp标签解析
     * 格式： <oao:radiophp radios="name" checked="value" />
     */
    public function _radiophp($tag) {
       $id       = !empty($tag['id'])?$tag['id']:'';
        $name       = !empty($tag['name'])?$tag['name']:'';
        $radios     = !empty($tag['radios'])?$tag['radios']:'';
        $checked    = !empty($tag['checked'])?$tag['checked']:'';
        $separator  = !empty($tag['separator'])?$tag['separator']:' ';     
        $datatype    = !empty($tag['datatype'])?$tag['datatype']:'';
        $errormsg    = !empty($tag['errormsg'])?$tag['errormsg']:'';
        $default    = !empty($tag['default'])?$tag['default']:'';
        $parseStr  = '';
        $parseStr .= '<?php  $i=0;foreach($'.$radios.' as $key=>$val) { ?>';            
        $parseStr .= '<input type="radio" name="'.$name.'" value="<?php echo $'.'key;?>"';
        if($id)$parseStr .=' id="'.$id.'"';
        if($checked)$parseStr .= '<?php if(!isset($'.$checked.') && !is_numeric($'.$checked.'))$'.$checked.'=\''.$default.'\';if((!empty($'.$checked.') || is_numeric($'.$checked.')) && $'.$checked.'==$key){echo " checked=\'checked\'";}?>';
        else if($default!='')$parseStr .= '<?php if("'.$default.'"== $key){echo " checked=\'checked\'";}?>';
        if($datatype)$parseStr .= '<?php if($i==0){echo " datatype=\''.$datatype.'\'";}?>';
        if($errormsg)$parseStr .= '<?php if($i==0){echo " errormsg=\''.$errormsg.'\'";}?>';
        $parseStr .="><?php echo $"."val.$"."separator;?>";
        $parseStr .= '<?php ++$i;} ?>';
        return $parseStr;
    }/**
     * datalist获取列表数组
     * 格式：<oao:datalist name="name" where="1"></oao:datalist>
     */
    public function _datalist($tag,$content) {
        $name       =   !empty($tag['name'])?$tag['name']:'Borrow';
        $result     =   !empty($tag['id'])?$tag['id']:'vo';
        $key        =   !empty($tag['key'])?$tag['key']:'i';
        $mod        =   isset($tag['mod'])?$tag['mod']:'2';
        $sql        =   isset($tag['sql'])?str_replace('DB_PREFIX_',C('DB_PREFIX'),$tag['sql']):'';
        $pagesize   =   isset($tag['pagesize'])?$tag['pagesize']:C('LIST_ROWS') ;
        $parseStr   =   '<?php $m=M("'.$name.'");';

        if(!empty($sql)){
            if(!empty($tag['page'])){
                $parseStr  .= '$total= count($m->query("'.$sql.'"));';
                $parseStr  .= '$Page= new \Think\Page($total,'.$pagesize.');';
                $parseStr  .= '$_page= $Page->show();';
                $parseStr  .= '$sql="'.$sql.'";';
                $parseStr  .= '$sql.=" limit ".$Page->firstRow.",".$Page->listRows."";';
                $parseStr  .= '$_result=$m->query($sql);';
            }else{
                if(!empty($tag['limit']))$sql.=' limit '.$tag['limit'];
                $parseStr  .= '$_result=$m->query("'.$sql.'");';
            }
        }else{
            if(!empty($tag['where']))$tag['where']=$this->parseCondition($tag['where']);else $tag['where']='1';
            if(!empty($tag['page'])){
                $parseStr  .= '$total      = $m->where("'.$tag['where'].'")->count();';
                $parseStr  .= '$Page= new \Think\Page($total,'.$pagesize.');';
                $parseStr  .= '$_page= $Page->show();';}        
                $parseStr  .= '$_result = $m->alias("OAO__")';
            if(!empty($tag['table']))$parseStr .= '->table("'.$tag['table'].'")';
            if($tag['where']!=1)$parseStr .= '->where("'.$tag['where'].'")';
            if(!empty($tag['order']))$parseStr .= '->order("'.$tag['order'].'")';
            if(!empty($tag['join']))$parseStr .= '->join("'.$tag['join'].'")';
            if(!empty($tag['group']))$parseStr .= '->group("'.$tag['group'].'")';
            if(!empty($tag['having']))$parseStr .= '->having("'.$tag['having'].'")';
            if(!empty($tag['limit']) && empty($tag['page']))$parseStr .= '->limit("'.$tag['limit'].'")';
            if(!empty($tag['page']))$parseStr .= '->limit($Page->firstRow.",".$Page->listRows)';
            if(!empty($tag['field']))$parseStr .= '->field("'.$tag['field'].'")';else $parseStr .= '->field(true)';
            $parseStr .= '->select();';
        }
        $parseStr .= 'if($_result):$'.$key.'=0;foreach($_result as $key=>$'.$result.'): ';
        $parseStr .= '++$'.$key.';$mod = ($'.$key.' % '.$mod.' );?>'.$content;
        if(!empty($tag['gc']))$parseStr .= '<?php unset($'.$result.');?>';
        $parseStr .= '<?php endforeach; endif;?>';
        return $parseStr;
    }
}
?>