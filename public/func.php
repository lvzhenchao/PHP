<?php
	/*
	*自定义函数链接库
	*1、分页、搜索  pagesAndSearch()
	*2、图像上传
	*3、图像缩放
	*4、网站开关
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*/
	/*----------------------------------1、分页、搜索  pagesAndSearch() 开始------------------------------------------*/
	/*
	*函数用途：搜索、分页
	*@author：吴睿楠
	*@date：2016/7/27 12:04
	*
	*@param1 object 已连接数据库的对象
	*@param2 string 数据库中对应的表名
	*@param3 int    每一页显示的条目数
	*@param4 int    当前页码
	*@param5 string 搜索内容
	*@param6 string 搜索对应字段
	*@param7 string 排序条件
	*
	*
	*@return array  ['prevPage'] 上一页页码
	*			    ['nextPage'] 下一页页码
	*			    ['addUrl']   搜索的字符串段
	*			    ['iCount']   总条目数
	*			    ['maxPage']  最大页数
	*			    ['SQL']      遍历语句
	*/
	
	function pagesAndSearch($link,$table,$items=8,$nowPage=1,$searchContent='',$searchField='',$order){
		// 从多少条数据开始取值
		$startI = ($nowPage - 1) * $items;
		//组成限制语句
		$limit = "limit {$startI},{$items}";
		//搜索功能
		if(!empty($searchContent) && !empty($searchField)){
			$where = "where {$searchField} like '%{$searchContent}%'";
			$url = "&search={$searchContent}";
		}else{
			$where = '';
			$url = '';
		}
		//分页/搜索语句拼接
		$SQL =  "select * from {$table} {$where} order by {$order} {$limit}";
		//上一页设置
		if($nowPage > 1){
			$prevPage = $nowPage - 1;
		}else{
			$prevPage = 1;
		}
		//下一页设置
		$SQLC = "select count(*) as count from {$table} {$where}";
		$resultC = mysqli_query($link,$SQLC);
		$infoC = mysqli_fetch_assoc($resultC);
		$iCount = $infoC['count'];
		$maxPage = ceil($iCount / $items);
		if($nowPage >= $maxPage){
			$nextPage = $maxPage;
		}else{
			$nextPage = $nowPage + 1;
		}
		//                    上一页页码               下一页页码           搜索的字符串段       总条目数            最大页数           遍历语句   
		$return = array('prevPage' => $prevPage , 'nextPage' => $nextPage , 'addUrl' => $url , 'iCount' => $iCount , 'maxPage' => $maxPage , 'SQL' => $SQL);
		//返回结果数组
		return $return;
	}
	
	/*----------------------------------1、分页、搜索  pagesAndSearch() 结束------------------------------------------*/
	/*----------------------------------2、图像上传  pagesAndSearch() 开始------------------------------------------*/
	
	/*
	*函数用途：图像上传
	*@author：吴睿楠
	*@date：
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*           待添加图像缩放及水印功能！！！
	*
	*
	*/
	
	function myUplod($upFileName,$icoPath){
		//1.判断错误号
		switch($_FILES["{$upFileName}"]['error']){
			case 1:
			case 2:
			case 3:
			case 6:
			case 7:
				exit('系统错误');
			break;
			case 4:
				exit('文件未上传');
			break;
		}
		//2.判断文件mime类型
		$ftype = $_FILES["{$upFileName}"]['type'];
		$types = array('image/jpg','image/jpeg','image/png','image/gif');
		if(!in_array($ftype,$types)){
			exit('文件类型错误');
		}
		//3.判断文件后缀名
		$filehou = pathinfo($_FILES["{$upFileName}"]['name']);
		if(!array_key_exists('extension',$filehou)){
			exit('文件没有扩展名');
		}
		$fhous = array('jpg','png','gif','jpeg');
		if(!in_array($filehou['extension'],$fhous)){
			exit('文件扩展名错误');
		}
		//4.判断文件大小
		$msize = 1024*1024*5;
		$size = $_FILES["{$upFileName}"]['size'];
		if($size > $msize && $size <= 0){
			exit('文件过大或过小');
		}
		//5. 判断文件是否post上传
		if(is_uploaded_file($_FILES["{$upFileName}"]['tmp_name'])){
			$newName = md5(time()).'.'.$filehou['extension'];
			$newPath = $icoPath.'/'.$newName;
			move_uploaded_file($_FILES["{$upFileName}"]['tmp_name'],$newPath);
		}else{
			exit('玩玩？');
		}
		$return = array('uplodeImageName' => $newName , 'uplodeImagePath' => $newPath);
		//返回文件名
		return $return;
	}
	

	/*----------------------------------2、图像上传  pagesAndSearch() 结束------------------------------------------*/
	/*----------------------------------3、图像缩放  imageZoom() 开始------------------------------------------*/
	/*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*/
	function myImages($fileName,$nWidth,$nHeight){
        //1、获得具体要执行的函数名以及图片的一些信息
        $infos = getimagesize($fileName);
		var_dump($infos);
        //类型的数组
        $types = array('1'=>'gif','2'=>'jpeg','3'=>'png');

        $type = $types[$infos[2]];
		
        //要调用的创建的函数
        $create = 'imagecreatefrom'.$type;
        $outPut = 'image'.$type;

        //创建老图片资源
        $oImg = $create($fileName);

        //进行等比例缩放
        if($nWidth && ($infos[0] < $infos[1])){
            $nWidth = ($nHeight / $infos[1]) * $infos[0];
        }else{
            $nHeight = ($nWidth / $infos[0]) * $infos[1];
        }

        //创建新图片资源
        $nImg = imagecreatetruecolor($nWidth,$nHeight);
        //2、执行了缩放的函数
        imagecopyresampled($nImg,$oImg,0,0,0,0,$nWidth,$nHeight,$infos[0],$infos[1]);

        //3、将要保存的文件名进行处理
        //保存图片
		echo '<hr />';
        $fileInfos = explode('/',$fileName);
		var_dump($fileInfos);
        //得到了纯纯的文件名
        $oldFileName = array_pop($fileInfos);
        //得到了纯纯的文件名和后缀名
        $newFileInfos = explode('.',$oldFileName);
        //新生成的文件名
        $newFileName = $newFileInfos[0].'_s'.'.'.array_pop($newFileInfos);
		//获取生成文件路径
		echo $newFileName;
        //生成文件
        $outPut($nImg,$newFileName);
		
        //销毁资源
        imagedestroy($nImg);
        imagedestroy($oImg);
    }
	
	/*----------------------------------3、图像缩放  imageZoom() 结束------------------------------------------*/
	/*----------------------------------4、网站开关  webSwitch() 开始------------------------------------------*/
	function webSwitch($webSwitch){
		if($webSwitch == 'OFF'){
			exit('<h1 style="position:absolute;top:35%;left:30%;font-size:45px;">网页正在维护中。。。</h1>');
		}
	}
	/*----------------------------------4、网站开关  imageZoom() 结束------------------------------------------*/
?>