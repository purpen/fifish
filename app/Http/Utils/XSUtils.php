<?php
    
namespace App\Http\Utils;

use Config;

class XSUtil
{

	/**
	 * 验证索引索引服务器是否启动
	 */
    public static function checkStat()
    {
        return "abc";
	}

    /**
     * 添加文档
     */
    public static function add($data=array())
    {
        $db = Config::get('xunSearch.name');
        try{
            $xs = new \XS($db);
            $index = $xs->index; // 获取 索引对象
            // 创建文档对象
            $doc = new XSDocument;
            $doc->setFields($data);

            // 添加到索引数据库中
            $index->add($doc);

        }catch(XSException $e){
            //Doggy_Log_Helper::warn('add:'.$e->getTraceAsString(), 'search');
        }

    }

  /**
   * 更新文档
   */
    public static function update($data=array())
    {
        $db = Config::get('xunSearch.name');
        try{
            $xs = new \XS($db);
            $index = $xs->index; // 获取 索引对象
            // 创建文档对象
            $doc = new XSDocument;
            $doc->setFields($data);

            // 更新到索引数据库中
            $ok = $index->update($doc);
            if($ok){
                return array('success'=>true, 'msg'=>'操作成功!');
            }else{
                return array('success'=>false, 'msg'=>'操作失败!');   
            }
        }catch(XSException $e){
            //Doggy_Log_Helper::warn('update:'.$e->getTraceAsString(), 'search');
            return array('success'=>false, 'msg'=>'操作失败: '.$e->getTraceAsString());
        }

    }

    /**
     * 删除文档
     * ID可为数组
    */
    public static function del_ids($ids, $db='phenix')
    {
        $db = Config::get('xunSearch.name');
        try{
            $xs = new \XS($db);
            $index = $xs->index; // 获取 索引对象
       
            // 删除
            $ok = $index->del($ids);
            if($ok){
                return array('success'=>true, 'msg'=>'操作成功!');
            }else{
                return array('success'=>false, 'msg'=>'删除失败!');       
            }

        }catch(XSException $e){
            //Doggy_Log_Helper::warn('delete:'.$e->getTraceAsString(), 'search');
            return array('success'=>false, 'msg'=>'删除失败!'.$e->getTraceAsString());    
        }

    }

    /**
     * 搜索
    */
    public static function search($str, $options=array())
    {
        $db = Config::get('xunSearch.name');
        if(empty($str)){
            return array('success'=>false, 'msg'=>'搜索内容为空!');
        }

        $page = isset($options['page'])?(int)$options['page']:1;
        $size = isset($options['size'])?(int)$options['size']:8;
        $sort = isset($options['sort'])?(int)$options['sort']:0;
        $asc = isset($options['asc'])?(boolean)$options['asc']:false;

        $evt = isset($options['evt'])?(string)$options['evt']:'content';
        $cid = isset($options['cid'])?(string)$options['cid']:0;
        $tid = isset($options['tid'])?(string)$options['tid']:null;
        $type = isset($options['type'])?(int)$options['type']:0;
        $ingore_id = isset($options['ingore_id'])?(int)$options['ingore_id']:0;

        // 过滤xss攻击
        if($evt=='content'){
            $str = self::remove_xss($str);
        }
        $str_f = $str;

        try{
            $xs = new \XS($db); // 建立 XS 对象，项目名称为：demo
            $search = $xs->search; // 获取 搜索对象
            $condition = '';
            //类型
            switch($type){
            case 1:
                if(!empty($tid)){
                    $condition .= sprintf('kind:Stuff tid:%s ', $tid);
                }else{
                    $condition .= 'kind:Stuff ';
                }
                $str_f = sprintf('%s%s', $condition, $str);
                break;
            case 2:
                $condition .= 'kind:User ';
                $str_f = sprintf('%s%s', $condition, $str);
                break;
            }


            //用于相关搜索,过滤当前结果
            if($ingore_id){
                $condition .= sprintf("-oid:%s ", $ingore_id);
            }

            //是否搜索标签
            if($evt=='tag'){
                $tag_arr = explode(',', $str);
                $x_tag_arr = array();
                foreach($tag_arr as $v){
                    array_push($x_tag_arr, sprintf("tags:%s", $v));
                }
                $x_tag_str = implode(' OR ', $x_tag_arr);
                $str_f = sprintf('%s(%s)', $condition, $x_tag_str);
            }else{
                $search->addWeight('title', $str); // 增加附加条件：提升标题中包含 关键字 的记录的权重       
            }

            $search->setQuery($str_f); // 设置搜索语句

            //排序
            if(!empty($sort)){
                if($sort==1){
                    $search->setSort('created_on', $asc); // 最新
                }elseif($sort==2){
                    $search->setSort('updated_on', $asc); // 更新
                }
            }

            $current_per = ($page-1)*$size;
            $search->setLimit($size, $current_per); // 设置返回结果最多为 5 条，并跳过前 10 条
   
            $docs = $search->search(); // 执行搜索，将搜索结果文档保存在 $docs 数组中
            $count = $search->count(); // 获取搜索结果的匹配总数估算值 /放在search()之后,优化查询
            //页码数
            $total_page = ceil($count/$size);
            $data = array();

            foreach($docs as $k=>$v){
                $data[$k]['pid'] = $v['pid'];
                $data[$k]['oid'] = $v['oid'];
                $data[$k]['tid'] = $v['tid'];
                $data[$k]['cid'] = $v['cid'];
                $data[$k]['kind'] = $v['kind'];
                $data[$k]['title'] = $v['title'];
                $data[$k]['cover_id'] = $v['cover_id'];
                $data[$k]['content'] = $v['content'];
                $data[$k]['user_id'] = $v['user_id'];
                $data[$k]['tags'] = !empty($v['tags'])?explode(',', $v['tags']):array();
                $data[$k]['created_on'] = $v['created_on'];
                $data[$k]['updated_on'] = $v['updated_on'];
                $data[$k]['high_title'] = $search->highlight($v->title); // 高亮处理 title 字段
                $data[$k]['high_content'] = htmlspecialchars_decode($search->highlight($v->content)); // 高亮处理 content 字段
            }

            $result = array('success'=>true, 'data'=>$data, 'total_count'=>$count, 'total_page'=>$total_page, 'msg'=>'success');
            return $result;
        }catch(XSException $e){
            //Doggy_Log_Helper::warn('search:'.$e->getTraceAsString(), 'search');
            return array('success'=>false, 'msg'=>'搜索异常!');
        }
    }

    /**
    * 搜索建议
    */
    public static function expanded($q, $limit=10)
    {
        if(empty($q)){
            return array('success'=>false, 'msg'=>'搜索内容为空!');       
        }

        $q = self::remove_xss($q);

        $db = Config::get('xunSearch.name');
        try{
            $xs = new \XS($db);
            $search = $xs->search; // 获取 搜索对象

            // 查询
            $doc = $search->getExpandedQuery($q, $limit);
            $result = array('success'=>true, 'data'=>array('swords'=>$doc), 'total_count'=>$limit, 'total_page'=>1, 'msg'=>'success'); 

            return $result;

        }catch(XSException $e){
            //Doggy_Log_Helper::warn('delete:'.$e->getTraceAsString(), 'search');
            return array('success'=>false, 'msg'=>'查询失败!'.$e->getTraceAsString());
        }

    }


    /**
     * @from Think php extend.php
     * 过滤xss攻击
     * @param str $val
     * @return mixed
    */
    public static function remove_xss($val)
    {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
          // ;? matches the ;, which is optional
          // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

          // @ @ search for the hex values
          $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
          // @ @ 0{0,7} matches '0' zero to seven times
          $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
        }

        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script',
                      'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
                 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 
                 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
                 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend',
                 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange',
                 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
                 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
                 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange','onreadystatechange',
                 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 
                 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
          $val_before = $val;
          for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
              if ($j > 0) {
                $pattern .= '(';
                $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                $pattern .= '|';
                $pattern .= '|(&#0{0,8}([9|10|13]);)';
                $pattern .= ')*';
              }
              $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
              // no replacements were made, so exit the loop
              $found = false;
            }
          }
        }
        return $val;
    }


    
}
